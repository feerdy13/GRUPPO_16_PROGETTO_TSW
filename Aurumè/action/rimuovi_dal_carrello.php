<?php 
    session_start();
    require '../includes/database.php';

    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        if (isset($_SESSION['user_id'])) {
            // Utente loggato: il prodotto viene rimosso dal carrello tramite database
            $user_id = $_SESSION['user_id'];
            $query = "DELETE FROM carrello
                        WHERE id_utente = $1 AND id_prodotto = $2";
            pg_prepare($conn, "rimuovi_dal_carrello", $query);
            pg_execute($conn, "rimuovi_dal_carrello", array($user_id, $product_id));
        }
    }

    header('Location: ../carrello.php');
    exit();