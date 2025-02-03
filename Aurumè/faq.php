    <!-- Include the header -->
    <?php 
        $title = 'FAQ';
        $cssFile = 'resources/css/faq.css';
        include 'includes/header.php'; 
    ?>


    <main>
        <h1 class="heading">Domande frequenti</h1>

        <!-- Sezione icone -->
        <div class="flex-container">
            <div class="flex-item">
                <!-- Icona informazioni sull'ordine -->
                <a href="#info-ordine"><i class="fi fi-rr-info"></i></a>
                <div>Informazioni sull'ordine</div>
            </div>
            <div class="flex-item">
                <!-- Icona spedizioni -->
                <a href="#spedizioni"><i class="fi fi-rs-truck-side"></i></a>
                <div>Spedizioni</div>
            </div>
            <div class="flex-item">
                <!-- Icona reso -->
                <a href="#reso"><i class="fi fi-ss-restock"></i></a>
                <div>Reso e cambio</div>
            </div>
            <div class="flex-item">
                <!-- Icona garanzia -->
                <a href="#garanzia"><i class="fi fi-rr-shield-check"></i></a>
                <div>Garanzie</div>
            </div>
        </div>
        <h2 class="contact">Non hai trovato risposta alla tua domanda? <a href="contatti.php">Contattaci</a></h2>

        <!-- Sezioni FAQ -->
        <div class="faq-section" id="info-ordine">
            <h3>Informazioni sull'ordine</h3>
            <div class="faq-item">
                <button class="faq-question">Come posso tracciare il mio ordine?</button>
                <div class="faq-answer">Puoi tracciare il tuo ordine utilizzando il numero di tracciamento fornito nella conferma di spedizione.</div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Posso modificare il mio ordine dopo averlo effettuato?</button>
                <div class="faq-answer">Sì, puoi modificare il tuo ordine contattando il nostro servizio clienti entro 24 ore dall'acquisto.</div>
            </div>
        </div>

        <div class="faq-section" id="spedizioni">
            <h3>Spedizioni</h3>
            <div class="faq-item">
                <button class="faq-question">Quali sono i tempi di spedizione?</button>
                <div class="faq-answer">I tempi di spedizione variano a seconda della destinazione, ma generalmente sono compresi tra 3 e 7 giorni lavorativi.</div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Quali metodi di spedizione offrite?</button>
                <div class="faq-answer">Offriamo spedizione standard e spedizione espressa. Puoi scegliere il metodo di spedizione al momento del checkout.</div>
            </div>
        </div>

        <div class="faq-section" id="reso">
            <h3>Reso e cambio</h3>
            <div class="faq-item">
                <button class="faq-question">Come posso restituire un prodotto?</button>
                <div class="faq-answer">Puoi restituire un prodotto contattando il nostro servizio clienti e seguendo le istruzioni fornite.</div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Qual è la vostra politica di reso?</button>
                <div class="faq-answer">Accettiamo resi entro 30 giorni dall'acquisto, a condizione che il prodotto sia nelle condizioni originali.</div>
            </div>
        </div>

        <div class="faq-section" id="garanzia">
            <h3>Garanzie</h3>
            <div class="faq-item">
                <button class="faq-question">Quali garanzie offrite sui vostri prodotti?</button>
                <div class="faq-answer">Offriamo una garanzia di 2 anni su tutti i nostri prodotti. La garanzia copre difetti di fabbricazione e materiali.</div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Come posso richiedere assistenza in garanzia?</button>
                <div class="faq-answer">Puoi richiedere assistenza in garanzia contattando il nostro servizio clienti e fornendo la prova d'acquisto.</div>
            </div>
        </div>
    </main>

    <!-- JavaScript per le sezioni FAQ -->
    <script src="resources/js/faq.js"></script>

    <!-- Include the footer -->
    <?php include 'includes/footer.html'; ?>