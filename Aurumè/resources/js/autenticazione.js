// JavaScript per far comparire e scomparire l'alert di successo
document.addEventListener("DOMContentLoaded", function() {
    const alert = document.querySelector(".alert");
    if (alert) {
        // Aggiungi la classe 'show' per far comparire l'alert
        setTimeout(function() {
            alert.classList.add("show");
        }, 100); // Ritardo per assicurarsi che l'elemento sia stato renderizzato

        // Rimuovi la classe 'show' per far scomparire l'alert
        setTimeout(function() {
            alert.classList.remove("show");
            setTimeout(function() {
                alert.style.display = "none";
            }, 500); // Tempo per la transizione dell'opacità
        }, 4000); // L'alert scompare dopo 4 secondi
    }
});