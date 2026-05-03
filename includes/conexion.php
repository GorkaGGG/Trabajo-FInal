<?php
// Configuración de la conexión a MySQL
$host = '127.0.0.1';
$db   = 'hotel';
$user = 'root';
$pass = ''; // ajusta si tienes contraseña
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Crear conexión usando PDO
    $conexion = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // En caso de error, mostrar el mensaje
    http_response_code(500);
    echo 'DB error: ' . htmlspecialchars($e->getMessage());
    exit;
}
?>