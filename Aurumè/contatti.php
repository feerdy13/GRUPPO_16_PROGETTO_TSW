    <!-- Include the header -->
    <?php 
        $title = 'Contatti';
        $cssFile = 'resources/css/contatti.css';
        include 'includes/header.php'; 
    ?>

    <main>
        <h1 class="heading">Contatti</h1>

        <div class="contacts-container">
            <div class="contacts">
                <h2>Scrivici via email</h2>
                <p class="email-info">Siamo qui per aiutarti! Se hai domande, richieste 
                    o necessiti di assistenza, non esitare a contattarci. Il nostro team di supporto è a tua disposizione per fornirti tutte le informazioni di cui hai bisogno.</p>
                <p class="email"><a href="mailto:info@aurume.com">Inviaci una email</a></p>
            </div>

            <div class="contacts">
                <h2>Visita il nostro profilo social</h2>
                <p class="instagram-info">Seguici sui nostri canali social per rimanere aggiornato sulle ultime novità e promozioni.</p>
                <p class="instagram"><a href="https://www.instagram.com/yourprofile">Visita il nostro Instagram</a></p>
            </div>

            <div class="contacts">
                <h2>Orari supporto online</h2>
                <p>Lunedì: 9:00 - 19:00</p>
                <p>Martedì: 9:00 - 19:00 </p>
                <p>Mercoledì: solo in ricezione</p>
                <p>Giovedì: 9:00 - 19:00</p>
                <p>Venerdì: 9:00 - 19:00</p>
                <p>Sabato: 9:00 - 13:00</p>
            </div>
        </div>
    </main>
            
    <!-- Include the footer -->
    <?php include 'includes/footer.html'; ?>
