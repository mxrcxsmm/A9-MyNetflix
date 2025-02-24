<?php
session_start();
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Verificar si el usuario es admin
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: ../view/login.php"); // Redirigir si no es admin
    exit();
}

// Verificar si se ha pasado el ID de la película
if (isset($_GET['id'])) {
    $id_pelicula = $_GET['id'];

    // Obtener la información de la película
    $sql = "SELECT p.titulo, p.portada, p.sinopsis, p.ano_estreno, 
                GROUP_CONCAT(g.nombre_genero) AS generos,
                (SELECT COUNT(*) FROM likes_pelicula l WHERE l.id_pelicula = p.id_pelicula) AS total_likes
            FROM pelicula p
            LEFT JOIN int_genero_pelicula igp ON p.id_pelicula = igp.id_pelicula
            LEFT JOIN genero g ON igp.id_genero = g.id_genero
            WHERE p.id_pelicula = :id_pelicula
            GROUP BY p.id_pelicula"; // Agrupar por ID de película para obtener los géneros

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_pelicula', $id_pelicula);
    $stmt->execute();
    $pelicula = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró la película
    if (!$pelicula) {
        header("Location: ../view/peliculas.php"); // Redirigir si no se encuentra la película
        exit();
    }
} else {
    header("Location: ../view/peliculas.php"); // Redirigir si no se proporciona un ID
    exit();
}

// Procesar la búsqueda de películas
if (isset($_POST['buscar'])) {
    $busqueda = $_POST['busqueda'];
    $sql = "SELECT p.id_pelicula, p.titulo, p.portada, 
                (SELECT COUNT(*) FROM likes_pelicula l WHERE l.id_pelicula = p.id_pelicula) AS total_likes
            FROM pelicula p
            WHERE p.titulo LIKE :busqueda
            ORDER BY p.titulo";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':busqueda', '%' . $busqueda . '%');
    $stmt->execute();
    $peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Obtener todas las películas
    $sql = "SELECT p.id_pelicula, p.titulo, p.portada, 
                (SELECT COUNT(*) FROM likes_pelicula l WHERE l.id_pelicula = p.id_pelicula) AS total_likes
            FROM pelicula p
            ORDER BY p.titulo"; // Cambia a ORDER BY total_likes si deseas ordenar por likes
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Agregar una nueva película
if (isset($_POST['agregar'])) {
    $titulo = $_POST['titulo'];
    $portada = $_POST['portada']; // Asegúrate de manejar la carga de imágenes adecuadamente
    $sql = "INSERT INTO pelicula (titulo, portada) VALUES (:titulo, :portada)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':portada', $portada);
    $stmt->execute();
    header("Location: ../view/peliculas.php"); // Redirigir después de agregar
    exit();
}

// Eliminar una película
if (isset($_POST['eliminar'])) {
    $id_pelicula = $_POST['id_pelicula'];
    $sql = "DELETE FROM pelicula WHERE id_pelicula = :id_pelicula";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_pelicula', $id_pelicula);
    $stmt->execute();
    header("Location: ../view/peliculas.php"); // Redirigir después de eliminar
    exit();
}

// Modificar una película
if (isset($_POST['modificar'])) {
    $id_pelicula = $_POST['id_pelicula'];
    $titulo = $_POST['titulo'];
    $portada = $_POST['portada']; // Asegúrate de manejar la carga de imágenes adecuadamente
    $sql = "UPDATE pelicula SET titulo = :titulo, portada = :portada WHERE id_pelicula = :id_pelicula";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':portada', $portada);
    $stmt->bindParam(':id_pelicula', $id_pelicula);
    $stmt->execute();
    header("Location: ../view/peliculas.php"); // Redirigir después de modificar
    exit();
}
?> 