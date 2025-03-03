function toggleCorazon(contenedor) {
    const usuarioId = contenedor.dataset.usuarioId; // Obtener el ID del usuario desde el contenedor

    if (!usuarioId) {
        // Si no hay ID de usuario, mostrar alerta
        Swal.fire({
            title: '¡Atención!',
            text: 'Debes iniciar sesión para dar like a una película.',
            showCancelButton: true,
            confirmButtonText: 'Iniciar sesión',
            cancelButtonText: 'Cerrar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirigir a la página de inicio de sesión si se confirma
                window.location.href = 'view/login.php';
            }
        });
        return; // Salir de la función si el usuario no está autenticado
    }

    ruta = 'proc/proc_like.php';

    if (window.location.href.includes('detalle_pelicula.php')) {
        ruta = '../proc/proc_like.php';
    }

    // Si el usuario está autenticado, continuar con la lógica de like
    contenedor.classList.toggle('active'); // Alternar la clase 'active'
    
    const peliculaId = contenedor.dataset.peliculaId; // Obtener el ID de la película

    console.log('Enviando datos:', { peliculaId, usuarioId });

    fetch(ruta, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ peliculaId, usuarioId }),
    })
    .then(response => response.json())
    .then(data => {
        const likesElement = contenedor.querySelector('.likes-count'); // Selecciona el número de likes
        likesElement.textContent = data.total_likes; // Actualiza el número de likes
    })
    .catch(error => console.error('Error:', error));
}

function handlePortadaClick(contenedor) {
    const usuarioId = contenedor.dataset.usuarioId; // Obtener el ID del usuario desde el contenedor

    if (!usuarioId) {
        // Si no hay ID de usuario, mostrar alerta de SweetAlert2
        Swal.fire({
            title: '¡Atención!',
            text: 'Debes iniciar sesión para ver los detalles de la película.',
            showCancelButton: true,
            confirmButtonText: 'Iniciar sesión',
            cancelButtonText: 'Cerrar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'view/login.php'; // Redirigir a la página de inicio de sesión
            }
        });
        return; // Salir de la función si el usuario no está autenticado
    }

    // Si el usuario está autenticado, redirigir a la página de detalles de la película
    const peliculaId = contenedor.dataset.peliculaId; // Obtener el ID de la película
    window.location.href = `view/detalle_pelicula.php?id=${peliculaId}`; // Redirigir a la página de detalles
}