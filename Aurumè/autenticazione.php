<?php
    require 'includes/database.php';  // Assicura che $conn sia disponibile
    session_start();

    $showForm = isset($_GET["register"]) ? "register" : "login";

    // REGISTRAZIONE
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);
        // Validazione lato server
        $errors = [];

        if (strlen($name) < 3) {
            $errors[] = "Il nome deve contenere almeno 3 caratteri.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'email inserita non è valida.";
        }

        if (strlen($password) < 6) {
            $errors[] = "La password deve contenere almeno 6 caratteri.";
        }

        if (!empty($errors)) {
            $_SESSION['error'] = "<i class=\"fi fi-rr-exclamation icon-spacing\"></i> " . implode("<br>", $errors);
            header("Location: autenticazione.php?register");
            exit();
        }
        
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        // Prepariamo la query per evitare SQL Injection
        $query = "INSERT INTO utenti (name, email, password) VALUES ($1, $2, $3)";
        $stmt = pg_prepare($conn, "utente_registrato", $query);

        // Invia la query senza eseguirla immediatamente
        pg_send_execute($conn, "utente_registrato", array($name, $email, $password));
    
        // Ottieni il risultato della query
        $result = pg_get_result($conn);

        // Controlla se ci sono errori
        if (pg_result_status($result) !== PGSQL_COMMAND_OK) {
            $errorMessage = pg_result_error($result);

            // Controlliamo se l'errore è dovuto a una violazione UNIQUE (email già registrata)
            if (strpos($errorMessage, "utenti_email_key") !== false) {
                $_SESSION['error'] = "<i class=\"fi fi-rr-exclamation icon-spacing\"></i> Account già esistente. Usa un'altra email o accedi.";
            } else {
                $_SESSION['error'] = "<i class=\"fi fi-rr-exclamation icon-spacing\"></i> Errore nella registrazione: " . htmlspecialchars($errorMessage);
            }
        } else {
            $_SESSION['alert'] = "Registrazione completata! Accedi ora.";
            header("Location: autenticazione.php?success=registered");
            exit();
        }
    }

    // LOGIN
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        // Prepariamo la query per cercare l'utente
        $query = "SELECT id, name, email, password FROM utenti WHERE email = $1";
        $stmt = pg_prepare($conn, "utente_loggato", $query);
        $result = pg_execute($conn, "utente_loggato", array($email));

        if ($row = pg_fetch_assoc($result)) {
            // Verifica la password
            if (password_verify($password, $row["password"])) {
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["user_name"] = $row["name"];
                $_SESSION["user_email"] = $row["email"];
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
    $alert = isset($_SESSION['alert']) ? $_SESSION['alert'] : '';

    unset($_SESSION['error']);
    unset($_SESSION['alert']);
?>

    <!-- Header -->
    <?php
        $title = 'Autenticazione';
        $cssFile = 'resources/css/autenticazione.css';
        include 'includes/header.php'; 
    ?>

    <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert">
            <?php 
            echo htmlspecialchars($_SESSION['alert']); 
            unset($_SESSION['alert']); // Rimuove il messaggio una volta visualizzato
            ?>
        </div>
    <?php endif; ?>
    


    <!-- alert -->
    <div id="alert-container" class="alert-container"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (!empty($alert)) { ?>
                showAlert('<?php echo $alert; ?>');
            <?php } ?>
        });
    </script>
    


    <main>

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
                <div class="alert-error <?php echo empty($error) ? 'hidden' : ''; ?>"><?php echo $error; ?></div>
                <label>Nome:</label> <input type="text" name="name" required><br>
                <label>Email:</label> <input type="email" name="email" required><br>
                <label>Password:</label> <input type="password" name="password" required><br>
                <input type="submit" name="register" value="REGISTRATI">
            </form>
            <p>Hai già un account? <a href="autenticazione.php" class="button">ACCEDI</a></p>
        </div>

    </main>


    <!-- Script per mostrare alert -->
    <script src="resources/js/showAlert.js"></script>

    <!-- Script per validazione form -->
    <script src="resources/js/autenticazione.js"></script>

    <?php pg_close($conn); ?>

    <!-- Footer -->
    <?php include 'includes/footer.html'; ?>