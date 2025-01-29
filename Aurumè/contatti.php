    <!-- Include the header -->
    <?php 
        $title = 'Contatti';
        $cssFile = 'resources/css/contatti.css';
        include 'includes/header.php'; 
    ?>

        <main>
            <h1>I nostri contatti</h1>
            <div class="container-contatti">
                <div class="email">E-mail</div>
                <div class="instagram">Instagram</div>
            </div>    

            <div class="link-contatti">
                <div class="indirizzo-email">indirizzo email</div>
                <div class="link-instagram"><a href=""></a>profilo instagram</div>
            </div>
            
            <div class="orari">
                <h2>Orari supporto online:</h2>
                <p>Lunedì: 9:00 - 19:00</p>
                <p>Martedì: 9:00 - 19:00 </p>
                <p>Mercoledì: solo in ricezione</p>
                <p>Giovedì: 9:00 - 19:00</p>
                <p>Venerdì: 9:00 - 19:00</p>
                <p>Sabato: 9:00 - 13:00</p>
            </div>
        </main>
            
    <!-- Include the footer -->
    <?php include 'includes/footer.html'; ?>
