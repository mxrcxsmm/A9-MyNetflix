<?php
try {
    $host = "localhost";
    $dbname = "netflix";
    $usuario = "root";
    $contrasena = "";

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $contrasena);
    
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die();
}
?>
