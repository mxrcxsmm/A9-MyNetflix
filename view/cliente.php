<?php
session_start();
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Verificar si el usuario está autenticado
if (!isset($_SESSION['estado_cuenta'])) {
    header("Location: ../view/login.php"); // Redirigir si no está autenticado
    exit();
}

// Verificar el estado de la cuenta
if ($_SESSION['estado_cuenta'] == 'pendiente') {
    // Mostrar mensaje de cuenta pendiente
    ?>
    <div class="divPendiente">
        <form class="formPendiente w-50" action="../proc/logout.php">
            <h1>Has iniciado sesión como <?php echo $_SESSION['nombre'] . " " . $_SESSION['apellidos']; ?></h1>
            <h3>Tu cuenta está pendiente de ser aprobada por un administrador. Vuelve a intentarlo más tarde</h3>
        </form>
    </div>
    <?php
    exit();
}

// Si la cuenta está aprobada, mostrar el catálogo de películas
$sql = "SELECT p.id_pelicula, p.titulo, p.portada, 
            (SELECT COUNT(*) FROM likes_pelicula l WHERE l.id_pelicula = p.id_pelicula AND l.id_usuario = :id_usuario) AS total_likes
        FROM pelicula p";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_usuario', $_SESSION['id_usuario']);
$stmt->execute();
$peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Películas</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="fondoPeliculaAdmin">
    <header class="navbar navbar-expand-lg header-index flex-column">
        <div class="container-fluid d-flex justify-content-between align-items-center div">
            <img src="../img/logoM&M.png" alt="Logo de MyNetflix" class="logo">
            <div>
                <a href="../proc/logout.php"><button class="btn btn-danger me-2">Cerrar sesión</button></a>
            </div>
        </div>
    </header>

    <div class="container mt-5">
        <h2 class="text-center">Catálogo de Películas</h2>
        <div class="row">
            <?php foreach ($peliculas as $pelicula): ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="../img/<?= htmlspecialchars($pelicula['portada']) ?>" class="card-img-top" alt="<?= htmlspecialchars($pelicula['titulo']) ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($pelicula['titulo']) ?></h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>