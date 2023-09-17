<?php
session_start();
include 'db.php'; // Conexión a la base de datos

// Inicializar variables para el mensaje de error y el estado de inicio de sesión
$loginError = "";
$isLoggedIn = false;

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
        }
    } else {
        $loginError = "Usuario no encontrado";
    }

    $stmt->close();
    $conn->close();
}
?>
