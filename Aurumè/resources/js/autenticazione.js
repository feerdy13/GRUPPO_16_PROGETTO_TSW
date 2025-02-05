// JavaScript per far scomparire l'alert di successo 
document.addEventListener("DOMContentLoaded", function() {
    var successAlert = document.getElementById("success-alert");
    if (successAlert) {
        setTimeout(function() {
            successAlert.style.display = "none";
        }, 3000); // L'alert scompare dopo 5 secondi
    }
});