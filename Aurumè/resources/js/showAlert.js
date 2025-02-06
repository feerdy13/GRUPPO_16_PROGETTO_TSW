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
    }, 3000); // L'alert scompare dopo 3 secondi
}