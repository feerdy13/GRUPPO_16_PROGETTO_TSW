    <?php 
        session_start(); 
        require 'includes/database.php';  // Assicura che $conn sia disponibile


        // Query per recuperare i prodotti dal catalogo
        $query = "SELECT id, filename, descrizione, prezzo, categoria 
                    FROM prodotti";
        $result = pg_query($conn, $query);
    ?>


    <!-- Header -->
    <?php
        
        $title = 'Catalogo';
        $cssFile = 'resources/css/catalogo.css';
        include 'includes/header.php'; 
    ?>

    <!-- alert -->
    <div id="alert-container" class="alert-container"></div>


    <main>
        <h1 class="heading">La nostra Collezione</h2>

        <!-- Filtri -->
        <div class="filter-buttons">
            <button onclick="filterProducts('anelli')" class="filter anelli">Anelli</button>
            <button onclick="filterProducts('collane')" class="filter collane">Collane</button>
            <button onclick="filterProducts('bracciali')" class="filter bracciali">Bracciali</button>
            <button onclick="filterProducts('orecchini')" class="filter orecchini">Orecchini</button>
            <button onclick="filterProducts('orologi')" class="filter orologi">Orologi</button>
        </div>
        
        <div class="catalogo-container">
            <?php while ($row = pg_fetch_assoc($result)): ?>
                <div class="catalogo-item <?php echo ($row['categoria']); ?>">
                    <img src="resources/img/catalogue/<?php echo ($row['filename']); ?>" alt="Immagine prodotto">
                    <div class="catalogo-info">
                        <p class="descrizione"><?php echo ($row['descrizione']); ?></p>
                        <p class="prezzo"><?php echo ($row['prezzo']); ?> €</p>
                        <p class="categoria"><?php echo ($row['categoria']); ?></p>
                    </div>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <button class="add-to-cart" onclick="aggiungiAlCarrello(<?php echo ($row['id']); ?>)">Aggiungi al carrello</button>
                    <?php else: ?>
                        <button class="add-to-cart" onclick="showAlert('Per aggiungere prodotti al carrello bisogna prima effettuare il login.')">Aggiungi al carrello</button>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <!-- Script per mostrare alert -->
    <script src="resources/js/showAlert.js"></script>
    <!-- Script per aggiungi al carrello in AJAX -->
    <script src="resources/js/catalogo-ajax.js"></script>
    

    <!-- Chiudo la connessione -->
    <?php pg_close($conn); ?>

    <!-- Footer -->
    <?php include 'includes/footer.html'; ?>