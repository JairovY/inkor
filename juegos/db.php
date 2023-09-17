<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "gameDB";

$conn = new mysqli($server, $username, $password, $database);

function isUserLoggedIn() {
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>