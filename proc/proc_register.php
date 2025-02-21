<?php

include '../conexion.php';

try {
    // Verificar si se enviaron datos por POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Comprobar si se está comprobando el correo
        if (isset($_POST['check_email'])) {
            $email = $_POST['email'];

            // Verificar si el correo ya está registrado
            $sql_check = "SELECT COUNT(*) FROM usuario WHERE correo = :email";
            $stmt_check = $pdo->prepare($sql_check);
            $stmt_check->execute([':email' => $email]);
            $count = $stmt_check->fetchColumn();

            if ($count > 0) {
                // Redirigir a la página de registro con un mensaje de error
                header('Location: ../view/registro.php?error=email');
                exit();
            } else {
                exit();
            }
        }

        // Comprobar si las claves existen en el array $_POST
        if (isset($_POST['nombre'], $_POST['apellidos'], $_POST['password'], $_POST['email'])) {
            // Obtener los datos del formulario
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashear la contraseña
            $email = $_POST['email'];
            $id_rol = 2; // Rol de usuario normal (no administrador)

            // Insertar el usuario en la tabla Usuario
            $sql = "INSERT INTO usuario (nombre, apellidos, contrasena, correo, id_rol, estado_cuenta) 
                    VALUES (:nombre, :apellidos, :password, :email, :id_rol, 'pendiente')";
            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre' => $nombre,
                ':apellidos' => $apellidos,
                ':password' => $password,
                ':email' => $email,
                ':id_rol' => $id_rol
            ]);

            // Obtener el ID del usuario recién insertado
            $id_usuario = $pdo->lastInsertId();

            // Insertar una solicitud de aprobación en la tabla solicitudes_aprobacion (opcional)
            $sql_solicitud = "INSERT INTO solicitudes_aprobacion (id_usuario) VALUES (:id_usuario)";
            $stmt_solicitud = $pdo->prepare($sql_solicitud);
            $stmt_solicitud->execute([':id_usuario' => $id_usuario]);

            // Redirigir a la página de inicio con un mensaje de éxito
            header('Location: ../index.php?success=1');
            exit();
        } else {
            echo "Error: Todos los campos son obligatorios.";
        }
    } else {
        echo "Error: No se recibieron datos del formulario.";
    }
} catch (PDOException $e) {
    echo "Error al registrar el usuario: " . $e->getMessage();
}