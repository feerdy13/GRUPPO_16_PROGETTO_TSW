<!--File per gestire la terminazione della sessione e il reindirizzamento-->
<?php
session_start();
session_unset();
session_destroy();
header("Location: autenticazione.php");
exit();