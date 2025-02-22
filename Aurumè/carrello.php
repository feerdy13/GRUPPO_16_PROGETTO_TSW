    <!-- Header -->
    <?php 
        $title = 'Carrello';
        $cssFile = 'resources/css/carrello.css';
        include 'includes/header.php'; 
    ?>
    
    <?php
        session_start();
        require 'includes/database.php';

        if (isset($_SESSION['user_id'])) {
            // Utente loggato: il carrello viene recuperato dal database
            $user_id = $_SESSION['user_id'];
            
            // Recupero tutti i dettagli dei prodotti che sono attualmente nel carrello dell'utente $1
            $query = "SELECT p.id, p.filename, p.descrizione, p.prezzo, p.categoria, c.quantita
                        FROM carrello c 
                        JOIN prodotti p ON c.id_prodotto = p.id 
                        WHERE c.id_utente = $1";

            pg_prepare($conn, "estrai_carrello", $query);
            $result = pg_execute($conn, "estrai_carrello", array($user_id));

            // Calcolo il prezzo totale del carrello
            $total = 0;
            $cart_items = [];
            if ($result) {
                while ($row = pg_fetch_assoc($result)) {
                    $cart_items[] = $row;
                    $total += round($row['prezzo'] * $row['quantita'], 2); // Arrotonda a due decimali
                }
            }
        }
    ?>
    
    <main>
        
        <h1 class="heading">Carrello</h2>

        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Utente loggato: ha accesso al carrello -->
            
            <?php if (pg_num_rows($result) == 0): ?>
                <!-- Utente loggato: carrello vuoto -->
                <div class='text-center'>
                    <h2>Il tuo carrello è vuoto</h2>
                    <h3>Aggiungi dei prodotti al carrello dalla pagina del catalogo</h3>
                </div>

            <?php else: ?>
                <!-- Utente loggato: carrello non vuoto -->

                <!-- visualizzo i prodotti nel carrello -->
                <div class="cart-page-container">

                    <div class="cart-items-container">
                        <?php foreach ($cart_items as $row): ?>
                            <!-- Recupero il contenuto del carrello -->
                            <div class="cart-item" id="prodID<?php echo $row['id']; ?>">
                                <img src="resources/img/catalogue/<?php echo ($row['filename']); ?>" alt="Immagine prodotto">
                                <div class="cart-info">
                                    <div class="info-descrizione"><?php echo $row['descrizione']; ?></div>
                                    <div class="info-quantita">
                                        <span>Quantità:</span>
                                        <div class="quantity-control">
                                            <button class="quantity-btn" onclick="updateQuantity(<?php echo $row['id']; ?>, -1)">-</button>
                                            <span class="quantita"><?php echo $row['quantita']; ?></span>
                                            <button class="quantity-btn" onclick="updateQuantity(<?php echo $row['id']; ?>, 1)">+</button>
                                        </div>
                                    </div>
                                    <div class="info-prezzo">
                                        <span>Prezzo:</span>
                                        <span class="prezzo"><?php echo number_format($row['prezzo'], 2); ?> €</span>
                                    </div>
                                    <a href="action/rimuovi_dal_carrello.php?product_id=<?php echo $row['id']; ?>" class="remove-from-cart">RIMUOVI</a>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>

                    <!-- Visualizzo il totale del carrello -->
                    <div class="order-summary">
                        <h1>Riepilogo ordine</h1>
                        <div class="summary-details">
                            <div class="summary-row total">
                                <strong>Totale</strong>
                                <strong id="total"><?php echo number_format($total, 2); ?> €</strong>
                            </div>
                            <div class="summary-row">
                                <span>Incluse tasse e spese di spedizione</span>
                            </div>

                            <form method="post" id="payment-form">
                                <div id="card-element"><!-- Il form Stripe Elements verrà inserito qui --></div>
                                <button id="submit-button">COMPLETA L'ACQUISTO</button>
                                <p id="card-error" role="alert"></p>
                            </form>

                            <div class="summary-row">
                                <ul>
                                    <li>Spedizione standard de 1 a 2 giorni lavorativi, gratuita su tutti gli ordini.</li>
                                    <li>Servizio di ritiro in una qualsiasi boutique Aurumè in Italia. Il tuo ordine online sarà disponibile per il ritiro entro 3 giorni dalla data di acquisto.</li>
                                    <li>Puoi restituire una creazione Aurumè acquistata online e richiedere un cambio o un rimborso entro 14 giorni dalla data di consegna.</li>
                                </ul>
                            </div>
                           
                        </div>
                    </div>

                </div>

            <?php endif; ?> 
            
            <!-- Utente loggato: visualizza il bottone per tornare al catalogo -->
            <div class="button">
                <a href='catalogo.php'>Torna al catalogo</a>
            </div>

        <?php else: ?> 
            <!-- Utente non loggato: non ha accesso al carrello -->
            <div class='text-center'>
                <h2>Ops!</h2>
                <h3>Devi aver effettuato l'accesso per accedere al carrello</h3>
            </div> 

            <!-- Utente non loggato: visualizza il bottone per effettuare l'accesso -->
            <div class="button">
                <a href='autenticazione.php'>Accedi</a>
            </div>

        <?php endif; ?>

    </main>
    


    <!-- Script per aggiornare quantità prodotto in AJAX -->
    <script src="resources/js/carrello-ajax.js"></script>
    <!-- Script per il pagamento con stripe -->
    <script src="resources/js/stripe.js"></script>

    <!-- Chiudo la connessione -->
    <?php pg_close($conn); ?>
 
    <!-- Footer -->
    <?php include 'includes/footer.html'; ?>
