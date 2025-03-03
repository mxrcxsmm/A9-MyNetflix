<?php
session_start();
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Verificar si el usuario es admin
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: ../view/login.php"); // Redirigir si no es admin
    exit();
}

// Eliminar una película
if (isset($_POST['id_pelicula'])) {
    $id_pelicula = $_POST['id_pelicula'];

    try {
        // Iniciar la transacción
        $pdo->beginTransaction();

        // Primero, obtener la portada de la película para eliminar el archivo
        $sql_get_portada = "SELECT portada FROM pelicula WHERE id_pelicula = :id_pelicula";
        $stmt_get_portada = $pdo->prepare($sql_get_portada);
        $stmt_get_portada->bindParam(':id_pelicula', $id_pelicula);
        $stmt_get_portada->execute();
        $portada = $stmt_get_portada->fetchColumn();

        // Eliminar los géneros asociados a la película
        $sql_delete_genres = "DELETE FROM int_genero_pelicula WHERE id_pelicula = :id_pelicula";
        $stmt_delete_genres = $pdo->prepare($sql_delete_genres);
        $stmt_delete_genres->bindParam(':id_pelicula', $id_pelicula);
        $stmt_delete_genres->execute();

        // Eliminar los registros de personal asociados a la película
        $sql_delete_personal = "DELETE FROM int_personal_pelicula WHERE id_pelicula = :id_pelicula";
        $stmt_delete_personal = $pdo->prepare($sql_delete_personal);
        $stmt_delete_personal->bindParam(':id_pelicula', $id_pelicula);
        $stmt_delete_personal->execute();

        // Luego, eliminar la película
        $sql_delete = "DELETE FROM pelicula WHERE id_pelicula = :id_pelicula";
        $stmt_delete = $pdo->prepare($sql_delete);
        $stmt_delete->bindParam(':id_pelicula', $id_pelicula);
        $stmt_delete->execute();

        // Confirmar la transacción
        $pdo->commit();

        // Eliminar el archivo de la portada si existe
        if ($portada) {
            $file_path = '../img/' . $portada; // Ajusta la ruta según tu estructura de carpetas
            if (file_exists($file_path)) {
                unlink($file_path); // Eliminar el archivo
            }
        }

        // Redirigir a la página de películas con un mensaje de éxito
        header("Location: ../view/peliculas.php?mensaje=Película eliminada con éxito"); // Redirigir después de eliminar
        exit();
    } catch (Exception $e) {
        // Si hay un error, revertir la transacción
        $pdo->rollBack();
        echo "Error al eliminar la película: " . $e->getMessage();
    }
}
?>