document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.filter');   /* Filtri */
    const items = document.querySelectorAll('.catalogo-item');  /* Prodotti */

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.classList[1];  // La seconda classe è data dalla categoria

            // Se il bottone è già attivo, rimuove la classe 'active'
            if (this.classList.contains('active')) {
                this.classList.remove('active');
                showAllProducts(items);
            } else {
                // Rimuove 'active' da tutti e lo aggiunge solo al cliccato
                buttons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                filterProducts(items, category);
            }
        });
    })


});

function filterProducts(items, category) {
    items.forEach(item => {
        if (item.classList.contains(category)) {
            item.style.display = 'block'; // Mostra i prodotti della categoria selezionata
        } else {
            item.style.display = 'none';  // Nasconde gli altri
        }
    });
}

function showAllProducts(items) {
    items.forEach(item => item.style.display = 'block');
}


// Utilizza AJAX
function aggiungiAlCarrello(productID) {
    // Crea un nuovo oggetto XMLHttpRequest, necessario per AJAX
    const xhttp = new XMLHttpRequest();

    // La richiesta viene gestita dallo script PHP aggiungi_al_carrello.php
    xhttp.open("POST", "action/aggiungi_al_carrello.php");

    // Indica che i dati sono codificati in una stringa di coppie chiave=valore
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // La funzione viene eseguita al variare dello stato di xhttp
    xhttp.onreadystatechange = function () {
        // Verifica se la richiesta è stata completata (readyState 4) e ha avuto successo (status 200)
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            // Mostra un messaggio di conferma all'utente
            showAlert("Prodotto aggiunto al carrello!");
        }
    };

    // Invia la richiesta 
    xhttp.send("product_id=" + productID);
}













