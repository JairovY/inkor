<?php
session_start();
include 'db.php'; // Conexión a la base de datos

$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$message = null;

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

$searchValue = '';
if (isset($_GET['search'])) {
    $searchValue = $_GET['search'];
}

// Consulta SQL con paginación
$limit = 6; // Número de juegos por página
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

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

// Paginación
$result = $conn->query("SELECT COUNT(*) AS count FROM games");
$total = $result->fetch_assoc()['count'];
$pages = ceil($total / $limit);

$stmt->close();
$conn->close();
?>