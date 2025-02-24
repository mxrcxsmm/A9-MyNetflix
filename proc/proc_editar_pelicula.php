<?php
session_start();
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Verificar si el usuario es admin
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: ../view/login.php"); // Redirigir si no es admin
    exit();
}

// Editar una película
if (isset($_POST['modificar'])) {
    $id_pelicula = $_POST['id_pelicula'];
    $titulo = $_POST['titulo'];
    $portada = $_POST['portada'];
    $sinopsis = $_POST['sinopsis'];
    $ano_estreno = $_POST['ano_estreno'];
    $generos = $_POST['genero']; // Obtener los géneros seleccionados

    // Actualizar la información de la película
    $sql = "UPDATE pelicula SET titulo = :titulo, portada = :portada, sinopsis = :sinopsis, ano_estreno = :ano_estreno WHERE id_pelicula = :id_pelicula";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':portada', $portada);
    $stmt->bindParam(':sinopsis', $sinopsis);
    $stmt->bindParam(':ano_estreno', $ano_estreno);
    $stmt->bindParam(':id_pelicula', $id_pelicula);
    $stmt->execute();

    // Eliminar géneros existentes para la película
    $sql_delete = "DELETE FROM int_genero_pelicula WHERE id_pelicula = :id_pelicula";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->bindParam(':id_pelicula', $id_pelicula);
    $stmt_delete->execute();

    // Insertar los nuevos géneros
    foreach ($generos as $id_genero) {
        $sql_insert = "INSERT INTO int_genero_pelicula (id_genero, id_pelicula) VALUES (:id_genero, :id_pelicula)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->bindParam(':id_genero', $id_genero);
        $stmt_insert->bindParam(':id_pelicula', $id_pelicula);
        $stmt_insert->execute();
    }

    header("Location: ../view/peliculas.php?mensaje=Película modificada con éxito"); // Redirigir después de modificar
    exit();
}
?> 