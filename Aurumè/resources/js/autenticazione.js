document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.querySelector('#login-form form');
    const registerForm = document.querySelector('#register-form form');
    const inputs = document.querySelectorAll('input');

    function validateEmail(email) {
        email = email.trim();
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(email)) return false;

        const domain = email.split('@')[1];
        const allowedDomains = ["gmail.com", "yahoo.com", "outlook.com", "libero.it", "hotmail.com"];
        if (allowedDomains.length > 0 && !allowedDomains.includes(domain)) {
            return false;
        }

        return true;
    }

    function validatePassword(password) {
        return (
            password.length >= 6 &&
            /[!@#$%^&*(),.?":{}|<>]/.test(password) &&
            /[0-9]/.test(password) &&
            /[a-zA-Z]/.test(password)
        );
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
            else if (input.name === 'password') {
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

    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            const email = loginForm.querySelector('input[name="email"]').value.trim();
            const password = loginForm.querySelector('input[name="password"]').value.trim();

            if (!validateEmail(email)) {
                showAlert('Inserisci un\'email valida e con un dominio corretto.');
                event.preventDefault();
                return;
            }
            if (password.length < 6) {
                showAlert('La password deve contenere almeno 6 caratteri.');
                event.preventDefault();
                return;
            }
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', function (event) {
            const name = registerForm.querySelector('input[name="name"]').value.trim();
            const email = registerForm.querySelector('input[name="email"]').value.trim();
            const password = registerForm.querySelector('input[name="password"]').value.trim();

            if (!validateName(name)) {
                showAlert('Il nome deve avere almeno 3 caratteri.');
                event.preventDefault();
                return;
            }

            if (!validateEmail(email)) {
                showAlert('Inserisci un\'email valida e con un dominio corretto.');
                event.preventDefault();
                return;
            }

            if (!validatePassword(password)) {
                showAlert('La password deve contenere almeno 6 caratteri, un carattere speciale, un numero e una lettera.');
                event.preventDefault();
                return;
            }
        });
    }
});