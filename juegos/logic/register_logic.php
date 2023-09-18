<?php
session_start();
include 'db.php'; // Conexión a la base de datos

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameInput = $_POST['username'];
    $passwordInput = $_POST['password'];
    $emailInput = $_POST['email'];

    // Validaciones
    $errors = [];

    // Validar nombre de usuario
    if (strlen($usernameInput) < 5 || strlen($usernameInput) > 20 || !preg_match("/^[a-zA-Z0-9]*$/", $usernameInput)) {
        $errors[] = "El nombre de usuario debe tener entre 5 y 20 caracteres y solo puede contener letras y números.";
    }

    // Validar contraseña
    if (strlen($passwordInput) < 8 || !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $passwordInput)) {
        $errors[] = "La contraseña debe tener al menos 8 caracteres y contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.";
    }

    // Validar correo electrónico
    if (!filter_var($emailInput, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Introduce un correo electrónico válido.";
    }

    // Si no hay errores, procesar el registro
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $usernameInput, $emailInput);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($user = $result->fetch_assoc()) {
            if ($user['username'] === $usernameInput) {
                $errors[] = "El nombre de usuario ya está en uso.";
            } else {
                $errors[] = "El correo electrónico ya está en uso.";
            }
        } else {
            $hashedPassword = password_hash($passwordInput, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $usernameInput, $hashedPassword, $emailInput);
            $stmt->execute();
            header("Location: login.php");
            exit;
        }
        $stmt->close();
    } else {
        // Aquí puedes manejar los errores, por ejemplo, mostrarlos en la página de registro
    }
}

$conn->close();
?>
