<?php

// Configuración de la conexión a la base de datos.
$server = "localhost";
$username = "root";
$password = "";
$database = "gameDB";

/**
 * Establece una nueva conexión a la base de datos utilizando las credenciales proporcionadas.
 */
$conn = new mysqli($server, $username, $password, $database);

/**
 * Verifica si el usuario ha iniciado sesión.
 *
 * @return bool Retorna true si el usuario ha iniciado sesión, de lo contrario retorna false.
 */
function isUserLoggedIn()
{
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}

// Verifica si hay algún error en la conexión a la base de datos.
// Si hay un error, termina la ejecución del script y muestra un mensaje de error.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
