<!-- Include the header -->
    <?php 
        $title = 'FAQ';
        $cssFile = 'resources/css/faq.css';
        include 'includes/header.php'; 
    ?>

    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>

    <main>
        <h1>DOMANDE FREQUENTI</h1>

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
        <h2 class="contattaci">Non hai trovato risposta alla tua domanda? Contattaci.</h2>
        <div class="contatti">
            <div class="email">E-mail: <a href="">...</a></div> 
            <div class="instagram">Instagram: <a href="">...</a></div>
        </div>
    </main>

    

    <!-- Include the footer -->
    <?php include 'includes/footer.html'; ?>