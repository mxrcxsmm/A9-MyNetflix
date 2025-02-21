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
        if (email !== '') {
            fetch('../proc/proc_register.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'email': email,
                        'check_email': true // Indica que solo estamos verificando el correo
                    })
                })
                .then(response => {
                    // Verificar si la respuesta es una redirección
                    if (response.redirected) {
                        // Si se redirige, significa que el correo ya está registrado
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'El correo ya está registrado.',
                            confirmButtonText: 'Aceptar'
                        });
                    } else {
                        return response.json();
                    }
                })
                .then(data => {
                    if (data && data.error) {
                        document.getElementById("emailError").textContent = data.error;
                    } else {
                        document.getElementById("emailError").textContent = ""; // Limpiar el error
                    }
                })
                .catch(error => console.error('Error:', error));
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

        // Si hay errores, mostrar SweetAlert y evitar el envío del formulario
        if (!valid) {
            e.preventDefault(); // Evitar el envío del formulario
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Tienes que rellenar todos los campos.',
                confirmButtonText: 'Aceptar'
            });
        }
    });
});

$(document).ready(function() {
    $('#searchForm').on('submit', function(e) {
        e.preventDefault(); // Evitar el envío normal del formulario
        $.ajax({
            type: 'POST',
            url: '../proc/proc_peliculas.php', // Cambia esto a la URL que maneje la búsqueda
            data: $(this).serialize(), // Serializa los datos del formulario
            success: function(response) {
                $('#peliculasTable tbody').html(response); // Actualiza la tabla con los resultados
            }
        });
    });
});