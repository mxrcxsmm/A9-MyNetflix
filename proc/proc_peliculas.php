<?php
session_start();
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Verificar si el usuario es admin
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: ../view/login.php"); // Redirigir si no es admin
    exit();
}

// Inicializar la consulta
$sql = "SELECT p.id_pelicula, 
               p.titulo, 
               p.portada, 
               p.sinopsis, 
               p.ano_estreno, 
               p.nacionalidad,
               GROUP_CONCAT(DISTINCT g.nombre_genero) AS generos,
               GROUP_CONCAT(DISTINCT per.nombre_personal) AS actores,
               COUNT(l.id_pelicula) AS total_likes
        FROM pelicula p
        LEFT JOIN int_genero_pelicula igp ON p.id_pelicula = igp.id_pelicula
        LEFT JOIN genero g ON igp.id_genero = g.id_genero
        LEFT JOIN int_personal_pelicula ip ON p.id_pelicula = ip.id_pelicula
        LEFT JOIN personal per ON ip.id_personal = per.id_personal
        LEFT JOIN likes_pelicula l ON p.id_pelicula = l.id_pelicula";

// Inicializar condiciones de filtro
$conditions = [];
$params = [];

// Verificar si hay filtros
if (!empty($_POST['titulo'])) {
    $conditions[] = "p.titulo LIKE :titulo";
    $params[':titulo'] = '%' . $_POST['titulo'] . '%';
}

if (!empty($_POST['actor'])) {
    $conditions[] = "per.nombre_personal LIKE :actor"; // Filtrar por nombre de actor
    $params[':actor'] = '%' . $_POST['actor'] . '%';
}

if (!empty($_POST['genero'])) {
    $conditions[] = "g.nombre_genero LIKE :genero"; // Filtrar por nombre de género
    $params[':genero'] = '%' . $_POST['genero'] . '%';
}

if (!empty($_POST['ano_estreno'])) {
    $conditions[] = "p.ano_estreno = :ano_estreno";
    $params[':ano_estreno'] = $_POST['ano_estreno'];
}

// Si hay condiciones, añadirlas a la consulta
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

// Agrupar y ordenar
$sql .= " GROUP BY p.id_pelicula ORDER BY p.titulo";

// Preparar y ejecutar la consulta
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
