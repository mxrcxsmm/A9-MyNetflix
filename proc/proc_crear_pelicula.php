<?php
session_start();
include_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Verificar si el usuario es admin
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: ../view/login.php"); // Redirigir si no es admin
    exit();
}

// Agregar una nueva película
if (isset($_POST['agregar'])) {
    $titulo = $_POST['titulo'];
    $sinopsis = $_POST['sinopsis'];
    $ano_estreno = $_POST['ano_estreno'];
    $nacionalidad = $_POST['nacionalidad']; // Obtener la nacionalidad
    $duracion = $_POST['duracion']; // Obtener la duración
    $generos = $_POST['genero']; // Obtener los géneros seleccionados

    // Manejar la carga de la imagen
    $target_dir = "../img/"; // Directorio donde se guardarán las imágenes
    $target_file = $target_dir . basename($_FILES["portada"]["name"]); // Ruta del archivo
    $uploadOk = 1; // Variable para verificar si la carga fue exitosa
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Obtener la extensión del archivo

    // Verificar si el archivo es una imagen
    $check = getimagesize($_FILES["portada"]["tmp_name"]);
    if ($check === false) {
        echo "El archivo no es una imagen.";
        $uploadOk = 0;
    }

    // Verificar si el archivo ya existe
    if (file_exists($target_file)) {
        echo "Lo siento, el archivo ya existe.";
        $uploadOk = 0;
    }

    // Verificar el tamaño del archivo
    if ($_FILES["portada"]["size"] > 500000) { // Limitar el tamaño a 500KB
        echo "Lo siento, el archivo es demasiado grande.";
        $uploadOk = 0;
    }

    // Permitir ciertos formatos de archivo
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
        $uploadOk = 0;
    }

    // Verificar si $uploadOk es 0 por un error
    if ($uploadOk == 0) {
        echo "Lo siento, su archivo no fue subido.";
    } else {
        // Si todo está bien, intenta subir el archivo
        if (move_uploaded_file($_FILES["portada"]["tmp_name"], $target_file)) {
            // Insertar la nueva película
            $sql = "INSERT INTO pelicula (titulo, portada, sinopsis, ano_estreno, nacionalidad, duracion) VALUES (:titulo, :portada, :sinopsis, :ano_estreno, :nacionalidad, :duracion)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':portada', basename($_FILES["portada"]["name"])); // Guardar solo el nombre del archivo
            $stmt->bindParam(':sinopsis', $sinopsis);
            $stmt->bindParam(':ano_estreno', $ano_estreno);
            $stmt->bindParam(':nacionalidad', $nacionalidad); // Guardar la nacionalidad
            $stmt->bindParam(':duracion', $duracion); // Guardar la duración
            $stmt->execute();

            // Obtener el ID de la nueva película
            $id_pelicula = $pdo->lastInsertId();

            // Insertar los géneros seleccionados
            foreach ($generos as $id_genero) {
                $sql_insert = "INSERT INTO int_genero_pelicula (id_genero, id_pelicula) VALUES (:id_genero, :id_pelicula)";
                $stmt_insert = $pdo->prepare($sql_insert);
                $stmt_insert->bindParam(':id_genero', $id_genero);
                $stmt_insert->bindParam(':id_pelicula', $id_pelicula);
                $stmt_insert->execute();
            }

            header("Location: ../view/peliculas.php"); // Redirigir después de agregar
            exit();
        } else {
            echo "Lo siento, hubo un error al subir su archivo.";
        }
    }
}
?> 