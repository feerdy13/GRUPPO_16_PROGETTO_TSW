<?php 
    require 'includes/database.php';
    require 'includes/controllo.php';
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_profile"])) {
        session_start();
        $user_id = $_SESSION["user_id"];
        
        $new_name = trim($_POST["name"]);
        $new_email = trim($_POST["email"]);
        $current_password = trim($_POST["current-password"]);
        $new_password = trim($_POST["new-password"]);
    
        $errors = [];
    
        // Ottieni i dati attuali dell'utente
        $query = "SELECT name, email, password FROM utenti WHERE id = $1";
        $stmt = pg_prepare($conn, "get_user", $query);
        
        if (!$stmt) {
            $_SESSION["error"] = "Errore nella preparazione della query.";
            header("Location: area_utente.php");
            exit();
        }
    
        $result = pg_execute($conn, "get_user", array($user_id));
        $user = pg_fetch_assoc($result);
    
        if (!$user) {
            $_SESSION["error"] = "Utente non trovato.";
            header("Location: autenticazione.php");
            exit();
        }
    
        $current_name = $user["name"];
        $current_email = $user["email"];
        $hashed_password = $user["password"];
    
        // Validazione solo sui campi modificati
        if (!empty($new_name) && $new_name !== $current_name && strlen($new_name) < 3) {
            $errors[] = "Il nome deve contenere almeno 3 caratteri.";
        }
    
        if (!empty($new_email) && $new_email !== $current_email) {
            if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "L'email inserita non è valida.";
            } else {
                // Controlla se l'email è già in uso
                $query = "SELECT id FROM utenti WHERE email = $1 AND id <> $2";
                $stmt = pg_prepare($conn, "check_email", $query);
                if (!$stmt) {
                    $_SESSION["error"] = "Errore nella preparazione della query.";
                    header("Location: area_utente.php");
                    exit();
                }
                $result = pg_execute($conn, "check_email", array($new_email, $user_id));
                if (pg_num_rows($result) > 0) {
                    $errors[] = "L'email è già in uso.";
                }
            }
        }
    
        if (!empty($new_password)) {
            if (!password_verify($current_password, $hashed_password)) {
                $errors[] = "<i class=\"fi fi-rr-exclamation icon-spacing\"></i><span>La password attuale è errata.</span>";
            } elseif (strlen($new_password) < 6 || 
                      !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $new_password) || 
                      !preg_match('/[0-9]/', $new_password) || 
                      !preg_match('/[a-zA-Z]/', $new_password)) {
                $errors[] = "La nuova password deve contenere almeno 6 caratteri, un carattere speciale, un numero e una lettera.";
            }
        }
    
        if (!empty($errors)) {
            $_SESSION['error'] = implode("<br>", $errors);
            header("Location: area_utente.php");
            exit();
        }
    
        // Costruzione della query di aggiornamento
        $update_fields = [];
        $update_values = [];
        $param_count = 1;
    
        if (!empty($new_name) && $new_name !== $current_name) {
            $update_fields[] = "name = $" . $param_count++;
            $update_values[] = $new_name;
            $_SESSION["user_name"] = $new_name;
        }
    
        if (!empty($new_email) && $new_email !== $current_email) {
            $update_fields[] = "email = $" . $param_count++;
            $update_values[] = $new_email;
            $_SESSION["user_email"] = $new_email;
        }
    
        if (!empty($new_password)) {
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_fields[] = "password = $" . $param_count++;
            $update_values[] = $hashed_new_password;
        }
    
        if (!empty($update_fields)) {
            $update_values[] = $user_id;
            $query = "UPDATE utenti SET " . implode(", ", $update_fields) . " WHERE id = $" . $param_count;
            $stmt = pg_prepare($conn, "update_user", $query);
            $result = pg_execute($conn, "update_user", $update_values);
    
            if (pg_affected_rows($result) > 0) {
                $_SESSION['alert'] = "Profilo aggiornato con successo.";
    
                if (!empty($new_password) || (!empty($new_email) && $new_email !== $current_email)) {
                    $_SESSION['alert'] .= " Devi effettuare nuovamente il login.";
                    
                }
            }
        }
    
        header("Location: area_utente.php");
        exit();
    }

    $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
    $alert = '';

    if (isset($_GET['alert']) && !empty($_GET['alert'])) {
        $alert = $_GET['alert'];
    } elseif (isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert'];
    }

    // Se usi la sessione per l'alert, puoi anche rimuoverlo dalla sessione
    unset($_SESSION['error']);
    unset($_SESSION['alert']);

    $title = 'Area utente';
    $cssFile = 'resources/css/area_utente.css';
    include 'includes/header.php'; 
?>

    <!-- alert -->
    <div class="alert-container"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (!empty($alert)) { ?>
                showAlert('<?php echo $alert; ?>');
            <?php } ?>
        });
    </script>

<main>
    <h2>Il mio account Aurumè</h2>
        <div class="info-personali">
            <form id="personal-info-form" method="POST" action="area_utente.php">
                <h3>Informazioni personali</h3>
                <div class="alert-error <?php echo empty($error) ? 'hidden' : ''; ?>"><?php echo $error; ?></div>
                <label for="name">Nome:</label><input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" minlength="3" maxlength="8">
                <label for="email">Email:</label><input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>">
                <label for="current-password">Password attuale:</label><input type="password" id="current-password" name="current-password">
                <label for="new-password">Nuova password:</label><input type="password" id="new-password" name="new-password">
                <input type="submit" value="Salva modifiche">
            </form>
        </div><br>
        <!--
        <div class="indirizzo-consegna">
            <h3>Indirizzo di consegna</h3>
            <form id="address-form" method="POST" action="update_address.php">
                <label for="address">Indirizzo:</label><input type="text" id="address" name="address" value="<?php echo htmlspecialchars($_SESSION['user_address']); ?>" required>
                <label for="city">Città:</label><input type="text" id="city" name="city" value="<?php echo htmlspecialchars($_SESSION['user_city']); ?>" required>
                <label for="postal-code">CAP:</label><input type="text" id="postal-code" name="postal-code" value="<?php echo htmlspecialchars($_SESSION['user_postal_code']); ?>" required>
                <button type="submit">Salva indirizzo</button>
            </form>
        </div> -->
</main>

<!-- Script per mostrare alert -->
<script src="resources/js/showAlert.js"></script>

<!-- Script -->
<script src="resources/js/area_utente.js"></script>

<!-- Footer -->
<?php include 'includes/footer.html'; ?>