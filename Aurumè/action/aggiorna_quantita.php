<?php
    session_start();
    require '../includes/database.php';

    if (isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
        $update = $_POST['update'];

        if (isset($_SESSION['user_id'])) {
            // Utente loggato: il prodotto viene inserito nel carrello tramite database
            $user_id = $_SESSION['user_id'];

            // Ricavo la quantità attuale del prodotto nel carrello
            $query_check = "SELECT quantita 
                            FROM carrello 
                            WHERE id_utente = $1 AND id_prodotto = $2";
            pg_prepare($conn, "check_quantità", $query_check);
            $result = pg_execute($conn, "check_quantità", array($user_id, $product_id));

            if ($result && pg_num_rows($result) > 0) {
                $quantita = pg_fetch_result($result, 0, 'quantita');
                $nuova_quantita = $quantita + $update;

                if ($nuova_quantita > 0) {
                    // Aggiorno la quantità del prodotto nel carrello
                    $query = "UPDATE carrello 
                                SET quantita = $1 
                                WHERE id_utente = $2 AND id_prodotto = $3";
                    pg_prepare($conn, "aggiorna_carrello", $query);
                    pg_execute($conn, "aggiorna_carrello", array($nuova_quantita, $user_id, $product_id));
                } else {
                    // La quantità è 0, rimuovo il prodotto dal carrello
                    $query = "DELETE FROM carrello 
                                WHERE id_utente = $1 AND id_prodotto = $2";
                    pg_prepare($conn, "rimuovi_prodotto", $query);
                    pg_execute($conn, "rimuovi_prodotto", array($user_id, $product_id));
                }
            }
        }
    }
?>

    

