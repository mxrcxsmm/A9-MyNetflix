<?php

include_once 'conexion.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Exo:ital,wght@0,100..900;1,100..900&family=Golos+Text:wght@400..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <header class="navbar navbar-expand-lg header-index flex-column">
        <div class="container-fluid d-flex justify-content-between align-items-center div">
            <img src="img/logoM&M.png" alt="Logo de MyNetflix" class="logo">
            <div>
                <a href="login.php"><button class="btn btn-outline-light me-2">Iniciar Sesión</button></a>
                <a href="registro.php"><button class="btn btn-primary">Registrarse</button></a>
            </div>
        </div>
        <div class="container-fluid text-center mt-3 justify-content-center" id="titulo-index">
            <h1 class="text-light titulo-index">LA MEJOR PLATAFORMA DE STREAMING</h1>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h2>TOP 5</h2>
            </div>
        </div>
    </div>

    <!-- Mostrar las primeras 5 imágenes de la base de datos en línea -->
    <div class="container-fluid">
        <div class="d-flex flex-wrap">
            <?php
            $sql = "SELECT id_pelicula, portada FROM pelicula LIMIT 5";
            $stmt = $pdo->query($sql);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="p-2">';
                echo '<div style="width: 300px; height: 450px;">';
                echo '<img src="' . htmlspecialchars($row['portada']) . '" style="border-radius: 10px"/>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <a href="./subir.php">Subir imagenes</a>

</body>
</html>