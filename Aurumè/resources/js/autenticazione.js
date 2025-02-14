document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.querySelector('#login-form form');
    const registerForm = document.querySelector('#register-form form');
    const inputs = document.querySelectorAll('input');

    function showAlert(message) {
        const alertContainer = document.getElementById('alert-container');
        if (!alertContainer) {
            console.error('Alert container not found');
            return;
        }
        alertContainer.innerHTML = `<div class="alert">${message}</div>`;
        alertContainer.classList.add('show');
        setTimeout(() => {
            alertContainer.classList.remove('show');
        }, 3000);
    }

    function validateEmail(email) {
        email = email.trim();
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(email)) return false;

        const domain = email.split('@')[1];

        // **Whitelist (opzionale)**: Se abilitata, accetta solo questi domini
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

    // **Salva e Ripristina dati nel sessionStorage**
    function saveFormData(formId) {
        const form = document.querySelector(`#${formId} form`);
        if (form) {
            const formData = {};
            form.querySelectorAll('input').forEach(input => {
                formData[input.name] = input.value;
            });
            sessionStorage.setItem(formId, JSON.stringify(formData));
        }
    }

    function restoreFormData(formId) {
        const form = document.querySelector(`#${formId} form`);
        if (form) {
            const storedData = sessionStorage.getItem(formId);
            if (storedData) {
                const formData = JSON.parse(storedData);
                form.querySelectorAll('input').forEach(input => {
                    if (formData[input.name]) {
                        input.value = formData[input.name];
                    }
                });
            }
        }
    }

    restoreFormData("login-form");
    restoreFormData("register-form");

    // **Elimina i dati quando si cambia form**
    function clearFormData(formId) {
        sessionStorage.removeItem(formId);
        const form = document.querySelector(`#${formId} form`);
        if (form) {
            form.querySelectorAll('input').forEach(input => input.value = '');
        }
    }

    document.getElementById("show-login").addEventListener("click", function () {
        clearFormData("register-form"); // Cancella la registrazione quando si va al login
    });

    document.getElementById("show-register").addEventListener("click", function () {
        clearFormData("login-form"); // Cancella il login quando si va alla registrazione
    });

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

            if (loginForm && input.closest('#login-form')) saveFormData("login-form");
            if (registerForm && input.closest('#register-form')) saveFormData("register-form");
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

            sessionStorage.removeItem("login-form");
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

            sessionStorage.removeItem("register-form");
        });
    }
});