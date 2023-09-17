<?php
session_start();
include 'db.php'; // Conexión a la base de datos

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Inicializar variables para el mensaje de error y el estado de registro
$registerError = "";

// Procesar el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
?>

