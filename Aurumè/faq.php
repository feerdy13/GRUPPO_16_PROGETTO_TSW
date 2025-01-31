    <!-- Include the header -->
    <?php 
        $title = 'FAQ';
        $cssFile = 'resources/css/faq.css';
        include 'includes/header.php'; 
    ?>


    <main>
        <h1 class="heading">Domande Frequenti</h1>

        <div class="grid-container">
            <div class="grid-item">
                <!-- Icona delle informazioni sull'ordine -->
                <i class="fi fi-rr-info"></i>
                <div>Informazioni sull'ordine</div>
            </div>
            <div class="grid-item">
                <!-- Icona del camioncino -->
                <i class="fi fi-rs-truck-side"></i>
                <div>Spedizioni</div>
            </div>
            <div class="grid-item">
                <!-- Icona del reso -->
                <i class="fi fi-ss-restock"></i>
                <div>Reso e cambio</div>
            </div>
            <div class="grid-item">
                <!-- Icona dello scudo per garanzia -->
                <i class="fi fi-rr-shield-check"></i>
                <div>Garanzie</div>
            </div>
        </div>
        <h2 class="contact">Non hai trovato risposta alla tua domanda? <a href="contatti.php">Contattaci</a></h2>
    </main>

    

    <!-- Include the footer -->
    <?php include 'includes/footer.html'; ?>