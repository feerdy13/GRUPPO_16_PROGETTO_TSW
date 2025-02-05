    <?php
        session_start();
        require 'includes/database.php';

        if (isset($_SESSION['user_id'])) {
            // Utente loggato: il carrello viene recuperato dal database
            $user_id = $_SESSION['user_id'];
            
            // Dammi tutti i dettagli dei prodotti che sono attualmente nel carrello dell'utente $1
            $query = "SELECT p.id, p.filename, p.descrizione, p.prezzo, p.categoria 
                        FROM carrello c 
                        JOIN prodotti p ON c.id_prodotto = p.id 
                        WHERE c.id_utente = $1";

            pg_prepare($conn, "estrai_carrello", $query);
            $result = pg_execute($conn, "estrai_carrello", array($user_id));
        } else {
            // Utente non loggato: il carrello viene recuperato dalla sessione
            $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
            if (!empty($cart)) {
                // $cart contiene gli id dei prodotti nel carrello dell'utente non loggato
                // salvo gli id in una stringa, $idsString, separata da virgole
                $ids = array_map('intval', $cart);
                $idsString = implode(',', $ids);

                $query = "SELECT id, filename, descrizione, prezzo, categoria 
                            FROM prodotti 
                            WHERE id IN ($idsString)";
                $result = pg_query($conn, $query);
            } else
                $result = false;
        }
    ?>
    
    
    
    <!-- Header -->
    <?php 
        $title = 'Carrello';
        $cssFile = 'resources/css/carrello.css';
        include 'includes/header.php'; 
    ?>
    
    <main>
        <h1 class="heading">Carrello</h2>

        <?php if (!$result): ?>
            <div class='empty-cart'>
                <h2>Il tuo carrello è vuoto</h2>
                <h3>Aggiungi dei prodotti al carrello dalla pagina del catalogo</h3>
            </div>
        <?php else: ?>
            <div class="cart-container">
                <?php while ($row = pg_fetch_assoc($result)): ?>
                    <div class="cart-item">
                        <img src="resources/img/catalogue/<?php echo htmlspecialchars($row['filename']); ?>" alt="Immagine prodotto">
                        <div class="cart-info">
                            <p class="descrizione"><?php echo htmlspecialchars($row['descrizione']); ?></p>
                            <p class="prezzo"><?php echo htmlspecialchars($row['prezzo']); ?> €</p>
                            <p class="categoria"><?php echo htmlspecialchars($row['categoria']); ?></p>
                        </div>
                        <a href="action/rimuovi_dal_carrello.php?product_id=<?php echo $row['id']; ?>" class="remove-from-cart">Rimuovi</a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>       
    </main>
    
    <!-- Chiudo la connessione -->
    <?php pg_close($conn); ?>
 
    <!-- Footer -->
    <?php include 'includes/footer.html'; ?>
