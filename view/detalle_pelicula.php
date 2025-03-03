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
$sql = "SELECT p.titulo, p.portada, p.sinopsis, p.ano_estreno, 
            GROUP_CONCAT(g.nombre_genero) AS generos,
            (SELECT COUNT(*) FROM likes_pelicula l WHERE l.id_pelicula = p.id_pelicula) AS total_likes,
            (SELECT GROUP_CONCAT(per.nombre_personal, ' ', per.apellidos_personal) FROM int_personal_pelicula ipp 
             JOIN personal per ON ipp.id_personal = per.id_personal 
             WHERE ipp.id_pelicula = p.id_pelicula) AS reparto
        FROM pelicula p
        LEFT JOIN int_genero_pelicula igp ON p.id_pelicula = igp.id_pelicula
        LEFT JOIN genero g ON igp.id_genero = g.id_genero
        WHERE p.id_pelicula = :id_pelicula
        GROUP BY p.id_pelicula"; // Agrupar por ID de película para obtener los géneros
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_pelicula', $id_pelicula);
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
                <p><strong>Total Likes:</strong> <?= htmlspecialchars($pelicula['total_likes']) ?></p>
                <div class="btnIndex">
                    <a href="../index.php" class="btn btn-primary">Volver a la lista de películas</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 