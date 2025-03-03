<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Imagen</title>
</head>
<body>
    <input type="file" id="imagenInput" accept="image/*">
    <br><br>
    <div style="max-width: 500px;">
        <img id="imagenPreview" style="max-width: 100%;">
    </div>
    <br>
    <button id="subirBtn">Subir</button>
    <br><br>
    <form id="uploadForm" action="subir.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="imagenArchivo" id="imagenArchivo" style="display: none;">
    </form>

    <script>
        document.getElementById('imagenInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imagenPreview = document.getElementById('imagenPreview');
                    imagenPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
                document.getElementById('imagenArchivo').files = event.target.files;
            }
        });

        document.getElementById('subirBtn').addEventListener('click', function() {
            const imagenPreview = document.getElementById('imagenPreview');
            if (imagenPreview.src) {
                document.getElementById('uploadForm').submit();
            }
        });
    </script>
<a href="./index.php">Volver</a>
</body>
</html>
