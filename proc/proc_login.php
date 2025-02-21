<?php
session_start();
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Preparar la consulta para buscar el usuario
    $sql = "SELECT id_usuario, contrasena, id_rol FROM usuario WHERE correo = :correo";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();

    // Verificar si se encontró el usuario
    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verificar la contraseña
        if (password_verify($contrasena, $usuario['contrasena'])) {
            // Iniciar sesión
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['correo'] = $correo;
            $_SESSION['id_rol'] = $usuario['id_rol']; // Guardar el rol en la sesión

            // Redirigir según el rol
            if ($usuario['id_rol'] == 1) { // Suponiendo que 1 es el rol de administrador
                header("Location: ../view/admin.php"); // Redirigir a la página de admin
            } else {
                header("Location: ../view/cliente.php"); // Redirigir a la página de cliente
            }
            exit();
        } else {
            $_SESSION['error'] = "Contraseña incorrecta.";
            header("Location: ../view/login.php"); // Redirigir de nuevo al formulario de login
            exit();
        }
    } else {
        $_SESSION['error'] = "El correo electrónico no está registrado.";
        header("Location: ../view/login.php"); // Redirigir de nuevo al formulario de login
        exit();
    }
} else {
    header("Location: ../view/login.php"); // Redirigir si no es una solicitud POST
    exit();
} 