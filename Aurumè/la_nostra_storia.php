    <!-- Include the header -->
    <?php 
        $title = 'La nostra storia';
        $cssFile = 'resources/css/la_nostra_storia.css';
        include 'includes/header.php'; 
    ?>
    <main>
        <video class="video" src="resources/img/gold.mp4" autoplay loop muted></video>
        <h1 class="heading">La nostra storia</h1>
        <p class="description">
            Nata nel 2024 dalla visione creativa di quattro giovani designer italiani, Aurumè ha rapidamente conquistato il suo spazio nel mondo della gioielleria di lusso contemporanea. L'incontro tra i fondatori durante un evento presso l'Università degli Studi di Salerno ha dato vita a un progetto che unisce tradizione artigianale e design innovativo, sinonimo di eleganza e raffinatezza. <br><br>
            Ispirato dalla parola latina "aurum", che significa oro, il nostro brand si dedica alla creazione di gioielli di lusso unici e preziosi. Ogni pezzo è realizzato con materiali di altissima qualità e con una meticolosa attenzione ai dettagli, per offrire ai nostri clienti un'esperienza di lusso senza pari. <br><br>
            Aurumè rappresenta l'eccellenza artigianale e il design sofisticato, perfetto per chi desidera distinguersi con stile.
        </p>

        <div class="image-row">
            <div class="image-column">
                <img class="image" src="resources/img/artigiano_mod.jpeg" alt="artigiano">
                <p class="question">Chi siamo?</p>
                <p class="answer">Siamo un gruppo di artigiani appassionati che creano gioielli unici e personalizzati.</p>
            </div>
            <div class="image-column">
                <img class="image" src="resources/img/gioielli.png" alt="gioielli">
                <p class="question">Cosa proponiamo?</p>
                <p class="answer">Offriamo una vasta gamma di gioielli realizzati a mano, utilizzando solo i migliori materiali.</p>
            </div>
            <div class="image-column">
                <img class="image" src="resources/img/pezzi_unici_mod.jpg" alt="perché-sceglierci">
                <p class="question">Perché sceglierci?</p> 
                <p class="answer">Perché ogni nostro pezzo è unico e realizzato da zero a mano con la massima cura e dedizione.</p>
            </div>
        </div>
    </main>  

    <!-- Include the footer -->
    <?php include 'includes/footer.html'; ?>