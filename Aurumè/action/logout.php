<?php
    session_start();  // Riprende la sessione esistente
    session_unset();  // Cancella tutte le variabili di sessione
    session_destroy();  // Distrugge la sessione

    header("Location: ../autenticazione.php"); // Reindirizza alla pagina di login/registrazione
    exit();
?>
