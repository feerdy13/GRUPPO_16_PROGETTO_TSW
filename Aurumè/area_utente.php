<!-- Header -->
<?php 
    session_start();
    require 'includes/database.php';

    /* SEZIONE PER MODIFICARE NEL DB LE INFORMAZIONI DELL'UTENTE */
    // Controlla se è stata inviata la richiesta per aggiornare il profilo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_profile"])) {
    // Recupera i dati inviati dal form
    $new_name  = trim($_POST["name"]);
    $new_email = trim($_POST["email"]);

    // Validazione base
    $errors = array();
    if (strlen($new_name) < 3) {
        $errors[] = "Il nome deve avere almeno 3 caratteri.";
    }
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email inserita non è valida.";
    }

    if (!empty($errors)) {
        // Se ci sono errori, li salvi in sessione e reindirizzi l'utente indietro
        $_SESSION['error'] = implode("<br>", $errors);
        header("Location: area_utente.php");
        exit();
    }

    // Ottieni l'ID dell'utente dalla sessione
    $user_id = $_SESSION["user_id"];

    // Esegui la query per aggiornare il nome e l'email nel database
    $query = "UPDATE utenti SET name = $1, email = $2 WHERE id = $3";
    $stmt  = pg_prepare($conn, "update_profile", $query);
    $result = pg_execute($conn, "update_profile", array($new_name, $new_email, $user_id));

    if (pg_affected_rows($result) > 0) {
        // Aggiorna anche le variabili di sessione
        $_SESSION["user_name"]  = $new_name;
        $_SESSION["user_email"] = $new_email;
        $alertMessage =  "Profilo aggiornato correttamente. Per sicurezza devi effettuare nuovamente il login.";

        session_destroy();
        
        session_start();
        $_SESSION['alert'] = $alertMessage;
        
        header("Location: autenticazione.php");
        exit();
    } else {
        $_SESSION['error'] = "Nessuna modifica apportata o errore nell'aggiornamento del profilo.";
        header("Location: area_utente.php");
        exit();
    }

    // Reindirizza l'utente all'area utente per evitare il re-invio del form
    header("Location: area_utente.php");
    exit();
    }


    $title = 'Area utente';
    $cssFile = 'resources/css/area_utente.css';
    include 'includes/header.php'; 
?>

<main>
    <h2>Il mio account Aurumè</h2>

    <button id="toggle-account-btn">Il mio account</button>

    <div class="container-element">
        <div class="info-personali">
            <h3>Informazioni personali</h3>
            <form id="personal-info-form" method="POST" action="area_utente.php">
                <!--campo nascosto per identificare il form-->
                <input type="hidden" name="update_profile" value="true">

                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>" required>
                <button type="submit">Salva</button>
            </form>
        </div>

        <div class="credenziali">
            <h3>Credenziali</h3>
            <form id="credentials-form" method="POST" action="update_password.php">
                <label for="current-password">Password attuale:</label>
                <input type="password" id="current-password" name="current-password" required>
                <label for="new-password">Nuova password:</label>
                <input type="password" id="new-password" name="new-password" required>
                <button type="submit">Cambia password</button>
            </form>
        </div>

        <div class="indirizzo-consegna">
            <h3>Indirizzo di consegna</h3>
            <form id="address-form" method="POST" action="update_address.php">
                <label for="address">Indirizzo:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($_SESSION['user_address']); ?>" required>
                <label for="city">Città:</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($_SESSION['user_city']); ?>" required>
                <label for="postal-code">CAP:</label>
                <input type="text" id="postal-code" name="postal-code" value="<?php echo htmlspecialchars($_SESSION['user_postal_code']); ?>" required>
                <button type="submit">Salva indirizzo</button>
            </form>
        </div>
    </div>
    
</main>


<!-- Footer -->
<?php include 'includes/footer.html'; ?>

<!-- Script -->
<script src="resources/js/area_utente.js"></script>