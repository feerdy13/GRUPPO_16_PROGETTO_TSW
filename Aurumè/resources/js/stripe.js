document.addEventListener("DOMContentLoaded", async function () {
    const stripe = Stripe('pk_test_51QsnxdK1LdU5EUe8UAMGZzdSmapuPLO6Ly72gsd22k9qyyAf2fnVHggOtVfnn3fg4eQrYp97rw2SjPfczd5sLSsJ00oGoOWFAG'); // Public Key

    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const cardErrors = document.getElementById('card-errors');

    const form = document.getElementById('payment-form');

    // Controlla se ci sono errori nell'inserimento dei dati della carta
    cardElement.on('change', (event) => {
        if (event.error) {
            cardErrors.textContent = event.error.message;
        } else {
            cardErrors.textContent = '';
        }
    });

    // Funzione per la gestione del pagamento.
    // Viene attivata quando l'utente clicca sul bottone di invio
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        // Disabilitiamo il bottone di invio per evitare sottomissioni multiple
        document.getElementById('submit-button').disabled = true;

        // Step 1: Creazione PaymentIntent sul server
        createPaymentIntent(async (response) => {
            response = JSON.parse(response);

            // Gestione errore lato server durante la creazione del PaymentIntent
            if (response.error) {
                cardErrors.textContent = 'Errore durante la creazione del pagamento.';
                // Riabilito il bottone di invio per permettere una nuova richiesta
                document.getElementById('submit-button').disabled = false;
                return;
            }

            const clientSecret = response.clientSecret;

            // Step 2: Conferma del pagamento lato client
            const await_stripe = await stripe.confirmCardPayment(clientSecret, {
                // 'await' fa in modo che il codice aspetti la risposta di Stripe prima di proseguire
                payment_method: { card: cardElement },
            });
            // Assegniamo i valori paymentIntent ed error solo dopo che stripe.confirmCardPayment() ha restituito un risultato
            const paymentIntent = await_stripe.paymentIntent;
            const error = await_stripe.error;

            if (error) {
                // Gestione degli errori ricevuti durante la conferma del pagamento
                cardErrors.textContent = 'Errore durante la conferma del pagamento.';
            } else if (paymentIntent && paymentIntent.status === 'succeeded') {
                // Pagamento andato a buon fine
                alert('Pagamento completato con successo!');
                window.location.href = 'action/registra_ordine.php';
            } else {
                // Errore sconosciuto
                cardErrors.textContent = 'Errore sconosciuto, riprova.';
                document.getElementById('submit-button').disabled = false;
            }
        });
    });

    // Creiamo un PaymentIntent usando AJAX
    function createPaymentIntent(callback) {
        const xhttp = new XMLHttpRequest();
        xhttp.open('POST', 'action/pagamento.php', true);

        xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4) {
                if (xhttp.status === 200) {
                    try {
                        const response = xhttp.response;
                        callback(response);
                    } catch (e) {
                        callback({ error: 'Invalid server response' });
                    }
                } else {
                    callback({ error: xhttp.statusText });
                }
            }
        };

        const formData = new FormData(form);
        xhttp.send(formData);
    }

});