<!DOCTYPE html>
<html lang="en">

<?php
// Inclusión del archivo que contiene la configuración y conexión a la base de datos.
include 'db.php';
?>

<head>
    <!-- Metadatos básicos para la correcta visualización y codificación del sitio. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Título de la página. -->
    <title>Detalles del Juego</title>

    <!-- Enlace a la hoja de estilos de Bootstrap y estilos personalizados. -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">

    <!-- Enlace a la hoja de estilos de Font Awesome para íconos. -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="content-wrapper">
        <div class="container mt-5">
            <!-- Título principal de la página. -->
            <h1 class="mb-4 text-center">Detalles del Juego</h1>

            <?php
            // Verifica si se ha proporcionado un ID de juego en la URL.
            if (isset($_GET['id'])) {
                $gameId = $_GET['id'];

                /**
                 * Prepara y ejecuta una consulta SQL para obtener los detalles del juego usando el ID proporcionado.
                 * Si el juego se encuentra, sus detalles se almacenan en la variable $game.
                 */
                $stmt = $conn->prepare("SELECT * FROM games WHERE id = ?");
                $stmt->bind_param("i", $gameId);
                $stmt->execute();

                $result = $stmt->get_result();
                if ($game = $result->fetch_assoc()) {
                    // Los detalles del juego están ahora en la variable $game.
                } else {
                    echo "Juego no encontrado.";
                }

                $stmt->close();
            }
            ?>

            <div class="row">
                <div class="col-md-6">
                    <!-- Muestra la imagen del juego obtenida de la base de datos. -->
                    <img src="<?php echo $game['image']; ?>" class="img-fluid" alt="<?php echo $game['title']; ?>">
                </div>
                <div class="col-md-6">
                    <!-- Muestra el título y la descripción del juego obtenidos de la base de datos. -->
                    <h2><?php echo $game['title']; ?></h2>
                    <p><?php echo $game['description']; ?></p>
                    <!-- Aquí puedes agregar más detalles del juego como género, fecha de lanzamiento, etc. -->
                </div>
            </div>

            <div class="mt-4">
                <!-- Botón que redirige al usuario a la lista principal de juegos. -->
                <a href="index.php" class="btn btn-secondary">Volver a la lista de juegos</a>
            </div>
        </div>

        <!-- Scripts necesarios para el correcto funcionamiento de Bootstrap. -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </div>

    <!-- Inclusión del pie de página del sitio. -->
    <?php include 'views/footer_view.php'; ?>
</body>

</html>
