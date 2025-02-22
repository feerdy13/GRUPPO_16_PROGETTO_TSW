<?php
    session_start();  // Riprende la sessione esistente
    session_unset();  // Cancella tutte le variabili di sessione
    session_destroy();  // Distrugge la sessione
    
    // Eliminare i cookie impostandolo con scadenza passata
    setcookie("user_id", "", time() - 3600, "/");
    setcookie("user_name", "", time() - 3600, "/");
    setcookie("user_email", "", time() - 3600, "/");


    header("Location: ../autenticazione.php"); // Reindirizza alla pagina di login/registrazione
    exit();
?>