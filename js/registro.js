document.addEventListener("DOMContentLoaded", function() {
    const nombreInput = document.getElementById("nombre");
    const apellidosInput = document.getElementById("apellidos");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const repetirpasswordInput = document.getElementById("repetirpassword");
    const form = document.querySelector('form'); // Selecciona el formulario

    // Función para validar el correo electrónico
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Validaciones al perder el foco
    nombreInput.addEventListener("blur", function() {
        if (nombreInput.value === '') {
            document.getElementById("nombreError").textContent = "El campo nombre es obligatorio.";
        } else {
            document.getElementById("nombreError").textContent = ""; // Limpiar el error
        }
    });

    apellidosInput.addEventListener("blur", function() {
        if (apellidosInput.value.trim() === '') {
            document.getElementById("apellidosError").textContent = "El campo apellidos es obligatorio.";
        } else {
            document.getElementById("apellidosError").textContent = ""; // Limpiar el error
        }
    });

    emailInput.addEventListener("blur", function() {
        const email = emailInput.value.trim();
        if (email === '') {
            document.getElementById("emailError").textContent = "El campo email es obligatorio.";
        } else if (!validateEmail(email)) {
            document.getElementById("emailError").textContent = "Por favor, introduce un correo electrónico válido.";
        } else {
            document.getElementById("emailError").textContent = ""; // Limpiar el error
        }
    });

    passwordInput.addEventListener("blur", function() {
        if (passwordInput.value === '') {
            document.getElementById("passwordError").textContent = "El campo contraseña es obligatorio.";
        } else if (passwordInput.value.length < 8) {
            document.getElementById("passwordError").textContent = "La contraseña debe tener al menos 8 caracteres.";
        } else {
            document.getElementById("passwordError").textContent = ""; // Limpiar el error
        }
    });

    repetirpasswordInput.addEventListener("blur", function() {
        if (repetirpasswordInput.value === '') {
            document.getElementById("repetirpasswordError").textContent = "El campo repetir contraseña es obligatorio.";
        } else if (repetirpasswordInput.value !== passwordInput.value) {
            document.getElementById("repetirpasswordError").textContent = "Las contraseñas no coinciden.";
        } else {
            document.getElementById("repetirpasswordError").textContent = ""; // Limpiar el error
        }
    });

    // Validar el formulario antes de enviarlo
    form.addEventListener("submit", function(e) {
        let valid = true; // Variable para controlar la validez del formulario

        // Validar todos los campos
        if (nombreInput.value === '') {
            document.getElementById("nombreError").textContent = "El campo nombre es obligatorio.";
            valid = false;
        }
        if (apellidosInput.value.trim() === '') {
            document.getElementById("apellidosError").textContent = "El campo apellidos es obligatorio.";
            valid = false;
        }
        if (emailInput.value.trim() === '') {
            document.getElementById("emailError").textContent = "El campo email es obligatorio.";
            valid = false;
        } else if (!validateEmail(emailInput.value.trim())) {
            document.getElementById("emailError").textContent = "Por favor, introduce un correo electrónico válido.";
            valid = false;
        }
        if (passwordInput.value === '') {
            document.getElementById("passwordError").textContent = "El campo contraseña es obligatorio.";
            valid = false;
        } else if (passwordInput.value.length < 8) {
            document.getElementById("passwordError").textContent = "La contraseña debe tener al menos 8 caracteres.";
            valid = false;
        }
        if (repetirpasswordInput.value === '') {
            document.getElementById("repetirpasswordError").textContent = "El campo repetir contraseña es obligatorio.";
            valid = false;
        } else if (repetirpasswordInput.value !== passwordInput.value) {
            document.getElementById("repetirpasswordError").textContent = "Las contraseñas no coinciden.";
            valid = false;
        }

        // Si hay errores, evitar el envío del formulario
        if (!valid) {
            e.preventDefault();
        }
    });
});