<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$host = 'localhost';
$db   = 'locadora';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Erro de conexão: " . $conn->connect_error);
?>
