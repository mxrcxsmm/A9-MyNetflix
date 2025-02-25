<?php
session_start(); // Iniciar sesión para manejar la sesión del usuario
include_once '../conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - MyNetflix</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="fondoRegistroInicioSesion justify-content-center align-items-center" style="min-height: 100vh;">
<div class="container headerRegistro">
  <a href="../index.php">
    <img src="../img/logoM&M.png" alt="logo" class="logo2">
  </a>
</div>
<div class="container d-flex justify-content-center align-items-center">
<form action="../proc/proc_login.php" method="POST" class="container formRegistro" style="max-width: 500px;">
    <h2 class="mb-4 fw-bold">Iniciar Sesión</h2>
    <div class="mb-3">
        <label for="correo" class="form-label">Correo Electrónico</label>
        <input type="email" class="form-control" id="correo" name="correo" required>
    </div>
    <div class="mb-3">
        <label for="contrasena" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="contrasena" name="contrasena" required>
    </div>
    <button type="submit" class="btn btn-danger w-100">Iniciar Sesión</button>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger mt-3"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <p id="submitError" class="error" ></p>
    <p>¿No tienes cuenta? <a class="enlace" href="registro.php">Crea una cuenta</a></p>

</form>
</div>
</body>
</html>