<?php
    require 'includes/database.php';  // Assicura che $conn sia disponibile
    session_start();

    $showForm = isset($_GET["register"]) ? "register" : "login";

    // REGISTRAZIONE
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        
        // Prepariamo la query per evitare SQL Injection
        $query = "INSERT INTO utenti (name, email, password) VALUES ($1, $2, $3)";
        $stmt = pg_prepare($conn, "utente_registrato", $query);
        $result = pg_execute($conn, "utente_registrato", array($name, $email, $password));

        if ($result) {
            $_SESSION['success'] = "Registrazione completata! Accedi ora.";
            header("Location: autenticazione.php?success=registered");
            exit();
        } else {
            $_SESSION['error'] = "Errore nella registrazione: " . pg_last_error($conn);
        }
    }

    // LOGIN
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        // Prepariamo la query per cercare l'utente
        $query = "SELECT id, name, password FROM utenti WHERE email = $1";
        $stmt = pg_prepare($conn, "utente_loggato", $query);
        $result = pg_execute($conn, "utente_loggato", array($email));

        if ($row = pg_fetch_assoc($result)) {
            // Verifica la password
            if (password_verify($password, $row["password"])) {
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["user_name"] = $row["name"];
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['error'] = "<i class=\"fi fi-rr-exclamation icon-spacing\"></i> Nome utente o password errati, riprova.";
            }
        } else {
            $_SESSION['error'] = "<i class=\"fi fi-rr-exclamation icon-spacing\"></i> Nome utente o password errati, riprova.";
        }
    }

    $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
    $success = isset($_SESSION['success']) ? $_SESSION['success'] : '';

    unset($_SESSION['error']);
    unset($_SESSION['success']);
?>

    <!-- Header -->
    <?php
        $title = 'Autenticazione';
        $cssFile = 'resources/css/autenticazione.css';
        include 'includes/header.php'; 
    ?>

    <?php if (!empty($success)): ?>
        <div id="success-alert" class="alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <!-- Form di LOGIN -->
    <div id="login-form" class="form-container <?php echo ($showForm == 'login') ? 'active' : ''; ?>">
        <form method="POST">
            <h2>Ho già un account</h2>
            <div class="alert-error <?php echo empty($error) ? 'hidden' : ''; ?>"><?php echo $error; ?></div>
            <label>Email:</label> <input type="email" name="email" required><br>
            <label>Password:</label> <input type="password" name="password" required><br>
            <input type="submit" name="login" value="ACCEDI">
        </form>
        <p>Non sei ancora membro? Scopri i nostri vantaggi<a href="?register" class="button">CREA  ACCOUNT</a></p>
    </div>

    <!-- Form di REGISTRAZIONE -->
    <div id="register-form" class="form-container <?php echo ($showForm == 'register') ? 'active' : ''; ?>">
        <form method="POST">
            <h2>Registrazione</h2>
            <label>Nome:</label> <input type="text" name="name" required><br>
            <label>Email:</label> <input type="email" name="email" required><br>
            <label>Password:</label> <input type="password" name="password" required><br>
            <input type="submit" name="register" value="REGISTRATI">
        </form>
        <p>Hai già un account? <a href="autenticazione.php" class="button">ACCEDI</a></p>
    </div>

    <script src="resources/js/autenticazione.js"></script>

    <?php pg_close($conn); ?>

    <!-- Footer -->
    <?php include 'includes/footer.html'; ?>