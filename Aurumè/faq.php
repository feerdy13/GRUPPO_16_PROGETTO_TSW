<!-- Include the header -->
    <?php 
        $title = 'FAQ';
        $cssFile = 'resources/css/faq.css';
        include 'includes/header.php'; 
    ?>

    <main>
        <h1>DOMANDE FREQUENTI</h1>

        <div class="grid-container">
            <div class="grid-item">
                <i class="fi fi-rs-terms-info"></i>
                <div>Informazioni sull'ordine</div>
            </div>
            <div class="grid-item">
                <i class="fas fa-box-open"></i>
                <div>Spedizioni</div>
            </div>
            <div class="grid-item">
                <i class="fas fa-sync-alt"></i>
                <div>Reso e cambio</div>
            </div>
            <div class="grid-item">
                <i class="fas fa-shield-alt"></i>
                <div>Garanzie</div>
            </div>
        </div>
        <h2 class="contattaci">Non hai trovato risposta alla tua domanda? Contattaci.</h2>
        <div class="contatti">
            <div class="email">E-mail: <a href="">...</a></div> 
            <div class="instagram">Instagram: <a href="">...</a></div>
        </div>
    </main>

    

    <!-- Include the footer -->
    <?php include 'includes/footer.html'; ?>