<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    
    <!-- Enlace a la hoja de estilos de Bootstrap y estilos personalizados -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- Script para la integración del reCAPTCHA de Google -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <div class="content-wrapper">
        <div class="container mt-5">
            <h1 class="mb-4 text-center">Iniciar Sesión</h1>

            <!-- Mensaje de error en caso de fallo de inicio de sesión -->
            <?php if (isset($loginError) && !empty($loginError)): ?>
                <div class="alert alert-danger">
                    <?php echo $loginError; ?>
                    <!-- Contador de tiempo restante en caso de múltiples intentos fallidos de inicio de sesión -->
                    <?php if (isset($timeRemaining) && $timeRemaining > 0): ?>
                        <div id="countdown">Tiempo restante: <span id="minutes"></span>:<span id="seconds"></span></div>
                        <script>
                            // Script para actualizar el contador de tiempo restante
                            var timeRemaining = <?php echo $timeRemaining; ?>;
                            var minutesElem = document.getElementById('minutes');
                            var secondsElem = document.getElementById('seconds');

                            function updateCountdown() {
                                var minutes = Math.floor(timeRemaining / 60);
                                var seconds = timeRemaining % 60;
                                minutesElem.textContent = String(minutes).padStart(2, '0');
                                secondsElem.textContent = String(seconds).padStart(2, '0');
                                timeRemaining--;

                                if (timeRemaining < 0) {
                                    clearInterval(interval);
                                    document.getElementById('countdown').textContent = "Puedes intentar iniciar sesión nuevamente.";
                                }
                            }

                            var interval = setInterval(updateCountdown, 1000);
                            updateCountdown(); // Llamar a la función una vez al inicio para mostrar el tiempo inicial
                        </script>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Formulario de inicio de sesión -->
            <form action="login.php" method="post" class="w-50 mx-auto">
                <div class="form-group">
                    <label for="username">Nombre de usuario:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <!-- Integración del reCAPTCHA de Google para la verificación de bots -->
                <div class="g-recaptcha" data-sitekey="6LdBODMoAAAAACmTpPR5s01aewC-6qdq0AK_bVgW"></div>

                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                <a href="index.php" class="btn btn-secondary ml-2">Página Principal</a>
            </form>

            <!-- Enlace para usuarios que no tienen cuenta y desean registrarse -->
            <p class="text-center mt-3">¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
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
