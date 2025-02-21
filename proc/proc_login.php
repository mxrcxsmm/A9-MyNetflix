<?php
session_start();
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Preparar la consulta para buscar el usuario
    $sql = "SELECT id_usuario, contrasena FROM Usuario WHERE correo = :correo";
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
            header("Location: ../view/index.php"); // Redirigir a la página principal
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