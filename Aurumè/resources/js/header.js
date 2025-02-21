document.addEventListener("DOMContentLoaded", function () {
    const header = document.getElementById("navbar");
    
    let prevScrollpos = window.scrollY;
    let hoverTimeout, leaveTimeout;
    let isHovered = false;
    let firstScroll = true; // Variabile per gestire il primo scroll

    
    header.addEventListener("click", function (event) {
        const sidenav = document.getElementById("sidenav");
        const openMenuButton = document.getElementById("openMenu");
        
        // Evito che il click sul pulsante chiuda subito la sidenav
        // event.target è l'elemento su cui è stato effettuato il click
        if (openMenuButton.contains(event.target)) return;

        // Chiudi la sidenav
        if (sidenav.classList.contains("active")) {
            closeMenu();
        }
    });

    
    /* Effetto hover con delay */
    // header.addEventListener("mouseenter", function () {
    //     clearTimeout(leaveTimeout);
    //     hoverTimeout = setTimeout(() => {
    //         header.classList.add("color");
    //         isHovered = true;
    //     }, 500); // Ritardo di 500ms prima di colorarlo
    // });
    // header.addEventListener("mouseleave", function () {
    //     clearTimeout(hoverTimeout);
    //     leaveTimeout = setTimeout(() => {
    //         header.classList.remove("color");
    //         isHovered = false;
    //     }, 500); // Ritardo di 500ms prima di tornare trasparente
    // });


    // Controllo dello scroll con effetto fluido anche in uscita
    window.onscroll = function () {
        let currentScrollPos = window.scrollY;

        if (prevScrollpos > currentScrollPos) {
            // Scrolling verso l'alto → Mostra header
            header.style.top = "0";
            if (currentScrollPos > 0) {
                header.classList.add("color");
            } else {
                header.classList.remove("color");
            }
        } else {
            // Scrolling verso il basso → Nasconde header
            header.style.top = "-90px";
        }

        // PRIMO SCROLL IN GIÙ: Non colorare l'header se è la prima volta che si scorre
        if (firstScroll && currentScrollPos > 0) {
            firstScroll = false;
        } else if (currentScrollPos === 0) {
            // Se siamo tornati all'inizio, l'header deve tornare trasparente
            header.classList.remove("color");
            firstScroll = true; // Reset per il prossimo scroll
        }

        prevScrollpos = currentScrollPos;
    };
});

/* Apertura menu laterale */
function openMenu() {
    const sidenav = document.getElementById("sidenav");
    const blur = document.getElementById("blur");

    sidenav.classList.add("active");
    blur.classList.add("active");
    document.body.style.overflow = 'hidden';    // Disabilita lo scroll della pagina
}

/* Chiusura menu laterale */
function closeMenu() {
    const sidenav = document.getElementById("sidenav");
    const blur = document.getElementById("blur");

    sidenav.classList.remove("active");
    blur.classList.remove("active");
    document.body.style.overflow = '';    // Riabilita lo scroll della pagina
}

/* Permette di filtrare le categorie del catalogo dal menu laterale */
function salvaCategoria(categoria) {
    if (categoria) {  // Controlla che la categoria non sia vuota o null
        sessionStorage.setItem("filtro", categoria);
    }
}

// Funzione toggleMenu per lo scorrimento del menu utente loggato
function toggleMenu() {
    const subMenu = document.getElementById("subMenu");
    subMenu.classList.toggle("open-menu");
}