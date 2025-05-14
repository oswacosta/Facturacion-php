<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "informatic";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}

// Temporal: ver si llega aquí
// echo "Conexión correcta"; 
?>
