<?php
session_start();
include_once '../conexion.php';

// Verificar si se recibieron datos
$data = json_decode(file_get_contents("php://input"), true);

$peliculaId = $data['peliculaId'];
$usuarioId = $data['usuarioId'];

// Comprobar si el like ya existe
$sql_check = "SELECT * FROM likes_pelicula WHERE id_pelicula = :peliculaId AND id_usuario = :usuarioId";
$stmt_check = $pdo->prepare($sql_check);
$stmt_check->execute(['peliculaId' => $peliculaId, 'usuarioId' => $usuarioId]);
$like = $stmt_check->fetch();

if ($like) {
    // Si existe, eliminar el like
    $sql_delete = "DELETE FROM likes_pelicula WHERE id_pelicula = :peliculaId AND id_usuario = :usuarioId";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->execute(['peliculaId' => $peliculaId, 'usuarioId' => $usuarioId]);
} else {
    // Si no existe, agregar el like
    $sql_insert = "INSERT INTO likes_pelicula (id_pelicula, id_usuario) VALUES (:peliculaId, :usuarioId)";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->execute(['peliculaId' => $peliculaId, 'usuarioId' => $usuarioId]);
}

// Obtener el nuevo total de likes
$sql_total_likes = "SELECT COUNT(*) as total_likes FROM likes_pelicula WHERE id_pelicula = :peliculaId";
$stmt_total_likes = $pdo->prepare($sql_total_likes);
$stmt_total_likes->execute(['peliculaId' => $peliculaId]);
$total_likes = $stmt_total_likes->fetchColumn();

echo json_encode(['total_likes' => $total_likes]);
?>
