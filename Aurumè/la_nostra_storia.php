    <!-- Include the header -->
    <?php 
        $title = 'La nostra storia';
        $cssFile = 'resources/css/la_nostra_storia.css';
        include 'includes/header.php'; 
    ?>


    <h2>Il significato del nome del brand</h2>
    <p class="description">
        Aurumè è un nome che deriva dalla parola latina "aurum", che significa oro. <br>
        Abbiamo scelto questo nome perché il nostro obiettivo è quello di creare gioielli unici e preziosi, <br>
        realizzati con materiali di alta qualità e con la massima cura e dedizione.
    </p>

    <div class="image-row">
        <div class="image-column">
            <img src="resources/img/artigiano.jpeg" alt="artigiano">
            <p class="question">Chi siamo?</p>
            <p class="answer">Siamo un gruppo di artigiani appassionati che creano gioielli unici e personalizzati.</p>
        </div>
        <div class="image-column">
            <img src="resources/img/gioielli.png" alt="gioielli">
            <p class="question">Cosa proponiamo?</p>
            <p class="answer">Offriamo una vasta gamma di gioielli realizzati a mano, utilizzando solo i migliori materiali.</p>
        </div>
        <div class="image-column">
            <img src="resources/img/pezzi_unici.webp" alt="perché-sceglierci">
            <p class="question">Perché sceglierci?</p> 
            <p class="answer">Perché ogni nostro pezzo è unico e realizzato da zero a mano con la massima cura e dedizione.</p>
        </div>
    </div>
        

    <!-- Include the footer -->
    <?php include 'includes/footer.html'; ?>