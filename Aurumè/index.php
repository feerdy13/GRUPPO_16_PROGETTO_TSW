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
                <img src="resources/img/artigiano.jpeg" alt="Highlight 1">
                <div class="text">
                    <h2>Titolo 1</h2>
                    <p>Descrizione della prima immagine.</p>
                </div>
            </div>

            <div class="highlight reverse">
                <img src="resources/img/gioielli.png" alt="Immagine 2">
                <div class="text">
                    <h2>Titolo 2</h2>
                    <p>Descrizione della seconda immagine.</p>
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
                    <img src="resources/img/gioielli.png" alt="Immagine 2">
                    <img src="resources/img/pezzi_unici.webp" alt="Immagine 3">
                    <img src="resources/img/gioielli.png" alt="Immagine 4">
                    <img src="resources/img/artigiano.jpeg" alt="Immagine 1">
                    <img src="resources/img/gioielli.png" alt="Immagine 2">
                    <img src="resources/img/pezzi_unici.webp" alt="Immagine 3">
                    <img src="resources/img/gioielli.png" alt="Immagine 4">
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