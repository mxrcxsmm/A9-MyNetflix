<?php

include_once '../conexion.php';
include_once '../proc/proc_index.php';

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
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    
    <header class="navbar navbar-expand-lg header-index flex-column">
        <div class="container-fluid d-flex justify-content-between align-items-center div">
            <img src="../img/logoM&M.png" alt="Logo de MyNetflix" class="logo">
            <div>
                <a href="login.php"><button class="btn btn-outline-light me-2">Iniciar Sesión</button></a>
                <a href="registro.php"><button class="btn btn-primary">Registrarse</button></a>
            </div>
        </div>
        <div class="container-fluid text-center mt-3 justify-content-center" id="titulo-index">
            <h1 class="text-light titulo-index">LA MEJOR PLATAFORMA DE STREAMING</h1>
        </div>
    </header>

    <div class="container-fluid mt-4">
        <h2 class="text-center">TOP 5 PELÍCULAS</h2>
        <div class="row justify-content-center">
            <?php foreach ($top5 as $pelicula): ?>
                <div class="col-md-2 text-center">
                    <img src="../img/<?= htmlspecialchars($pelicula['portada']) ?>" alt="<?= htmlspecialchars($pelicula['titulo']) ?>" class="img-fluid">
                    <p> <?= htmlspecialchars($pelicula['titulo']) ?> </p>
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
                        <img src="../img/<?= htmlspecialchars($pelicula['portada']) ?>" class="card-img-top" alt="<?= htmlspecialchars($pelicula['titulo']) ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"> <?= htmlspecialchars($pelicula['titulo']) ?> </h5>
                            <p class="likes">
                                <i class="bi bi-hand-thumbs-up"></i> 
                                <?= htmlspecialchars($pelicula['total_likes']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
