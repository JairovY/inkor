<?php
session_start();

include 'db.php';

// Comprobar si el usuario ha iniciado sesión.
// Si el usuario no ha iniciado sesión, se le redirige a la página de inicio de sesión.
if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}

// Inicialización del arreglo que contendrá la información del juego.
$game = [
    'id' => '',
    'title' => '',
    'description' => '',
    'image' => ''
];

// Si hay un ID de juego en la URL, obtenemos los datos del juego.
// Este bloque de código se ejecuta cuando se quiere editar un juego existente.
if (isset($_GET['id'])) {
    // Preparación de la consulta SQL para obtener los detalles del juego basado en el ID proporcionado.
    $stmt = $conn->prepare("SELECT * FROM games WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();

    // Obtener el resultado de la consulta y almacenar los detalles del juego en el arreglo $game.
    $result = $stmt->get_result();
    $game = $result->fetch_assoc();

    // Cerrar la declaración preparada.
    $stmt->close();
}
?>
