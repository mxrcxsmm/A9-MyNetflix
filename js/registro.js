document.addEventListener("DOMContentLoaded", function() {
    const nombreInput = document.getElementById("nombre");
    const apellidosInput = document.getElementById("apellidos");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const repetirpasswordInput = document.getElementById("repetirpassword");

    function validarNombre() {
        if (nombreInput.value === '') {
            document.getElementById("nombreError").textContent = ("El campo nombre es obligatorio.");
        } else {
            document.getElementById("nombreError").textContent = "";
        }
    }

    function validarApellidos() {
        if (apellidosInput.value.trim() === '') {
            document.getElementById("apellidosError").textContent = ("El campo apellidos es obligatorio.");
        } else {
            document.getElementById("apellidosError").textContent = "";
        }
    }

    function validarEmail() {
        const email = emailInput.value.trim();
        if (email === '') {
            document.getElementById("emailError").textContent = ("El campo email es obligatorio.");
        } else if (!validateEmail(email)) {
            document.getElementById("emailError").textContent = ("Por favor, introduce un correo electrónico válido.");
        } else {
            document.getElementById("emailError").textContent = "";
        }
    }

    function validarPassword() {
        if (passwordInput.value === '') {
            document.getElementById("passwordError").textContent = ("El campo contraseña es obligatorio.");
        } else if (passwordInput.value.length < 8) {
            document.getElementById("passwordError").textContent = ("La contraseña debe tener al menos 8 caracteres.");
        } else {
            document.getElementById("passwordError").textContent = "";
        }
    }

    function validarRepetirPassword() {
        if (repetirpasswordInput.value === '') {
            document.getElementById("repetirpasswordError").textContent = ("El campo repetir contraseña es obligatorio.");
        } else if (passwordInput.value !== repetirpasswordInput.value) {
            document.getElementById("repetirpasswordError").textContent = ("Las contraseñas no coinciden.");
        } else {
            document.getElementById("repetirpasswordError").textContent = "";
        }
    }

    nombreInput.onblur = validarNombre;
    nombreInput.oninput = validarNombre;
    
    apellidosInput.onblur = validarApellidos;
    apellidosInput.oninput = validarApellidos;
    
    emailInput.onblur = validarEmail;
    emailInput.oninput = validarEmail;
    
    passwordInput.onblur = validarPassword;
    passwordInput.oninput = validarPassword;
    
    repetirpasswordInput.onblur = validarRepetirPassword;
    repetirpasswordInput.oninput = validarRepetirPassword;

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});
