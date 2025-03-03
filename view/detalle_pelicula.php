<?php
session_start();
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Verificar si se ha pasado el ID de la película
if (!isset($_GET['id'])) {
    header("Location: peliculas.php"); // Redirigir si no se proporciona un ID
    exit();
}

$id_pelicula = $_GET['id'];

// Obtener la información de la película
$sql = "SELECT p.id_pelicula, p.titulo, p.portada, p.sinopsis, p.ano_estreno, 
            GROUP_CONCAT(g.nombre_genero) AS generos,
            (SELECT COUNT(*) FROM likes_pelicula l WHERE l.id_pelicula = p.id_pelicula) AS total_likes,
            (SELECT GROUP_CONCAT(per.nombre_personal, ' ', per.apellidos_personal) FROM int_personal_pelicula ipp 
             JOIN personal per ON ipp.id_personal = per.id_personal 
             WHERE ipp.id_pelicula = p.id_pelicula) AS reparto,
            (SELECT COUNT(*) FROM likes_pelicula l WHERE l.id_pelicula = p.id_pelicula AND l.id_usuario = :id_usuario) AS user_liked
        FROM pelicula p
        LEFT JOIN int_genero_pelicula igp ON p.id_pelicula = igp.id_pelicula
        LEFT JOIN genero g ON igp.id_genero = g.id_genero
        WHERE p.id_pelicula = :id_pelicula
        GROUP BY p.id_pelicula"; // Agrupar por ID de película para obtener los géneros
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_pelicula', $id_pelicula);
$stmt->bindParam(':id_usuario', $_SESSION['id_usuario']);
$stmt->execute();
$pelicula = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar si se encontró la película
if (!$pelicula) {
    header("Location: peliculas.php"); // Redirigir si no se encuentra la película
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pelicula['titulo']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="fondoPeliculaAdmin">
    <div class="container mt-5">
        <br>
        <h1 class="tituloPelicula"><?= htmlspecialchars($pelicula['titulo']) ?></h1>
        <br>
        <div class="row">
            <div class="col-md-4 text-center">
                <img class="tamañoImg3" src="../img/<?= htmlspecialchars($pelicula['portada']) ?>" alt="<?= htmlspecialchars($pelicula['titulo']) ?>" class="img-fluid" style="max-width: 100%; height: auto;">
            </div>
            <div class="col-md-8 centrarDatos">
                <p class="sinopsis"><strong>Sinopsis:</strong> <?= htmlspecialchars($pelicula['sinopsis']) ?></p>
                <p><strong>Año de Estreno:</strong> <?= htmlspecialchars($pelicula['ano_estreno']) ?></p>
                <p><strong>Género:</strong>
                    <ul class="lista-generos">
                        <?php 
                        // Convertir los géneros en un array y mostrarlos como lista
                        $generos_array = explode(',', htmlspecialchars($pelicula['generos']));
                        foreach ($generos_array as $genero): ?>
                            <li><?= trim($genero) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </p>
                <p><strong>Reparto:</strong>
                    <ul class="lista-generos">
                        <?php 
                        // Convertir el reparto en un array y mostrarlos como lista
                        $reparto_array = explode(',', htmlspecialchars($pelicula['reparto']));
                        foreach ($reparto_array as $actor): ?>
                            <li><?= trim($actor) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </p>
                <div class="derecha contenedor <?= $pelicula['user_liked'] > 0 ? 'active' : '' ?>" data-pelicula-id="<?= htmlspecialchars($pelicula['id_pelicula']) ?>" data-usuario-id="<?= $_SESSION['id_usuario'] ?>" onclick="toggleCorazon(this)">
                    <p class="likes">
                        <span class="likes-count"><?= htmlspecialchars($pelicula['total_likes']) ?></span>
                        <svg class="corazon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg>
                    </p>
                </div>
                
                <div class="btnIndex">
                    <a href="../index.php" class="btn btn-primary">Volver a la lista de películas</a>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/like_btn.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 