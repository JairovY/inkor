<?php
// Inicio de la sesión para poder utilizar y almacenar variables de sesión.
session_start();

// Inclusión del archivo que contiene la configuración y conexión a la base de datos.
include 'db.php';

// Verifica si el usuario ha iniciado sesión.
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

// Inicializa el mensaje de la sesión a null.
$message = null;

// Verifica si hay un mensaje en la sesión y lo almacena en la variable $message.
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Inicializa el valor de búsqueda a una cadena vacía.
$searchValue = '';
if (isset($_GET['search'])) {
    $searchValue = $_GET['search'];
}

// Verifica si hay un valor de búsqueda y prepara el mensaje.
$showBackButton = false;
if ($searchValue != '') {
    $showBackButton = true;
}

// Configuración de la paginación.
$limit = 6; // Número de juegos por página.
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Preparación y ejecución de la consulta SQL para obtener la lista de juegos con paginación.
if ($searchValue) {
    $stmt = $conn->prepare("SELECT * FROM games WHERE title LIKE ? ORDER BY title LIMIT ? OFFSET ?");
    $search_term = "%" . $searchValue . "%";
    $stmt->bind_param("sii", $search_term, $limit, $offset);
} else {
    $stmt = $conn->prepare("SELECT * FROM games ORDER BY title LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $limit, $offset);
}

$stmt->execute();
$gamesResult = $stmt->get_result();

// Configuración adicional para la paginación.
$result = $conn->query("SELECT COUNT(*) AS count FROM games");
$total = $result->fetch_assoc()['count'];
$pages = ceil($total / $limit);

// Cierre de la declaración y la conexión a la base de datos.
$stmt->close();
$conn->close();
?>
