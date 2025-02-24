<?php
session_start();
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Verificar si el usuario es admin
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: ../view/login.php"); // Redirigir si no es admin
    exit();
}

// Obtener la información de la película
if (isset($_GET['id'])) {
    $id_pelicula = $_GET['id'];
    $sql = "SELECT * FROM pelicula WHERE id_pelicula = :id_pelicula";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_pelicula', $id_pelicula);
    $stmt->execute();
    $pelicula = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pelicula) {
        header("Location: ../view/peliculas.php"); // Redirigir si no se encuentra la película
        exit();
    }
} else {
    header("Location: ../view/peliculas.php"); // Redirigir si no se proporciona un ID
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Película</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Película</h2>
        <form action="../proc/proc_editar_pelicula.php" method="POST">
            <input type="hidden" name="id_pelicula" value="<?= htmlspecialchars($pelicula['id_pelicula']) ?>">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" name="titulo" value="<?= htmlspecialchars($pelicula['titulo']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="portada" class="form-label">Portada</label>
                <input type="text" class="form-control" name="portada" value="<?= htmlspecialchars($pelicula['portada']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="sinopsis" class="form-label">Sinopsis</label>
                <textarea class="form-control" name="sinopsis" required><?= htmlspecialchars($pelicula['sinopsis']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="ano_estreno" class="form-label">Año de Estreno</label>
                <input type="number" class="form-control" name="ano_estreno" value="<?= htmlspecialchars($pelicula['ano_estreno']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="genero" class="form-label">Género</label>
                <select name="genero[]" class="form-control" multiple required>
                    <?php
                    // Obtener todos los géneros para el select
                    $sql_generos = "SELECT * FROM genero";
                    $stmt_generos = $pdo->prepare($sql_generos);
                    $stmt_generos->execute();
                    $generos = $stmt_generos->fetchAll(PDO::FETCH_ASSOC);

                    // Obtener los géneros actuales de la película
                    $sql_generos_pelicula = "SELECT g.id_genero FROM int_genero_pelicula igp 
                                              JOIN genero g ON igp.id_genero = g.id_genero 
                                              WHERE igp.id_pelicula = :id_pelicula";
                    $stmt_generos_pelicula = $pdo->prepare($sql_generos_pelicula);
                    $stmt_generos_pelicula->bindParam(':id_pelicula', $pelicula['id_pelicula']);
                    $stmt_generos_pelicula->execute();
                    $generos_pelicula = $stmt_generos_pelicula->fetchAll(PDO::FETCH_COLUMN);

                    foreach ($generos as $genero) {
                        $selected = in_array($genero['id_genero'], $generos_pelicula) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($genero['id_genero']) . '" ' . $selected . '>' . htmlspecialchars($genero['nombre_genero']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="modificar" class="btn btn-primary">Modificar</button>
            <a href="peliculas.php" class="btn btn-secondary">Cancelar</a> <!-- Botón para cancelar -->
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 