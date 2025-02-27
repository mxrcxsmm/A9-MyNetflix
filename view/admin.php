<?php
session_start();
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Verificar si el usuario es admin
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: login.php"); // Redirigir si no es admin
    exit();
}

// Obtener todos los usuarios
$sql_all = "SELECT id_usuario, nombre, apellidos, correo, estado_cuenta FROM Usuario";
$stmt_all = $pdo->prepare($sql_all);
$stmt_all->execute();
$usuarios = $stmt_all->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración - Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="fondoPeliculaAdmin">
    <div class="container mt-5">
        <h1 class="catalogo">Administración de Usuarios</h1>

        <div class="mb-3 text-end">
            <a href="peliculas.php" class="btn btn-primary">Películas</a>
            <a href="../proc/logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Correo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                        <td><?= htmlspecialchars($usuario['apellidos']) ?></td>
                        <td><?= htmlspecialchars($usuario['correo']) ?></td>
                        <td><?= htmlspecialchars($usuario['estado_cuenta']) ?></td>
                        <td>
                            <form action="../proc/proc_admin.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuario['id_usuario']) ?>">
                                <?php if ($usuario['estado_cuenta'] == 'pendiente'): ?>
                                    <button type="submit" name="validar" class="btn btn-success">Aprobar</button>
                                <?php else: ?>
                                    <button type="submit" name="desactivar" class="btn btn-danger">Desactivar</button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html> 