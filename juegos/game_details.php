<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Juego</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Detalles del Juego</h1>

        <!-- Aquí puedes hacer la consulta a la base de datos para obtener los detalles del juego usando el ID -->

        

        <div class="row">
            <div class="col-md-6">
                <!-- Imagen del juego -->
                <img src="<?php echo $game['image']; ?>" class="img-fluid" alt="<?php echo $game['title']; ?>">
            </div>
            <div class="col-md-6">
                <!-- Detalles del juego -->
                <h2><?php echo $game['title']; ?></h2>
                <p><?php echo $game['description']; ?></p>
                <!-- Aquí puedes agregar más detalles del juego como género, fecha de lanzamiento, etc. -->
            </div>
        </div>

        <div class="mt-4">
            <a href="index.php" class="btn btn-secondary">Volver a la lista de juegos</a>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
<footer class="mt-5 py-3 text-center">
    <p>&copy; <?php echo date("Y"); ?> JairovY. Todos los derechos reservados.</p>
</footer>

</html>
