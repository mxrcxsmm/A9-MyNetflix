<?php

include '../conexion.php';

try {
    // Verificar si se enviaron datos por POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener los datos del formulario
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $contrasena = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashear la contraseña
        $correo = $_POST['email'];
        $id_rol = 2; // Rol de usuario normal (no administrador)

        // Insertar el usuario en la tabla Usuario
        $sql = "INSERT INTO usuario (nombre, apellidos, contrasena, correo, id_rol, estado_cuenta) 
                VALUES (:nombre, :apellidos, :contrasena, :correo, :id_rol, 'pendiente')";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':nombre' => $nombre,
            ':apellidos' => $apellidos,
            ':contrasena' => $contrasena,
            ':correo' => $correo,
            ':id_rol' => $id_rol
        ]);

        // Obtener el ID del usuario recién insertado
        $id_usuario = $pdo->lastInsertId();

        // Insertar una solicitud de aprobación en la tabla solicitudes_aprobacion (opcional)
        $sql_solicitud = "INSERT INTO solicitudes_aprobacion (id_usuario) VALUES (:id_usuario)";
        $stmt_solicitud = $pdo->prepare($sql_solicitud);
        $stmt_solicitud->execute([':id_usuario' => $id_usuario]);

        echo "Registro exitoso. Tu cuenta está pendiente de aprobación por el administrador.";
    } else {
        echo "Error: No se recibieron datos del formulario.";
    }
} catch (PDOException $e) {
    echo "Error al registrar el usuario: " . $e->getMessage();
}