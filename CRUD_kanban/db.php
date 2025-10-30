<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "kanban_industria";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexao falhou: " . $conn->connect_error);
}
?>