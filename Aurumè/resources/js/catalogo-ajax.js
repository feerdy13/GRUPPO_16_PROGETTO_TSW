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