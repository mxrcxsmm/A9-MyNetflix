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
$sql = "SELECT p.titulo, p.portada, p.sinopsis, p.ano_estreno, p.genero, 
            (SELECT COUNT(*) FROM likes_pelicula l WHERE l.id_pelicula = p.id_pelicula) AS total_likes
        FROM pelicula p
        WHERE p.id_pelicula = :id_pelicula";
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
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center"><?= htmlspecialchars($pelicula['titulo']) ?></h2>
        <div class="text-center">
            <img src="../img/<?= htmlspecialchars($pelicula['portada']) ?>" alt="<?= htmlspecialchars($pelicula['titulo']) ?>" class="img-fluid" style="max-width: 500px;">
        </div>
        <p><strong>Sinopsis:</strong> <?= htmlspecialchars($pelicula['sinopsis']) ?></p>
        <p><strong>Año de Estreno:</strong> <?= htmlspecialchars($pelicula['ano_estreno']) ?></p>
        <p><strong>Género:</strong> <?= htmlspecialchars($pelicula['genero']) ?></p>
        <p><strong>Total Likes:</strong> <?= htmlspecialchars($pelicula['total_likes']) ?></p>
        <div class="text-center">
            <a href="peliculas.php" class="btn btn-primary">Volver a la lista de películas</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 