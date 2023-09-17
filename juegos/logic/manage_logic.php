<?php
session_start();
include 'db.php'; // Conexión a la base de datos

// Comprobar si el usuario ha iniciado sesión
if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}


$game = [
    'id' => '',
    'title' => '',
    'description' => '',
    'image' => ''
];

// Si hay un ID de juego en la URL, obtenemos los datos del juego
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM games WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $game = $result->fetch_assoc();
    $stmt->close();
}
?>
