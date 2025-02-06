<?php
    session_start();
    require '../includes/database.php';

    if (isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];

        if (isset($_SESSION['user_id'])) {
            // Utente loggato: il prodotto viene inserito nel carrello tramite database
            $user_id = $_SESSION['user_id'];
            $query = "INSERT INTO carrello (id_utente, id_prodotto)
                        VALUES ($1, $2)";
            pg_prepare($conn, "aggiungi_al_carrello", $query);
            pg_execute($conn, "aggiungi_al_carrello", array($user_id, $product_id));

            if ($result) {
                echo "Prodotto aggiunto al carrello!";
            } else {
                echo "Errore nell'aggiunta del prodotto al carrello.";
            }
        } else {
            echo "Utente non loggato.";
        }
    } else {
        echo "ID prodotto non impostato.";
    }
?>

    

