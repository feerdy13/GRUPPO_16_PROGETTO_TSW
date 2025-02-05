<!-- Header -->
<?php 
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
            <form id="personal-info-form" method="POST" action="update_profile.php">
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

    <form id="logout-form" method="POST" action="logout.php">
        <button type="submit">Logout</button>
    </form>
    
</main>


<!-- Footer -->
<?php include 'includes/footer.html'; ?>

<!-- Script -->
<script src="resources/js/area_utente.js"></script>