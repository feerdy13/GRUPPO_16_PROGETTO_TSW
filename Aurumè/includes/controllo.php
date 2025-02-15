<?php
    session_start();
    
    // Controlla se l'utente è autenticato
    if (!isset($_SESSION["user_id"])) {
        header("Location: autenticazione.php"); // Reindirizzamento alla pagina di login/registrazione
        exit();
    }
?>