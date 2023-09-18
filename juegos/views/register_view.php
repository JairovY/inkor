<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>
    <div class="content-wrapper">
        <div class="container mt-5">
            <h1 class="mb-4 text-center">Registrarse</h1>

            <!-- Mostrar errores de validación -->
            <?php if (isset($errors) && !empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="register.php" method="post" class="w-50 mx-auto">
                <div class="form-group">
                    <label for="username">Nombre de usuario:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="g-recaptcha" data-sitekey="6LdBODMoAAAAACmTpPR5s01aewC-6qdq0AK_bVgW"></div>

                <button type="submit" class="btn btn-primary">Registrarse</button>
                <a href="index.php" class="btn btn-secondary ml-2">Página Principal</a>
            </form>

            <p class="text-center mt-3">¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>

        </div>

        <!-- Scripts de Bootstrap -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </div>
    <?php include 'views/footer_view.php'; ?>
</body>

</html>
