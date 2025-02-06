<?php
    session_start();
    require '../includes/database.php';

    if (isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];

        if (isset($_SESSION['user_id'])) {
            // Utente loggato: il prodotto viene inserito nel carrello tramite database
            $user_id = $_SESSION['user_id'];

            // Verifica se il prodotto è già presente nel carrello
            $query_check = "SELECT quantita 
                            FROM carrello 
                            WHERE id_utente = $1 AND id_prodotto = $2";
            pg_prepare($conn, "check_carrello", $query_check);
            $result_check = pg_execute($conn, "check_carrello", array($user_id, $product_id));

            if ($row = pg_fetch_assoc($result_check)) {
                // Il prodotto è già presente nel carrello, ne incremento la quantità
                $quantita = $row['quantita'] + 1;
                $query = " UPDATE carrello 
                            SET quantita = $1 
                            WHERE id_utente = $2 AND id_prodotto = $3";
                pg_prepare($conn, "aggiorna_carrello", $query);
                pg_execute($conn, "aggiorna_carrello", array($quantita, $user_id, $product_id));
            } else {
                // Il prodotto non è presente, lo aggiungo al carrello
                $query = "INSERT INTO carrello (id_utente, id_prodotto)
                            VALUES ($1, $2)";
                pg_prepare($conn, "aggiungi_al_carrello", $query);
                pg_execute($conn, "aggiungi_al_carrello", array($user_id, $product_id));
            }
        }
    }
?>

    

