function updateQuantity(productID, update) {
    // Crea un nuovo oggetto XMLHttpRequest, necessario per AJAX
    const xhttp = new XMLHttpRequest();

    // La richiesta viene gestita dallo script PHP aggiorna_quantita.php
    xhttp.open("POST", "action/aggiorna_quantita.php");

    // Indica che i dati sono codificati in una stringa di coppie chiave=valore
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Invia la richiesta 
    xhttp.send("product_id=" + productID + "&update=" + update);
}