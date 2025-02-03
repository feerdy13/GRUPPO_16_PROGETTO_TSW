<?php
    $host = "localhost";
    $dbname = "gruppo16";
    $user = "www";
    $pass = "tw2024";

    // Connessione a PostgreSQL
    $conn = pg_connect("host=$host dbname=$dbname user=$user password=$pass");

    // Controllo connessione
    if (!$conn) {
        die("Errore di connessione al database: " . pg_last_error());
    }
?>