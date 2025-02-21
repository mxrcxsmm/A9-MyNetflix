<?php
session_start();
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Verificar si el usuario es admin
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: login.php"); // Redirigir si no es admin
    exit();
}

// Obtener todas las películas inicialmente
$sql = "SELECT p.id_pelicula, p.titulo, p.portada, 
            (SELECT COUNT(*) FROM likes_pelicula l WHERE l.id_pelicula = p.id_pelicula) AS total_likes
        FROM pelicula p
        ORDER BY p.titulo"; // Cambia a ORDER BY total_likes si deseas ordenar por likes
$stmt = $pdo->prepare($sql);
$stmt->execute();
$peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración - Películas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Incluir jQuery para AJAX -->
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Catálogo de Películas</h2>

        <div class="mb-3 text-end">
            <a href="admin.php" class="btn btn-info">Usuarios</a> <!-- Botón para ir a la página de usuarios -->
            <a href="../proc/logout.php" class="btn btn-danger">Cerrar Sesión</a> <!-- Botón para cerrar sesión -->
        </div>

        <form id="searchForm" class="mb-3">
            <div class="input-group">
                <input type="text" name="titulo" class="form-control" placeholder="Buscar por título...">
                <input type="text" name="actor" class="form-control" placeholder="Buscar por actor...">
                <input type="text" name="genero" class="form-control" placeholder="Buscar por género...">
                <input type="number" name="anio" class="form-control" placeholder="Buscar por año...">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>

        <table class="table" id="peliculasTable">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Portada</th>
                    <th>Likes</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($peliculas as $pelicula): ?>
                    <tr>
                        <td><?= htmlspecialchars($pelicula['titulo']) ?></td>
                        <td><img src="../img/<?= htmlspecialchars($pelicula['portada']) ?>" alt="<?= htmlspecialchars($pelicula['titulo']) ?>" style="width: 100px;"></td>
                        <td><?= htmlspecialchars($pelicula['total_likes']) ?></td>
                        <td>
                            <form action="../proc/proc_peliculas.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id_pelicula" value="<?= htmlspecialchars($pelicula['id_pelicula']) ?>">
                                <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                            </form>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modificarModal<?= $pelicula['id_pelicula'] ?>">Modificar</button>
                        </td>
                    </tr>

                    <!-- Modal para modificar película -->
                    <div class="modal fade" id="modificarModal<?= $pelicula['id_pelicula'] ?>" tabindex="-1" aria-labelledby="modificarModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modificarModalLabel">Modificar Película</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="../proc/proc_peliculas.php" method="POST">
                                        <input type="hidden" name="id_pelicula" value="<?= htmlspecialchars($pelicula['id_pelicula']) ?>">
                                        <div class="mb-3">
                                            <label for="titulo" class="form-label">Título</label>
                                            <input type="text" class="form-control" name="titulo" value="<?= htmlspecialchars($pelicula['titulo']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="portada" class="form-label">Portada</label>
                                            <input type="text" class="form-control" name="portada" value="<?= htmlspecialchars($pelicula['portada']) ?>">
                                        </div>
                                        <button type="submit" name="modificar" class="btn btn-primary">Modificar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
    </script>
</body>
</html> 