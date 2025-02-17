<?php
    session_start();
    require '../includes/database.php';


    if (isset($_SESSION['user_id'])) {
            // Utente loggato
            $user_id = $_SESSION['user_id'];

            /* Calcolo il totale del carrello lato server */
            $query_total = "SELECT SUM(p.prezzo * c.quantita) AS total
                            FROM carrello c 
                            JOIN prodotti p ON c.id_prodotto = p.id 
                            WHERE c.id_utente = $1";
            pg_prepare($conn, "calcola_totale", $query_total);
            $result_total = pg_execute($conn, "calcola_totale", array($user_id));
            $totale = pg_fetch_result($result_total, 0, 'total');

            /* Recupero le informazioni sul carrello */
            $query_carrello = "SELECT id_prodotto, quantita 
                                FROM carrello 
                                WHERE id_utente = $1";
            pg_prepare($conn, "recupera_carrello", $query_carrello);
            $result_carrello = pg_execute($conn, "recupera_carrello", array($user_id));

            /* Inserisco l'ordine nel database e recupero il suo id */
            $query_ordine = "INSERT INTO ordini (id_utente, totale)
                            VALUES ($1, $2)
                            RETURNING id";
            pg_prepare($conn, "registra_ordine", $query_ordine);
            $result_ordine = pg_execute($conn, "registra_ordine", array($user_id, $totale));
            $id_ordine = pg_fetch_result($result_ordine, 0, 'id');

            /* Inserisco i dettagli dell'ordine nel database */
            $query_dettagli = "INSERT INTO dettagli_ordine (id_ordine, id_prodotto, quantita)
                                VALUES ($1, $2, $3)";
            pg_prepare($conn, "inserisci_dettaglio_ordine", $query_dettagli);
            // Per ogni prodotto nel carrello, inseriamo una riga nei dettagli
            while ($prodotto = pg_fetch_assoc($result_carrello)) {
                pg_execute($conn, "inserisci_dettaglio_ordine", array(
                    $id_ordine,
                    $prodotto['id_prodotto'],
                    $prodotto['quantita']
                ));
            }

            /* Svuoto il carrello */
            $query_delete = "DELETE FROM carrello
                                WHERE id_utente = $1";
            pg_prepare($conn, "svuota_carrello", $query_delete);
            pg_execute($conn, "svuota_carrello", array($user_id));
    }
    

    header('Location: ../carrello.php');
    exit();
?>