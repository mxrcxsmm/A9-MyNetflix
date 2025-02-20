<?php

include '../conexion.php';

try {
    // Preparar la consulta SQL para insertar un nuevo usuario
    $sql = "INSERT INTO Usuario (nombre, apellidos, contrasena, correo, id_rol) VALUES (:nombre, :apellidos, :contrasena, :correo, :id_rol)";
    $stmt = $pdo->prepare($sql);

    // Asignar valores a los parámetros
    $nombre = "Juan";
    $apellidos = "Pérez";
    $contrasena = password_hash("mi_contraseña_segura", PASSWORD_BCRYPT);
    $correo = "juan.perez@example.com";
    $id_rol = 1;

    // Ejecutar la consulta
    $stmt->execute([
        ':nombre' => $nombre,
        ':apellidos' => $apellidos,
        ':contrasena' => $contrasena,
        ':correo' => $correo,
        ':id_rol' => $id_rol
    ]);

    echo "Usuario insertado correctamente.";
} catch (PDOException $e) {
    echo "Error al insertar usuario: " . $e->getMessage();
}

?>
