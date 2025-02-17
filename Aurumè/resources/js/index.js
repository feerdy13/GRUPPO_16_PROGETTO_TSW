document.addEventListener("DOMContentLoaded", function () {
    const elements = document.querySelectorAll(".hidden");

    function checkScroll() {
        let triggerBottom = window.innerHeight * 0.85; // Quando l'elemento è visibile all'85%

        elements.forEach((element) => {
            let elementTop = element.getBoundingClientRect().top;
            
            if (elementTop < triggerBottom) {
                element.classList.add("show"); // Aggiunge la classe per mostrare l'elemento
            }
        });
    }

    window.addEventListener("scroll", checkScroll);
    checkScroll(); // Esegue il controllo all'inizio per elementi già visibili
});