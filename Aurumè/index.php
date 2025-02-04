    <!-- Include the header -->
    <?php 
        $title = 'Homepage';
        $cssFile = 'resources/css/index.css';
        include 'includes/header.php'; 
    ?>

    <main>
        <video class="video-home" src="resources/img/jewellery.mp4" autoplay loop muted></video>

        <div class="heading">
            <h1>Benvenuti in Aurumè</h1>
            <p>Scopri la nostra collezione di gioielli in oro e pietre preziose</p>
            <a href="catalogo.php" class="shop-button">Scopri la collezione</a>
        </div>

        <div class="highlights-container">
            <div class="highlight">
                <img src="resources/img/highligth1.jpg" alt="Highlight 1" class="highlight-image1">
                <div class="text1">
                    <h2 class="title1">LUI o LEI</h2>
                    <p class="paragrafo1">Se stai cercando un pezzo unico per te o per la tua metà, sei nel posto giusto. 
                        Aurumè ti dà l'opportunità di scegliere tra tantissimi prodotti tutti di alta qualità, 
                        fatti da artigiani specializzati nel settore.</p>
                </div>
            </div>

            <div class="highlight reverse">
                <img src="resources/img/highligth2.jpg" alt="Highlight 2" class="highlight-image2">
                <div class="text2">
                    <h2 class="title2">Eleganza senza tempo</h2>
                    <p class="paragrafo2">La nostra collezione offre gioielli che combinano design moderno e tradizione artigianale,
                         perfetti per ogni occasione. Scopri pezzi unici che esprimono eleganza e 
                         raffinatezza.</p>
                </div>
            </div>
        </div>

        <!-- Contenitore per lo scroll orizzontale delle immagini -->
        <div class="image-scroll-wrapper">
            <button class="scroll-button left">&lt;</button>
            <button class="scroll-button right">&gt;</button>
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
    </main>

    <!-- Pulsante per inviare email -->
    <div class="email-button-container">
        <a href="mailto:aurume@gmail.com" class="email-button">Contattaci</a>
    </div>

    <!-- JavaScript per lo scroll orizzontale -->
    <script src="resources/js/scroll.js"></script>

    <!-- Include the footer -->
    <?php include 'includes/footer.html'; ?>