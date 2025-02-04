document.addEventListener('DOMContentLoaded', function() {
    const scrollContainer = document.querySelector('.image-scroll-container');
    const leftButton = document.querySelector('.scroll-button.left');
    const rightButton = document.querySelector('.scroll-button.right');

    leftButton.addEventListener('click', function() {
        scrollContainer.scrollBy({
            left: -430, // Scorri a sinistra di 430px
            behavior: 'smooth' // Scorrimento liscio
        });
    });

    rightButton.addEventListener('click', function() {
        scrollContainer.scrollBy({
            left: 430, // Scorri a destra di 430px
            behavior: 'smooth' // Scorrimento liscio
        });
    });
});