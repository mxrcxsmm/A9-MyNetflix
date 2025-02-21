<?php
session_start();
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Verificar si el usuario es admin
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: ../view/login.php"); // Redirigir si no es admin
    exit();
}

// Procesar la validación de usuarios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['validar'])) {
        $id_usuario = $_POST['id_usuario'];
        $sql = "UPDATE Usuario SET estado_cuenta = 'aprobada' WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
    } elseif (isset($_POST['activar'])) {
        $id_usuario = $_POST['id_usuario'];
        $sql = "UPDATE Usuario SET estado_cuenta = 'aprobada' WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
    } elseif (isset($_POST['desactivar'])) {
        $id_usuario = $_POST['id_usuario'];
        $sql = "UPDATE Usuario SET estado_cuenta = 'pendiente' WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
    }
}

// Redirigir de nuevo a la página de administración
header("Location: ../view/admin.php");
exit();
?> 