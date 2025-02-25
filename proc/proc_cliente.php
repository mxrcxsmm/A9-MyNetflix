<?php
session_start();
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Verificar si el usuario está autenticado
if (!isset($_SESSION['estado_cuenta'])) {
    header("Location: ../view/login.php"); // Redirigir si no está autenticado
    exit();
}

// Procesar el "like" de una película
if (isset($_POST['like'])) {
    $id_pelicula = $_POST['id_pelicula'];
    $id_usuario = $_SESSION['id_usuario'];

    // Verificar si ya existe un "like"
    $sql = "SELECT COUNT(*) FROM likes_pelicula WHERE id_usuario = :id_usuario AND id_pelicula = :id_pelicula";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':id_pelicula', $id_pelicula);
    $stmt->execute();
    $exists = $stmt->fetchColumn();

    if ($exists) {
        // Si ya existe, eliminar el "like"
        $sql = "DELETE FROM likes_pelicula WHERE id_usuario = :id_usuario AND id_pelicula = :id_pelicula";
    } else {
        // Si no existe, agregar el "like"
        $sql = "INSERT INTO likes_pelicula (id_usuario, id_pelicula) VALUES (:id_usuario, :id_pelicula)";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':id_pelicula', $id_pelicula);
    $stmt->execute();

    header("Location: ../view/cliente.php"); // Redirigir al catálogo después de procesar
    exit();
}

// Filtrar películas por "like"
if (isset($_POST['filtrar'])) {
    // Lógica para filtrar las películas según los "likes"
    // ...
}
?> 