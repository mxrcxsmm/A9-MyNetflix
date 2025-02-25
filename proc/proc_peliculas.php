<?php
session_start();
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Verificar si el usuario es admin
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: ../view/login.php"); // Redirigir si no es admin
    exit();
}

// Verificar si se ha pasado el ID de la película
if (isset($_GET['id_pelicula'])) {
    $id_pelicula = $_GET['id_pelicula'];

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
    $titulo = $_POST['titulo'] ?? '';
    $actor = $_POST['actor'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $ano_estreno = $_POST['ano_estreno'] ?? '';

    $sql = "SELECT p.id_pelicula, p.titulo, p.portada, p.sinopsis, p.ano_estreno, p.nacionalidad,
                (SELECT GROUP_CONCAT(g.nombre_genero) FROM int_genero_pelicula igp 
                 JOIN genero g ON igp.id_genero = g.id_genero 
                 WHERE igp.id_pelicula = p.id_pelicula) AS generos,
                (SELECT COUNT(*) FROM likes_pelicula l WHERE l.id_pelicula = p.id_pelicula) AS total_likes
            FROM pelicula p
            LEFT JOIN int_genero_pelicula igp ON p.id_pelicula = igp.id_pelicula
            LEFT JOIN genero g ON igp.id_genero = g.id_genero
            LEFT JOIN int_personal_pelicula ipp ON p.id_pelicula = ipp.id_pelicula
            LEFT JOIN personal per ON ipp.id_personal = per.id_personal
            WHERE 1=1"; // 1=1 para facilitar la adición de condiciones

    // Agregar condiciones de búsqueda
    if (!empty($titulo)) {
        $sql .= " AND p.titulo LIKE :titulo";
    }
    if (!empty($actor)) {
        $sql .= " AND (per.nombre_personal LIKE :actor OR per.apellidos_personal LIKE :actor)";
    }
    if (!empty($genero)) {
        $sql .= " AND g.nombre_genero = :genero";
    }
    if (!empty($ano_estreno)) {
        $sql .= " AND p.ano_estreno = :ano_estreno";
    }

    $sql .= " ORDER BY p.titulo"; // Cambia a ORDER BY total_likes si deseas ordenar por likes

    $stmt = $pdo->prepare($sql);

    // Vincular parámetros
    if (!empty($titulo)) {
        $stmt->bindValue(':titulo', '%' . $titulo . '%');
    }
    if (!empty($actor)) {
        $stmt->bindValue(':actor', '%' . $actor . '%');
    }
    if (!empty($genero)) {
        $stmt->bindValue(':genero', $genero);
    }
    if (!empty($anio)) {
        $stmt->bindValue(':ano_estreno', $ano_estreno);
    }

    $stmt->execute();
    $peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Obtener todas las películas
    $sql = "SELECT p.id_pelicula, p.titulo, p.portada, p.sinopsis, p.ano_estreno, p.nacionalidad,
                (SELECT GROUP_CONCAT(g.nombre_genero) FROM int_genero_pelicula igp 
                 JOIN genero g ON igp.id_genero = g.id_genero 
                 WHERE igp.id_pelicula = p.id_pelicula) AS generos,
                (SELECT COUNT(*) FROM likes_pelicula l WHERE l.id_pelicula = p.id_pelicula) AS total_likes
            FROM pelicula p
            ORDER BY p.titulo"; // Cambia a ORDER BY total_likes si deseas ordenar por likes
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Editar una película
if (isset($_POST['modificar'])) {
    $id_pelicula = $_POST['id_pelicula'];

    // Aquí puedes llamar a la función o incluir el archivo que maneja la edición
    include '../proc/proc_editar_pelicula.php'; // Asegúrate de que la ruta sea correcta
}

// Eliminar una película
if (isset($_POST['eliminar'])) {
    $id_pelicula = $_POST['id_pelicula'];

    // Aquí puedes llamar a la función o incluir el archivo que maneja la eliminación
    include '../proc/proc_eliminar_pelicula.php'; // Asegúrate de que la ruta sea correcta
}
?> 