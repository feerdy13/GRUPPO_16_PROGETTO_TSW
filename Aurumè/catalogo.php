    <?php 
        session_start(); 
        require 'includes/database.php';  // Assicura che $conn sia disponibile


        // Query per recuperare i prodotti dal catalogo
        $query = "SELECT id, filename, descrizione, prezzo, categoria FROM prodotti";
        $result = pg_query($conn, $query);

        if (!isset($_SESSION['user_id'])) 
            $_SESSION['alert'] = "Per aggiungere prodotti al carrello bisogna effettuare il login.";
    ?>


    <!-- Header -->
    <?php
        
        $title = 'Catalogo';
        $cssFile = 'resources/css/catalogo.css';
        include 'includes/header.php'; 
    ?>


    <main>
        <h1 class="heading">La nostra Collezione</h2>
        
        <div class="catalogo-container">
            <?php while ($row = pg_fetch_assoc($result)): ?>
                <div class="catalogo-item">
                    <img src="resources/img/catalogue/<?php echo htmlspecialchars($row['filename']); ?>" alt="Immagine prodotto">
                    <div class="catalogo-info">
                        <p class="descrizione"><?php echo htmlspecialchars($row['descrizione']); ?></p>
                        <p class="prezzo"><?php echo htmlspecialchars($row['prezzo']); ?> €</p>
                        <p class="categoria"><?php echo htmlspecialchars($row['categoria']); ?></p>
                    </div>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="action/aggiungi_al_carrello.php?product_id=<?php echo htmlspecialchars($row['id']); ?>" class="add-to-cart">Aggiungi al carrello</a>
                    <?php else: ?>
                        <?php $_SESSION['alert'] = "Per aggiungere prodotti al carrello bisogna prima effettuare il login."; ?>
                        <a href="autenticazione.php" class="add-to-cart">Aggiungi al carrello</a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <!-- Chiudo la connessione -->
    <?php pg_close($conn); ?>

    <!-- Footer -->
    <?php include 'includes/footer.html'; ?>