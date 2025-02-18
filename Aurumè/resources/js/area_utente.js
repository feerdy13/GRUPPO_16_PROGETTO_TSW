// Script per gestire il click del pulsante e mostrare/nascondere le sezioni
document.addEventListener('DOMContentLoaded', function() {

    const inputs = document.querySelectorAll('input');

    function validateEmail(email) {
        email = email.trim();
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(email)) return false;

        const domain = email.split('@')[1];
        const allowedDomains = ["gmail.com", "yahoo.com", "outlook.com", "libero.it", "hotmail.com", "live.it", "studenti.unisa.it"];
        if (allowedDomains.length > 0 && !allowedDomains.includes(domain)) {
            return false;
        }

        return true;
    }

    function validateName(name) {
        return name.trim().length >= 3;
    }

    // **Validazione con messaggi**
    inputs.forEach(input => {
        let errorMessage = input.nextElementSibling;

        if (!errorMessage || !errorMessage.classList.contains('error-message')) {
            errorMessage = document.createElement('div');
            errorMessage.className = 'error-message';
            errorMessage.style.color = 'red';
            input.parentNode.insertBefore(errorMessage, input.nextSibling);
        }

        input.addEventListener('input', function () {
            let isValid = true;
            let message = '';

            if (input.name === 'name') {
                if (!validateName(input.value)) {
                    isValid = false;
                    message = 'Il nome deve avere almeno 3 caratteri.';
                }
            } 
            else if (input.name === 'email') {
                if (!validateEmail(input.value)) {
                    isValid = false;
                    message = 'Inserisci un\'email valida e con un dominio corretto.';
                }
            } 
            else if (input.name === 'password' || input.name === 'new-password') {
                const password = input.value;
                if (password.length < 6) {
                    isValid = false;
                    message = 'La password deve avere almeno 6 caratteri.';
                }
                if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                    isValid = false;
                    message = 'Deve contenere almeno un carattere speciale.';
                }
                if (!/[0-9]/.test(password)) {
                    isValid = false;
                    message = 'Deve contenere almeno un numero.';
                }
                if (!/[a-zA-Z]/.test(password)) {
                    isValid = false;
                    message = 'Deve contenere almeno una lettera.';
                }
            }

            if (isValid) {
                input.classList.remove('invalid');
                input.classList.add('valid');
                errorMessage.style.display = 'none';
            } else {
                input.classList.remove('valid');
                input.classList.add('invalid');
                errorMessage.textContent = message;
                errorMessage.style.display = 'block';
            }
        });
    });
});