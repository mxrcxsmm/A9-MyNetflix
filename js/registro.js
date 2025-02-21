document.addEventListener("DOMContentLoaded", function() {
    const nombreInput = document.getElementById("nombre");
    const apellidosInput = document.getElementById("apellidos");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const repetirpasswordInput = document.getElementById("repetirpassword");

    nombreInput.addEventListener("blur", function() {
        if (nombreInput.value === '') {
            document.getElementById("nombreError").textContent = ("El campo nombre es obligatorio.");
        }
    });

    apellidosInput.addEventListener("blur", function() {
        if (apellidosInput.value.trim() === '') {
            document.getElementById("apellidosError").textContent = ("El campo apellidos es obligatorio.");
        }
    });

    emailInput.addEventListener("blur", function() {
        const email = emailInput.value.trim();
        if (email === '') {
            document.getElementById("emailError").textContent = ("El campo email es obligatorio.");
        } else if (!validateEmail(email)) {
            document.getElementById("emailError").textContent = ("Por favor, introduce un correo electrónico válido.");
        }
    });

    passwordInput.addEventListener("blur", function() {
        if (passwordInput === '') {
            document.getElementById("passwordError").textContent = ("El campo contraseña es obligatorio.");
        } else if (passwordInput.length < 8) {
            document.getElementById("passwordError").textContent = ("La contraseña debe tener al menos 8 caracteres.");
        }
    });

    repetirpasswordInput.addEventListener("blur", function() {
        if (repetirpasswordInput === '') {
            document.getElementById("repetirpasswordError").textContent("El campo repetir contraseña es obligatorio.");
        } else if (password !== repetirpassword) {
            document.getElementById("repetirpasswordError").textContent("Las contraseñas no coinciden.");
        }
    });

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});
