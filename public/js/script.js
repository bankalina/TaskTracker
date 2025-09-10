document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector("form");
    if (!form) return;

    const emailInput = form.querySelector('input[name="email"]');
    const passwordInput = form.querySelector('input[name="password"]');
    const fullnameInput = form.querySelector('input[name="fullname"]');
    const confirmPasswordInput = form.querySelector('input[name="confirmPassword"]');
    const termsCheckbox = form.querySelector('input[name="terms"]');

    const isRegistration = fullnameInput !== null;

    function isEmail(email) {
        return /\S+@\S+\.\S+/.test(email);
    }

    function isFullname(name) {
        return name.trim().length >= 2 && /^[a-zA-Z\s]+$/.test(name);
    }

    function isPasswordStrong(password) {
        return password.length >= 8;
    }

    function arePasswordsSame(password, confirmedPassword) {
        return password === confirmedPassword && password.length > 0;
    }

    function markValidation(element, condition) {
        if (!condition) {
            element.classList.add('no-valid');
        } else {
            element.classList.remove('no-valid');
        }
    }

    // Validation functions with timeout
    function validateEmail() {
        setTimeout(function() {
            markValidation(emailInput, isEmail(emailInput.value));
        }, 1000);
    }

    function validateFullname() {
        setTimeout(function() {
            markValidation(fullnameInput, isFullname(fullnameInput.value));
        }, 1000);
    }

    function validatePassword() {
        setTimeout(function() {
            markValidation(passwordInput, isPasswordStrong(passwordInput.value));
        }, 1000);
    }

    function validateConfirmPassword() {
        setTimeout(function() {
            const condition = arePasswordsSame(passwordInput.value, confirmPasswordInput.value);
            markValidation(confirmPasswordInput, condition);
        }, 1000);
    }

    function validateTerms() {
        setTimeout(function() {
            markValidation(termsCheckbox, termsCheckbox.checked);
        }, 100);
    }

    emailInput.addEventListener('keyup', validateEmail);
    passwordInput.addEventListener('keyup', validatePassword);

    if (isRegistration) {
        fullnameInput.addEventListener('keyup', validateFullname);
        confirmPasswordInput.addEventListener('keyup', validateConfirmPassword);
        termsCheckbox.addEventListener('change', validateTerms);
    }


    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        form.querySelectorAll('.no-valid').forEach(el => el.classList.remove('no-valid'));
        
        let isValid = true;
        
        if (!isEmail(emailInput.value)) {
            markValidation(emailInput, false);
            isValid = false;
        }
        
        if (!isPasswordStrong(passwordInput.value)) {
            markValidation(passwordInput, false);
            isValid = false;
        }
        
        if (isRegistration) {
            if (!isFullname(fullnameInput.value)) {
                markValidation(fullnameInput, false);
                isValid = false;
            }
            
            if (!arePasswordsSame(passwordInput.value, confirmPasswordInput.value)) {
                markValidation(confirmPasswordInput, false);
                isValid = false;
            }
            
            if (!termsCheckbox.checked) {
                markValidation(termsCheckbox, false);
                isValid = false;
            }
        }
        
        if (isValid) {
            form.submit();
        }
    });
});

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = input.nextElementSibling.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}