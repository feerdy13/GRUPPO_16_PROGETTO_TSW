document.addEventListener('DOMContentLoaded', function() {
    const flexItems = document.querySelectorAll('.flex-item');  /* Icone delle sezioni FAQ */
    const faqSections = document.querySelectorAll('.faq-section');  /* Sezioni FAQ */
    const faqQuestions = document.querySelectorAll('.faq-question');   /* Domande FAQ */

    // Mostra la sezione FAQ corrispondente quando viene cliccata un'icona
    flexItems.forEach(item => {
        item.addEventListener('click', function(event) {
            event.preventDefault(); // Evita il salto della pagina dovuto all'href="#..."
            
            //sectionID: ID della sezione FAQ
            //this.querySelector('a'): Trova il primo <a> all'interno del .flex-item.
            //substring(1): Rimuove il primo carattere dalla stringa, in questo caso '#'
            let sectionId = this.querySelector('a').getAttribute('href').substring(1); 
            let targetSection = document.getElementById(sectionId);

            if (targetSection) {
                if (targetSection.classList.contains('active')) {   // Se la sezione è già aperta, la chiude
                    targetSection.classList.remove('active');
                    item.style.color = "#333"; // Ripristina il colore originale
                } else {    //Altrimenti chiude tutte le altre e apre quella selezionata
                    // Chiude tutte le altre sezioni
                    faqSections.forEach(section => section.classList.remove('active'));
                    
                    // Apre la nuova sezione
                    targetSection.classList.add('active');

                    // Resetta il colore di tutte le icone
                    flexItems.forEach(flex => flex.style.color = "#333");

                    // Cambia colore solo all'icona attiva
                    item.style.color = "#d4af37";
                }
            }
        });
    });

    // Espande o collassa la risposta alla domanda FAQ quando viene cliccata
    faqQuestions.forEach(question => {
        // Aggiunge un listener per l'evento 'click' su ogni domanda FAQ
        question.addEventListener('click', function() {
            
            const answer = this.nextElementSibling; // Seleziona l'elemento successivo (la risposta alla domanda FAQ)
            answer.classList.toggle('active');  
        });
    });

});
