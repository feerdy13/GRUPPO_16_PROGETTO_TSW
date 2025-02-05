<?php
    session_start();
    require '../includes/database.php';

    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        if (isset($_SESSION['user_id'])) {
            // Utente loggato: il prodotto viene inserito nel carrello tramite database
            $user_id = $_SESSION['user_id'];
            $query = "INSERT INTO carrello (id_utente, id_prodotto)
                        VALUES ($1, $2)";
            pg_prepare($conn, "aggiungi_al_carrello", $query);
            pg_execute($conn, "aggiungi_al_carrello", array($user_id, $product_id));
        } else {
            // Utente non loggato: il prodotto viene inserito nel carrello tramite sessione
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }
            if (!in_array($product_id, $_SESSION['cart'])) {
                $_SESSION['cart'][] = $product_id;
            }
        }
    }

    header('Location: ../catalogo.php');
    exit();

    

