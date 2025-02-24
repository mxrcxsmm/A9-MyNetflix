<?php
session_start();
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Verificar si el usuario es admin
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: ../view/login.php"); // Redirigir si no es admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nueva Película</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Añadir Nueva Película</h2>
        <form action="../proc/proc_crear_pelicula.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="portada" class="form-label">Portada (subir archivo)</label>
                <input type="file" class="form-control" name="portada" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label for="sinopsis" class="form-label">Sinopsis</label>
                <textarea class="form-control" name="sinopsis" required></textarea>
            </div>
            <div class="mb-3">
                <label for="ano_estreno" class="form-label">Año de Estreno</label>
                <input type="number" class="form-control" name="ano_estreno" required>
            </div>
            <div class="mb-3">
                <label for="nacionalidad" class="form-label">Nacionalidad</label>
                <input type="text" class="form-control" name="nacionalidad" required>
            </div>
            <div class="mb-3">
                <label for="duracion" class="form-label">Duración (en minutos)</label>
                <input type="number" class="form-control" name="duracion" required>
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

                    foreach ($generos as $genero) {
                        echo '<option value="' . htmlspecialchars($genero['id_genero']) . '">' . htmlspecialchars($genero['nombre_genero']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="agregar" class="btn btn-primary">Añadir Película</button>
            <a href="peliculas.php" class="btn btn-secondary">Cancelar</a> <!-- Botón para cancelar -->
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 