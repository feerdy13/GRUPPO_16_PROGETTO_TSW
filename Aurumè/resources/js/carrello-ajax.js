function updateQuantity(productID, update) {
    // Crea un nuovo oggetto XMLHttpRequest, necessario per AJAX
    const xhttp = new XMLHttpRequest();

    // La richiesta viene gestita dallo script PHP aggiorna_quantita.php
    xhttp.open("POST", "action/aggiorna_quantita.php");

    // Indica che i dati sono codificati in una stringa di coppie chiave=valore
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Indica che la risposta sarà in formato JSON
    xhttp.responseType = "json";

    // La funzione viene eseguita al variare dello stato di xhttp
    xhttp.onreadystatechange = function () {
        // Verifica se la richiesta è stata completata (readyState 4) e ha avuto successo (status 200)
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            // Aggiorna la quantità del prodotto nel carrello lato client
            let response = xhttp.response;

            if (response.success) {
                let quantityElement = document.querySelector('#prodID' + productID + ' .quantita');
                let total = document.querySelector('#total');
                if (quantityElement && total && response.new_quantity > 0) {
                    quantityElement.textContent = response.new_quantity;
                    total.textContent = response.new_total;
                } else {
                    let productElement = document.querySelector('#prodID' + productID);
                    if (productElement) {
                        productElement.remove();
                        location.reload();
                    }
                }
            }
        }
    };

    // Invia la richiesta 
    xhttp.send("product_id=" + productID + "&update=" + update);
}

