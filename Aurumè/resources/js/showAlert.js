function showAlert(message) {
    const alertContainer = document.querySelector('.alert-container');

    if (!alertContainer) {
        console.error('Alert container not found');
        return;
    }
    
    alertContainer.innerHTML = `<div class="alert">${message}</div>`;
    alertContainer.classList.add('show');

    setTimeout(() => {
        alertContainer.classList.remove('show');
    }, 4000); // L'alert scompare dopo 4 secondi
}