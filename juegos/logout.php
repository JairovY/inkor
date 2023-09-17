<?php
session_start();

// Verificar si una sesión está activa
if (isset($_SESSION['loggedin'])) {
    // Eliminar todas las variables de sesión
    session_unset();
    // Destruir la sesión
    session_destroy();
    // Regenerar el ID de sesión para evitar problemas de fijación de sesión
    session_regenerate_id(true);
}

// Redirigir al usuario a la página de inicio
header('Location: index.php');
exit;
?>