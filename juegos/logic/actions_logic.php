<?php
session_start();
include 'db.php'; // Conexión a la base de datos

// Insertar un juego
if (isset($_POST['title']) && empty($_POST['id'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image_url = $_POST['image'];

    // Validación en el lado del servidor para la URL de la imagen
    if (!filter_var($image_url, FILTER_VALIDATE_URL)) {
        $_SESSION['message'] = "URL de imagen no válida.";
        header('Location: manage.php');
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO games (title, description, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $image_url);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Juego agregado con éxito!";
    } else {
        $_SESSION['message'] = "Hubo un error al agregar el juego.";
    }
    $stmt->close();
}

// Actualizar un juego
if (isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['title'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image_url = $_POST['image'];

    // Validación en el lado del servidor para la URL de la imagen
    if (!filter_var($image_url, FILTER_VALIDATE_URL)) {
        $_SESSION['message'] = "URL de imagen no válida.";
        header('Location: manage.php?id=' . $id);
        exit;
    }

    $stmt = $conn->prepare("UPDATE games SET title = ?, description = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $description, $image_url, $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Juego actualizado con éxito!";
    } else {
        $_SESSION['message'] = "Hubo un error al actualizar el juego.";
    }
    $stmt->close();
}

// Eliminar un juego
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    $stmt = $conn->prepare("DELETE FROM games WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Juego eliminado con éxito!";
    } else {
        $_SESSION['message'] = "Hubo un error al eliminar el juego.";
    }
    $stmt->close();
}

header('Location: index.php'); // Redirigir al usuario a la página principal después de realizar una acción
?>
