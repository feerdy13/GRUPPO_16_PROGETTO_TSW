// Script per gestire il click del pulsante e mostrare/nascondere le sezioni
document.addEventListener('DOMContentLoaded', function() {
    const toggleAccountBtn = document.getElementById('toggle-account-btn');
    const accountSections = document.querySelector('.container-element');

    toggleAccountBtn.addEventListener('click', function() {
        if (accountSections.style.display === 'none' || accountSections.style.display === '') {
            accountSections.style.display = 'block';
        } else {
            accountSections.style.display = 'none';
        }
    });
});