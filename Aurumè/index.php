    <?php
    // Avvia la sessione
    session_start();
    ?>
    
    <!-- Header -->
    <?php 
        $title = 'Homepage';
        $cssFile = 'resources/css/index.css';
        include 'includes/header.php'; 
    ?>

    <main>
        <div class="video-container hidden">
            <video class="video-home" src="resources/img/jewellery.mp4" autoplay loop muted></video>
        </div>

        <?php 
            if(isset($_SESSION["user_id"])) {
                echo '<div class="heading hidden">
                        <h1>Benvenuto ' . $_SESSION["user_name"] . '</h1>
                        <a href="catalogo.php" class="shop-button">Scopri la collezione</a>
                    </div>';
            } else {
                echo '<div class="heading hidden">
                        <h1>Benvenuti in Aurumè</h1>
                        <a href="catalogo.php" class="shop-button">Scopri la collezione</a>
                    </div>';
            }
        ?>

        <div class="highlights-container hidden">
            <div class="highlight reverse hidden">
                <img src="resources/img/highligth1.jpg" alt="Highlight 1" class="highlight-image1">
                <div class="highlight-text">
                    <h2 class="highlight-title">Lui o Lei</h2>
                    <p class="highlight-p">Se stai cercando un pezzo unico per te o per la tua metà, sei nel posto giusto. 
                        Aurumè ti dà l'opportunità di scegliere tra tantissimi prodotti tutti di alta qualità, 
                        fatti da artigiani specializzati nel settore.</p>
                </div>
            </div>

            <div class="highlight hidden">
                <img src="resources/img/highligth2.jpg" alt="Highlight 2" class="highlight-image2">
                <div class="highlight-text">
                    <h2 class="highlight-title">Eleganza senza tempo</h2>
                    <p class="highlight-p">La nostra collezione offre gioielli che combinano design moderno e tradizione artigianale,
                         perfetti per ogni occasione. Scopri pezzi unici che esprimono eleganza e 
                         raffinatezza.</p>
                </div>
            </div>
        </div>

        <!-- Prima sezione immagine statica con link all'interno -->
        <div class="section-image hidden">
            <a href="catalogo.php">
                <img src="resources/img/gold_jewels.jpg" alt="Gioielli in oro">
                <div class="overlay-text-one">
                    <h2>Gioielli in Oro</h2>
                    <p>Scopri la nostra collezione</p>
                </div>
            </a>
        </div>

        <!-- Prima sezione immagine statica con link all'interno -->
        <div class="section-image hidden">
            <a href="catalogo.php">
                <img src="resources/img/watch.jpeg" alt="Orologi">
                <div class="overlay-text-one">
                    <h2>Il tempo è prezioso</h2>
                    <p>Scopri il tuo nuovo orologio perfetto</p>
                </div>
            </a>
        </div>

        <!-- Contenitore per lo scroll orizzontale delle immagini -->
        <div class="image-scroll-wrapper hidden">
            <div class="text-gallery-container">
                <p class="text-gallery">La nostra galleria</p>
                <button class="scroll-button left">&lt;</button>
                <button class="scroll-button right">&gt;</button>
            </div>
            <div class="image-scroll-container">
                <div class="image-scroll">
                    <img src="resources/img/gioielliindossati1.jpg" alt="Immagine 1">
                    <img src="resources/img/gioielliindossati2.jpg" alt="Immagine 2">
                    <img src="resources/img/gioielliindossati3.jpg" alt="Immagine 3">
                    <img src="resources/img/gioielliindossati4.jpg" alt="Immagine 4">
                    <img src="resources/img/gioielliindossati5.jpg" alt="Immagine 5">
                    <img src="resources/img/gioielliindossati6.jpg" alt="Immagine 6">
                    <img src="resources/img/gioielliindossati7.jpg" alt="Immagine 7">
                    <img src="resources/img/gioielliindossati8.jpg" alt="Immagine 8">
                </div>
            </div>
        </div>

        <!-- Seconda sezione immagine statica con link all'interno -->
        <div class="section-image hidden">
            <a href="la_nostra_storia.php">
                <img src="resources/img/gruppo.jpg" alt="La nostra storia">
                <div class="overlay-text-two">
                    <p>La nostra storia</p>
                </div>
            </a>
        </div>

        <?php 
            if(!isset($_SESSION["user_name"])) 
                echo '<div class="authentication-container hidden">
                        <h2>Entra nell\'universo Aurumé</h2>
                        <div class="authentication-content">
                            <p>Scopri le sue meravigliose icone e le esperienze uniche</p>
                            <a href="autenticazione.php?register" class="button" id="show-register">CREA ACCOUNT</a>
                        </div>
                    </div>';
        ?>

    </main>

    <!-- Pulsante per inviare email -->
    <div class="email-button-container">
        <a href="mailto:aurumegioielli@gmail.com" class="email-button">Contattaci</a>
    </div>

    <!-- JavaScript per l'effetto di scorrimento dinamico -->
    <script src="resources/js/index.js"></script>

    <!-- JavaScript per lo scroll orizzontale -->
    <script src="resources/js/scroll.js"></script>

    <!-- Footer -->
    <?php include 'includes/footer.html'; ?>