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
                <div class="online-support">
                    <div class="day">Lunedì:</div>      <div class="time">9:00 - 19:00</div>
                    <div class="day">Martedì:</div>     <div class="time">9:00 - 19:00</div>
                    <div class="day">Mercoledì:</div>   <div class="time">solo in ricezione</div>
                    <div class="day">Giovedì:</div>     <div class="time">9:00 - 19:00</div>
                    <div class="day">Venerdì:</div>     <div class="time">9:00 - 19:00</div>
                    <div class="day">Sabato:</div>      <div class="time">9:00 - 13:00</div>
                </div>
            </div>
        </div>
    </main>
            
    <!-- Include the footer -->
    <?php include 'includes/footer.html'; ?>
