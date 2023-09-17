<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juegos</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Base de datos de VideoJuegos</h1>

        <!-- Inicio de sesión y Registro -->
        <?php if ($isLoggedIn): ?>
            <p>Bienvenido, gracias por volver por aqui! ¿que juego buscaras hoy?
                <?php echo $_SESSION['username']; ?>! <a href="logout.php">Cerrar sesión</a>
            </p>
        <?php else: ?>
            <p><a href="login.php">Iniciar sesión</a> | <a href="register.php">Registrarse</a></p>
        <?php endif; ?>

        <!-- Mensaje de Feedback -->
        <?php if ($message): ?>
            <div class="alert alert-success">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="index.php" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar juego..."
                    value="<?php echo $searchValue; ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>
            </div>
        </form>

        <!-- Botón para volver (si se realizó una búsqueda) -->
        <?php if ($showBackButton): ?>
            <div class="text-center mb-4">
                <a href="index.php" class="btn btn-secondary">Volver</a>
            </div>
        <?php endif; ?>

            <!-- Mostrar juegos en tarjetas de Bootstrap -->
            <div class="row">
                <?php while ($game = $gamesResult->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?php echo $game['image']; ?>" class="card-img-top" alt="<?php echo $game['title']; ?>">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo $game['title']; ?>
                                </h5>
                                <p class="card-text">
                                    <?php echo $game['description']; ?>
                                </p>
                                <?php if ($isLoggedIn): ?>
                                    <a href="manage.php?id=<?php echo $game['id']; ?>" class="btn btn-primary">Editar</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Enlaces de paginación -->
            <div class="mt-4">
                <?php
                for ($i = 1; $i <= $pages; $i++) {
                    echo "<a href='index.php?page=$i' class='btn btn-secondary'>$i</a> ";
                }
                ?>
            </div>

            <?php if ($isLoggedIn): ?>
                <a href="manage.php" class="btn btn-success mt-4">Agregar nuevo juego</a>
            <?php endif; ?>

        </div>

        <!-- Scripts de Bootstrap -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>
    <footer class="mt-5 py-3 text-center">
        <p>&copy;
            <?php echo date("Y"); ?> JairovY. Todos los derechos reservados.
        </p>
    </footer>

</html>


