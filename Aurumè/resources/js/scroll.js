document.addEventListener('DOMContentLoaded', function() {
    const scrollContainer = document.querySelector('.image-scroll-container');
    const leftButton = document.querySelector('.scroll-button.left');
    const rightButton = document.querySelector('.scroll-button.right');

    leftButton.addEventListener('click', function() {
        scrollContainer.scrollBy({
            left: -420, // Scorri a sinistra di 300px
            behavior: 'smooth' // Scorrimento liscio
        });
    });

    rightButton.addEventListener('click', function() {
        scrollContainer.scrollBy({
            left: 420, // Scorri a destra di 300px
            behavior: 'smooth' // Scorrimento liscio
        });
    });
});