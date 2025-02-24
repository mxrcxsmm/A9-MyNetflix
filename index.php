<?php

include_once 'conexion.php';
include_once 'proc/proc_index.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyNetflix</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Exo:ital,wght@0,100..900;1,100..900&family=Golos+Text:wght@400..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    
    <header class="navbar navbar-expand-lg header-index flex-column">
        <div class="container-fluid d-flex justify-content-between align-items-center div">
            <img src="img/logoM&M.png" alt="Logo de MyNetflix" class="logo">
            <div>
                <a href="view/login.php"><button class="btn btn-outline-light me-2">Iniciar Sesión</button></a>
                <a href="view/registro.php"><button class="btn btn-primary">Registrarse</button></a>
            </div>
        </div>
        <div class="container-fluid text-center mt-3 justify-content-center" id="titulo-index">
            <h1 class="text-light titulo-index">LA MEJOR PLATAFORMA DE STREAMING</h1>
        </div>
    </header>

    <div class="container-fluid mt-4">
        <h1 class="text-center">TOP 5 PELÍCULAS</h2>
        <br>
        <div class="row justify-content-center">
            <?php foreach ($top5 as $pelicula): ?>
                <div class="col-md-2 text-center">
                    <a href="view/detalle_pelicula.php?id=<?= htmlspecialchars($pelicula['id_pelicula']) ?>">
                        <img class="tamañoImg" src="img/<?= htmlspecialchars($pelicula['portada']) ?>" alt="<?= htmlspecialchars($pelicula['titulo']) ?>" class="img-fluid">
                    </a>
                    <p class="titulo-pelicula"> <?= htmlspecialchars($pelicula['titulo']) ?> </p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="container mt-5">
        <h2 class="text-center">Todas las Películas</h2>
        <div class="row">
            <?php foreach ($peliculas as $pelicula): ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="img/<?= htmlspecialchars($pelicula['portada']) ?>" class="card-img-top" alt="<?= htmlspecialchars($pelicula['titulo']) ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"> <?= htmlspecialchars($pelicula['titulo']) ?> </h5>
                            <p class="likes">
                                <?= htmlspecialchars($pelicula['total_likes']) ?>
                                <div class="contenedor" onclick="toggleCorazon(this)">
                                    <svg class="corazon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="js/like_btn.js"></script>

    <script>
    // Mostrar SweetAlert2 si el registro fue exitoso
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        Swal.fire({
            icon: 'success',
            title: 'Registro completado',
            text: 'Tu cuenta está pendiente de aprobación por el administrador.',
            confirmButtonText: 'Aceptar'
        });
    }
  </script>
</body>
</html>
