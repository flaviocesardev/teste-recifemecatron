<?php
include './Includes/db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Busca de login do cliente que será deletado
    $stmt = $conn->prepare("SELECT login FROM clients WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $client = $result->fetch_assoc();
    
    if ($client) {
        $login = $client['login'];

        // Deleta o cliente da tabela `clients`
        $stmt = $conn->prepare("DELETE FROM clients WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Deleta o usuário da tabela `users`
        $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
    }
}

header("Location: clients.php");
exit();

