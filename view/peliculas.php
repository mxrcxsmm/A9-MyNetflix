<?php
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Inicializar la variable de películas
$peliculas = [];

// Verificar si se ha enviado el formulario de búsqueda
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once '../proc/proc_peliculas.php'; // Incluir el archivo que maneja la búsqueda
} else {
    // Si no se ha enviado el formulario, puedes cargar todas las películas o dejarlo vacío
    $sql = "SELECT p.id_pelicula, 
                   p.titulo, 
                   p.portada, 
                   p.sinopsis, 
                   p.ano_estreno, 
                   p.nacionalidad,
                   GROUP_CONCAT(g.nombre_genero) AS generos,
                   COUNT(l.id_pelicula) AS total_likes
            FROM pelicula p
            LEFT JOIN int_genero_pelicula igp ON p.id_pelicula = igp.id_pelicula
            LEFT JOIN genero g ON igp.id_genero = g.id_genero
            LEFT JOIN likes_pelicula l ON p.id_pelicula = l.id_pelicula
            GROUP BY p.id_pelicula
            ORDER BY p.titulo";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
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
        <br>
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

        <form id="searchForm" class="mb-3" method="POST">
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
    </script>
</body>

</html>