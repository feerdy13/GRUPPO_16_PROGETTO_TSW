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
                <p class="email-info">Siamo qui per aiutarti! Se hai domande, richieste o necessiti di assistenza, non esitare a contattarci. Il nostro team di supporto è a tua disposizione per fornirti tutte le informazioni di cui hai bisogno.</p>
                <p class="email"><a href="mailto:info@aurume.com">Inviaci una email</a></p>
            </div>

            <div class="contacts">
                <h2>Visita il nostro profilo social</h2>
                <p class="instagram-info">Seguici sui nostri canali social per rimanere aggiornato sulle ultime novità e promozioni.</p>
                <p class="instagram"><a href="https://www.instagram.com/yourprofile">Visita il nostro Instagram</a></p>
            </div>

            <div class="contacts">
                <h2>Orari supporto online</h2>
                <table class="hours-table">
                    <tr>
                        <td class="day">Lunedì:</td>
                        <td class="time">9:00 - 19:00</td>
                    </tr>
                    <tr>
                        <td class="day">Martedì:</td>
                        <td class="time">9:00 - 19:00</td>
                    </tr>
                    <tr>
                        <td class="day">Mercoledì:</td>
                        <td class="time">solo in ricezione</td>
                    </tr>
                    <tr>
                        <td class="day">Giovedì:</td>
                        <td class="time">9:00 - 19:00</td>
                    </tr>
                    <tr>
                        <td class="day">Venerdì:</td>
                        <td class="time">9:00 - 19:00</td>
                    </tr>
                    <tr>
                        <td class="day">Sabato:</td>
                        <td class="time">9:00 - 13:00</td>
                    </tr>
                </table>
            </div>
        </div>

        <table class="visit-table">
            <tr>
                <td>
                    <img class="visit-image" src="resources/img/aurumè_shop_mod.jpg" alt="assistenza" >
                </td>
                <td>
                    <h2>Vieni a trovarci in Boutique!</h2>
                    <p>
                    Il nostro team di esperti sarà lieto di assisterti e consigliarti nella 
                    scelta dei tuoi gioielli preferiti. Vieni a trovarci per un'esperienza di 
                    shopping unica e personalizzata. 
                    Ti aspettiamo nella nostra boutique per scoprire le ultime collezioni e le 
                    offerte esclusive. 
                    </p>

                    <p>
                        Ci troviamo <a href="https://maps.app.goo.gl/73L1ic2gxmTjmFTn6">qui.</a>
                    </p>
                </td>
            </tr>
        </table>
    </main>
            
    <!-- Include the footer -->
    <?php include 'includes/footer.html'; ?>
