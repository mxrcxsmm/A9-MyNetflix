<?php 

include '../conexion.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
  </head>
<body class="fondoRegistroInicioSesion justify-content-center align-items-center" style="min-height: 100vh;">
<div class="container headerRegistro">
  <a href="index.php">
    <img src="../img/logoM&M.png" alt="logo" class="logo2">
  </a>
</div>
<div class="container d-flex justify-content-center align-items-center">
<form class="container formRegistro" style="max-width: 500px;">
  <h2 class="mb-4 fw-bold">Registrate</h2>
  <div class="mb-3">
    <input type="text" class="form-control" id="nombre" placeholder="Nombre">
  </div>
  <br>
  <div class="mb-3">
    <input type="text" class="form-control" id="apellidos" placeholder="Apellidos">
  </div>
  <br>
  <div class="mb-3">
    <input type="email" class="form-control" id="email" placeholder="Email">
  </div>
  <br>
  <div class="mb-3">
    <input type="password" class="form-control" id="password" placeholder="Contraseña">
  </div>
  <br>
  <div class="mb-3">
    <input type="repetirpassword" class="form-control" id="repetirpassword" placeholder="Repetir contraseña">
  </div>
  <br>
  <button type="submit" class="btn btn-danger w-100">Registrarse</button>
</form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>