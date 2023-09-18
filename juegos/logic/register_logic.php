<?php
session_start();
include 'db.php'; // Conexión a la base de datos

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Inicializar variables para el mensaje de error y el estado de registro
$registerError = "";

// Inicializa el contador de intentos fallidos si no existe
if (!isset($_SESSION['register_attempts'])) {
    $_SESSION['register_attempts'] = 0;
}

// Si hay más de 3 intentos fallidos, bloquea el registro durante 10 minutos
if ($_SESSION['register_attempts'] > 3 && (time() - $_SESSION['last_attempt_time']) < 600) {
    $registerError = "Has superado el número máximo de intentos. Por favor, espera 10 minutos antes de intentar de nuevo.";
} else {
    if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
        
        // Verificar el captcha
        $secretKey = "TU_CLAVE_SECRETA";
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
        $responseKeys = json_decode($response, true);

        if (intval($responseKeys["success"]) !== 1) {
            $registerError = "Por favor, verifica el captcha.";
        } else {
            // Procesar el formulario de registro
            $usernameInput = $_POST['username'];
            $passwordInput = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password
            $emailInput = $_POST['email'];

            // Verificar si el nombre de usuario o el correo electrónico ya están en uso
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
            $stmt->bind_param("ss", $usernameInput, $emailInput);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $registerError = "El nombre de usuario o correo electrónico ya están en uso.";
                // Incrementa el contador de intentos fallidos y registra el tiempo del último intento
                $_SESSION['register_attempts']++;
                $_SESSION['last_attempt_time'] = time();
            } else {
                $stmt->close();

                // Insertar el nuevo usuario en la base de datos
                $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $usernameInput, $passwordInput, $emailInput);

                if ($stmt->execute()) {
                    $_SESSION['message'] = "Usuario registrado con éxito!";
                    header('Location: login.php');
                    exit;
                } else {
                    $registerError = "Hubo un error al registrar el usuario.";
                }
            }

            $stmt->close();
            $conn->close();
        }
    } else {
        $registerError = "Por favor, verifica el captcha.";
    }
}
?>
