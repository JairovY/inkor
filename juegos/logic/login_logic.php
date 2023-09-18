<?php
session_start();

include 'db.php';

// Establece una nueva conexión a la base de datos.
$conn = new mysqli($server, $username, $password, $database);

// Verifica si hay algún error en la conexión a la base de datos.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/**
 * Registra un intento fallido de inicio de sesión en la base de datos.
 *
 * @param string $username Nombre de usuario que intentó iniciar sesión.
 * @param mysqli $conn Conexión a la base de datos.
 */
function recordFailedLogin($username, $conn) {
    // Obtener la dirección IP del usuario.
    $ip_address = $_SERVER['REMOTE_ADDR'];
    // Insertar el intento fallido en la base de datos.
    $stmt = $conn->prepare("INSERT INTO failed_logins (username, IP_address) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $ip_address);
    $stmt->execute();
    $stmt->close();
}

/**
 * Verifica la respuesta del captcha proporcionada por el usuario.
 *
 * @param string $recaptchaResponse Respuesta del captcha proporcionada por el usuario.
 * @return bool Retorna true si la verificación del captcha es exitosa, de lo contrario retorna false.
 */
function verifyCaptcha($recaptchaResponse) {
    // Clave secreta para la verificación del captcha.
    $secretKey = "6LdBODMoAAAAAHfOJs0tuSd5IEbptJL-0Z92Apfn";
    // Realizar la verificación con el servicio de Google.
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $recaptchaResponse);
    $responseData = json_decode($verifyResponse);
    return $responseData->success;
}

// Inicializar variables para el mensaje de error y el estado de inicio de sesión.
$loginError = "";
$isLoggedIn = false;

// Establecer un límite de intentos de inicio de sesión.
$maxAttempts = 3;

// Verificar si el usuario ha excedido el número máximo de intentos.
if (isset($_SESSION['loginAttempts']) && $_SESSION['loginAttempts'] >= $maxAttempts) {
    $timePassed = time() - $_SESSION['firstAttempt'];
    $timeRemaining = 600 - $timePassed; // 600 segundos son 10 minutos.

    if ($timeRemaining > 0) {
        $loginError = "Has excedido el número máximo de intentos. Por favor, espera para intentar nuevamente.";
    } else {
        // Si han pasado 10 minutos desde el primer intento fallido, reiniciar el contador.
        unset($_SESSION['loginAttempts']);
        unset($_SESSION['firstAttempt']);
    }
}

// Procesar el formulario de inicio de sesión.
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($timeRemaining)) {
    $usernameInput = $_POST['username'];
    $passwordInput = $_POST['password'];
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    if (!verifyCaptcha($recaptchaResponse)) {
        $loginError = "Verificación de captcha fallida. Por favor, inténtalo de nuevo.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $usernameInput);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($user = $result->fetch_assoc()) {
            // Verificar la contraseña.
            if (password_verify($passwordInput, $user['password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $isLoggedIn = true;
                header("Location: index.php");
                exit;
            } else {
                $loginError = "Contraseña incorrecta";
                recordFailedLogin($usernameInput, $conn);
                // Incrementar el contador de intentos fallidos.
                if (!isset($_SESSION['loginAttempts'])) {
                    $_SESSION['loginAttempts'] = 0;
                    $_SESSION['firstAttempt'] = time();
                }
                $_SESSION['loginAttempts']++;
            }
        } else {
            $loginError = "Usuario no encontrado";
            recordFailedLogin($usernameInput, $conn);
            // Incrementar el contador de intentos fallidos.
            if (!isset($_SESSION['loginAttempts'])) {
                $_SESSION['loginAttempts'] = 0;
                $_SESSION['firstAttempt'] = time();
            }
            $_SESSION['loginAttempts']++;
        }

        $stmt->close();
    }
}

// Cerrar la conexión a la base de datos.
$conn->close();
?>




