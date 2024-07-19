<?php
$servername = "localhost";
$username = "root";
$password = "14291";
$dbname = "clientes_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

