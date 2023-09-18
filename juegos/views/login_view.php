<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="content-wrapper">
        <div class="container mt-5">
            <h1 class="mb-4 text-center">Iniciar Sesión</h1>

            <!-- Mensaje de error en caso de fallo de inicio de sesión -->
            <?php if (isset($loginError) && !empty($loginError)): ?>
                <div class="alert alert-danger">
                    <?php echo $loginError; ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="post" class="w-50 mx-auto">
                <div class="form-group">
                    <label for="username">Nombre de usuario:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            </form>

            <p class="text-center mt-3">¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>

        </div>

        <!-- Scripts de Bootstrap -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </div>
    <?php include 'views/footer_view.php'; ?>
</body>

</html>
