<?php
session_start();
include 'db.php'; // Conexión a la base de datos

// Inicializar variables para el mensaje de error y el estado de inicio de sesión
$loginError = "";
$isLoggedIn = false;

// Inicializa el contador de intentos fallidos si no existe
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

// Si hay más de 3 intentos fallidos, bloquea el inicio de sesión durante 10 minutos
if ($_SESSION['login_attempts'] > 3 && (time() - $_SESSION['last_attempt_time']) < 600) {
    $loginError = "Has superado el número máximo de intentos. Por favor, espera 10 minutos antes de intentar de nuevo.";
} else {
    if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
        
        // Verificar el captcha
        $secretKey = "6LdBODMoAAAAAHfOJs0tuSd5IEbptJL-0Z92Apfn";
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
        $responseKeys = json_decode($response, true);

        if (intval($responseKeys["success"]) !== 1) {
            $loginError = "Por favor, verifica el captcha.";
        } else {
            // Procesar el formulario de inicio de sesión
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $usernameInput = $_POST['username'];
                $passwordInput = $_POST['password'];

                $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->bind_param("s", $usernameInput);
                $stmt->execute();

                $result = $stmt->get_result();
                if ($user = $result->fetch_assoc()) {
                    // Verificar la contraseña
                    if (password_verify($passwordInput, $user['password'])) {
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['role'] = $user['role'];
                        $isLoggedIn = true;
                        header("Location: index.php");
                        exit;
                    } else {
                        $loginError = "Contraseña incorrecta";
                        // Incrementa el contador de intentos fallidos y registra el tiempo del último intento
                        $_SESSION['login_attempts']++;
                        $_SESSION['last_attempt_time'] = time();
                    }
                } else {
                    $loginError = "Usuario no encontrado";
                    // Incrementa el contador de intentos fallidos y registra el tiempo del último intento
                    $_SESSION['login_attempts']++;
                    $_SESSION['last_attempt_time'] = time();
                }

                $stmt->close();
                $conn->close();
            }
        }
    } else {
        $loginError = "Por favor, verifica el captcha.";
    }
}
?>
