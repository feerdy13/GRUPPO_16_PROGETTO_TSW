<?php
    require 'includes/controllo.php'; // Controllo autenticazione
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Dashboard</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h2>Benvenuto, <?php echo htmlspecialchars($_SESSION["user_name"], ENT_QUOTES, 'UTF-8'); ?>!</h2>
        <a href="action/logout.php">Logout</a>
    </body>
</html>
