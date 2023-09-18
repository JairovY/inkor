<?php
session_start();
include 'db.php'; // Conexión a la base de datos

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar el formulario de registro
    $usernameInput = $_POST['username'];
    $passwordInput = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password
    $emailInput = $_POST['email'];

    // Verificar si el nombre de usuario o el correo electrónico ya están en uso
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $usernameInput, $emailInput);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        $stmt->close();

        // Insertar el nuevo usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $usernameInput, $passwordInput, $emailInput);
        $stmt->execute();
        header('Location: login.php');
        exit;
    }

    $stmt->close();
}
$conn->close();
?>
