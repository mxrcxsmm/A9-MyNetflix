<?php

// Obtener el TOP 5 de películas más populares
$sql_top5 = "SELECT p.id_pelicula, p.titulo, p.portada, 
                (SELECT COUNT(*) FROM likes_pelicula l WHERE l.id_pelicula = p.id_pelicula) AS total_likes
             FROM pelicula p
             ORDER BY total_likes DESC
             LIMIT 5";
$stmt_top5 = $pdo->prepare($sql_top5);
$stmt_top5->execute();
$top5 = $stmt_top5->fetchAll(PDO::FETCH_ASSOC);

// Obtener todas las películas ordenadas por popularidad
$sql_peliculas = "SELECT p.id_pelicula, p.titulo, p.portada, 
                    (SELECT COUNT(*) FROM likes_pelicula l WHERE l.id_pelicula = p.id_pelicula) AS total_likes,
                    (SELECT COUNT(*) FROM likes_pelicula l WHERE l.id_pelicula = p.id_pelicula AND l.id_usuario = :usuarioId) AS user_liked
                  FROM pelicula p
                  ORDER BY total_likes DESC";
$stmt_peliculas = $pdo->prepare($sql_peliculas);
$stmt_peliculas->bindParam(':usuarioId', $_SESSION['id_usuario']);
$stmt_peliculas->execute();
$peliculas = $stmt_peliculas->fetchAll(PDO::FETCH_ASSOC);

?>