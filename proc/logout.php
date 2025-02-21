<?php
session_start(); // Iniciar la sesión
session_destroy(); // Destruir la sesión para cerrar sesión
header("Location: ../index.php"); // Redirigir a la página de inicio
exit();
?> 