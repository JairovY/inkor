<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Juego</title>
    
    <!-- Enlace a la hoja de estilos de Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <script>
        // Validación del formulario en el lado del cliente
        function validateForm() {
            var imageUrl = document.forms["gameForm"]["image"].value;
            var pattern = /^(http|https):/;
            if (!pattern.test(imageUrl)) {
                alert("URL de imagen no válida");
                return false;
            }
            // Aquí puedes agregar más validaciones si es necesario
        }
    </script>
</head>

<body>
    <div class="content-wrapper">
        <div class="container mt-5">
            <h1 class="mb-4 text-center">Administrar Juego</h1>

            <!-- Formulario para agregar o actualizar un juego -->
            <form action="actions.php" method="post" name="gameForm" onsubmit="return validateForm()">
                <input type="hidden" name="id" value="<?php echo $game['id']; ?>">

                <div class="form-group">
                    <label for="title">Título:</label>
                    <input type="text" class="form-control" id="title" name="title"
                        value="<?php echo $game['title']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Descripción:</label>
                    <textarea class="form-control" id="description" name="description"
                        required><?php echo $game['description']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="image">URL de la imagen:</label>
                    <input type="text" class="form-control" id="image" name="image"
                        value="<?php echo $game['image']; ?>">
                </div>

                <button type="submit" class="btn btn-primary">
                    <?php echo $game['id'] ? 'Actualizar' : 'Insertar'; ?> Juego
                </button>
            </form>

            <!-- Opción para eliminar un juego (visible solo si se está editando un juego existente) -->
            <?php if ($game['id']): ?>
                <form action="actions.php" method="post" class="mt-3">
                    <input type="hidden" name="delete_id" value="<?php echo $game['id']; ?>">
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('¿Estás seguro de que deseas eliminar este juego?')">Eliminar Juego</button>
                </form>
            <?php endif; ?>

            <!-- Enlace para regresar a la lista principal de juegos -->
            <a href="index.php" class="btn btn-secondary mt-4">Regresar a la lista de juegos</a>
        </div>

        <!-- Scripts necesarios para Bootstrap -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </div>
    
    <!-- Inclusión del pie de página -->
    <?php include 'views/footer_view.php'; ?>
</body>

</html>
