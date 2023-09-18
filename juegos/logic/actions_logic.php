<?php
session_start();

include 'db.php';

// Insertar un juego en la base de datos.
if (isset($_POST['title']) && empty($_POST['id'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image_url = $_POST['image'];

    // Validación en el lado del servidor para la URL de la imagen.
    if (!filter_var($image_url, FILTER_VALIDATE_URL)) {
        $_SESSION['message'] = "URL de imagen no válida.";
        header('Location: manage.php');
        exit;
    }

    // Preparación y ejecución de la consulta SQL para insertar un nuevo juego.
    $stmt = $conn->prepare("INSERT INTO games (title, description, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $image_url);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Juego agregado con éxito!";
    } else {
        $_SESSION['message'] = "Hubo un error al agregar el juego.";
    }
    $stmt->close();
}

// Actualizar un juego existente en la base de datos.
if (isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['title'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image_url = $_POST['image'];

    // Validación en el lado del servidor para la URL de la imagen.
    if (!filter_var($image_url, FILTER_VALIDATE_URL)) {
        $_SESSION['message'] = "URL de imagen no válida.";
        header('Location: manage.php?id=' . $id);
        exit;
    }

    // Preparación y ejecución de la consulta SQL para actualizar un juego existente.
    $stmt = $conn->prepare("UPDATE games SET title = ?, description = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $description, $image_url, $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Juego actualizado con éxito!";
    } else {
        $_SESSION['message'] = "Hubo un error al actualizar el juego.";
    }
    $stmt->close();
}

// Eliminar un juego de la base de datos.
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    // Preparación y ejecución de la consulta SQL para eliminar un juego.
    $stmt = $conn->prepare("DELETE FROM games WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Juego eliminado con éxito!";
    } else {
        $_SESSION['message'] = "Hubo un error al eliminar el juego.";
    }
    $stmt->close();
}

// Redirige al usuario a la página principal después de realizar una acción.
header('Location: index.php');
?>
