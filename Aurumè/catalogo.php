    <?php 
        require 'includes/database.php';  // Assicura che $conn sia disponibile


        // Query per recuperare i prodotti dal catalogo
        $query = "SELECT path, descrizione, prezzo, categoria FROM catalogo";
        $result = pg_query($conn, $query);

        if (!$result) {
            die("Errore nella query: " . pg_last_error());
        }
    ?>


    <!-- Include the header -->
    <?php
        
        $title = 'Catalogo';
        $cssFile = 'resources/css/catalogo.css';
        include 'includes/header.php'; 
    ?>

    <h1 class="heading">La nostra Collezione</h2>
    
    <div class="catalogo-container">
        <?php while ($row = pg_fetch_assoc($result)): ?>
            <div class="catalogo-item">
                <img src="<?php echo htmlspecialchars($row['path']); ?>" alt="Immagine prodotto">
                <div class="catalogo-info">
                    <p class="descrizione"><?php echo htmlspecialchars($row['descrizione']); ?></p>
                    <p class="prezzo"><?php echo htmlspecialchars($row['prezzo']); ?> €</p>
                    <p class="categoria"><?php echo htmlspecialchars($row['categoria']); ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <?php 
        // Chiudi la connessione
        pg_close($conn);
    ?>







    <!-- Include the footer -->
    <?php include 'includes/footer.html'; ?>