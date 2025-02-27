<?php
session_start();
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Verificar si el usuario es admin
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: login.php"); // Redirigir si no es admin
    exit();
}

// Obtener todas las películas inicialmente
$sql = "SELECT p.id_pelicula, p.titulo, p.portada, p.sinopsis, p.ano_estreno, p.nacionalidad,
            (SELECT GROUP_CONCAT(g.nombre_genero) FROM int_genero_pelicula igp 
             JOIN genero g ON igp.id_genero = g.id_genero 
             WHERE igp.id_pelicula = p.id_pelicula) AS generos,
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Incluir SweetAlert2 -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="fondoPeliculaAdmin">
    <div class="container table-container">
        <h2 class="catalogo">Catálogo de Películas</h2>

        <?php if (isset($_GET['mensaje'])): ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($_GET['mensaje']) ?>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between mb-3">
            <div>
                <a href="crear_pelicula.php" class="btn btn-success">Añadir nueva película</a>
            </div>
            <div>
                <a href="admin.php" class="btn btn-info">Usuarios</a>
                <a href="../proc/logout.php" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>

        <form id="searchForm" class="mb-3" method="POST" action="peliculas.php">
            <div class="input-group">
                <input type="text" name="titulo" class="form-control" placeholder="Buscar por título...">
                <input type="text" name="actor" class="form-control" placeholder="Buscar por actor...">
                <input type="text" name="genero" class="form-control" placeholder="Buscar por género...">
                <input type="number" name="ano_estreno" class="form-control" placeholder="Buscar por año...">
                <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
            </div>
        </form>

        <table class="table" id="peliculasTable">
            <thead>
                <tr>
                    <th>Portada</th>
                    <th class="titulo">Título</th>
                    <th>Sinopsis</th>
                    <th>Nacionalidad</th>
                    <th>Géneros</th>
                    <th class="ano">Año estreno</th>
                    <th>Likes</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($peliculas as $pelicula): ?>
                    <tr>
                        <td><img src="../img/<?= htmlspecialchars($pelicula['portada']) ?>" alt="<?= htmlspecialchars($pelicula['titulo']) ?>" style="width: 100px;"></td>
                        <td><?= htmlspecialchars($pelicula['titulo']) ?></td>
                        <td><?= htmlspecialchars($pelicula['sinopsis']) ?></td>
                        <td><?= htmlspecialchars($pelicula['nacionalidad']) ?></td>
                        <td>
                            <ul>
                                <?php
                                // Convertir los géneros en un array y mostrarlos como lista
                                $generos_array = explode(',', htmlspecialchars($pelicula['generos']));
                                foreach ($generos_array as $genero): ?>
                                    <li><?= trim($genero) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td><?= htmlspecialchars($pelicula['ano_estreno']) ?></td>
                        <td><?= htmlspecialchars($pelicula['total_likes']) ?></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-danger" onclick="confirmDelete(<?= htmlspecialchars($pelicula['id_pelicula']) ?>)">Eliminar</button>
                                <a href="editar_pelicula.php?id=<?= htmlspecialchars($pelicula['id_pelicula']) ?>" class="btn btn-warning">Modificar</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '../proc/proc_eliminar_pelicula.php';
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'id_pelicula';
                    input.value = id;
                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

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