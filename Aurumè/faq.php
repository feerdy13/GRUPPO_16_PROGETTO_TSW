<!-- Include the header -->
    <?php 
        $title = 'FAQ';
        $cssFile = 'resources/css/faq.css';
        include 'includes/header.php'; 
    ?>

    <main>
        <h1>DOMANDE FREQUENTI</h1>

        <div class="grid-container">
        <div class="row icons">
            <div class="column"><i class="fas fa-truck"></i></div>
            <div class="column"><i class="fas fa-box-open"></i></div>
            <div class="column"><i class="fas fa-sync-alt"></i></div>
            <div class="column"><i class="fas fa-shield-alt"></i></div>
        </div>
        <div class="row texts">
            <div class="column">Informazioni sull'ordine</div>
            <div class="column">Spedizioni</div>
            <div class="column">Reso e cambio</div>
            <div class="column">Garanzie</div>
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