<?php
    require '../includes/database.php';  // Assicura che $conn sia disponibile
    session_start();

    $showForm = isset($_GET["register"]) ? "register" : "login";

    // REGISTRAZIONE
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        var_dump($name, $email, $password);  // Aggiungi questa riga per verificare i valori
        
        // Prepariamo la query per evitare SQL Injection
        $query = "INSERT INTO utenti_registrati (name, email, password) VALUES ($1, $2, $3)";
        $stmt = pg_prepare($conn, "utente_registrato", $query);
        $result = pg_execute($conn, "utente_registrato", array($name, $email, $password));

        if ($result) {
            header("Location: auth.php?success=registered");
            exit();
        } else {
            $error = "Errore nella registrazione: " . pg_last_error($conn);
        }
    }

    // LOGIN
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        // Prepariamo la query per cercare l'utente
        $query = "SELECT id, name, password FROM users WHERE email = $1";
        $stmt = pg_prepare($conn, "login_user", $query);
        $result = pg_execute($conn, "login_user", array($email));

        if ($row = pg_fetch_assoc($result)) {
            // Verifica la password
            if (password_verify($password, $row["password"])) {
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["user_name"] = $row["name"];
                header("Location: ../dashboard.php");
                exit();
            } else {
                $error = "Password errata!";
            }
        } else {
            $error = "Email non trovata!";
        }
    }
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Login & Registrazione</title>
        <style>
            .form-container { display: none; }
            .active { display: block; }
        </style>
    </head>
    <body>

    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <?php if (isset($_GET["success"]) && $_GET["success"] == "registered") echo "<p style='color: green;'>Registrazione completata! Accedi ora.</p>"; ?>

    <!-- Form di LOGIN -->
    <div id="login-form" class="form-container <?php echo ($showForm == 'login') ? 'active' : ''; ?>">
        <h2>Login</h2>
        <form method="POST">
            <label>Email:</label> <input type="email" name="email" required><br>
            <label>Password:</label> <input type="password" name="password" required><br>
            <input type="submit" name="login" value="Accedi">
        </form>
        <p>Non hai un account? <a href="?register">Registrati</a></p>
    </div>

    <!-- Form di REGISTRAZIONE -->
    <div id="register-form" class="form-container <?php echo ($showForm == 'register') ? 'active' : ''; ?>">
        <h2>Registrazione</h2>
        <form method="POST">
            <label>Nome:</label> <input type="text" name="name" required><br>
            <label>Email:</label> <input type="email" name="email" required><br>
            <label>Password:</label> <input type="password" name="password" required><br>
            <input type="submit" name="register" value="Registrati">
        </form>
        <p>Hai già un account? <a href="autenticazione.php">Accedi</a></p>
    </div>

    </body>
</html>