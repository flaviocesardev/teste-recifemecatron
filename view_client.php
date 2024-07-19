<?php
include './Includes/db.php';
session_start();

// If para verificar se o usuário está logado
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Pega o ID pela URL
if (isset($_GET['id'])) {
    $client_id = intval($_GET['id']);

    
    $stmt = $conn->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->bind_param('i', $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $client = $result->fetch_assoc();

    if (!$client) {
        echo '<div class="alert alert-danger" role="alert">Cliente não encontrado!</div>';
        exit();
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Invalid request!</div>';
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include './Includes/navbar.php'; ?>

<div class="container">
    <h2>Detalhes do cliente</h2>
    
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Nome:</th>
                <td><?php echo htmlspecialchars($client['name']); ?></td>
            </tr>
            <tr>
                <th>CPF:</th>
                <td><?php echo htmlspecialchars($client['cpf']); ?></td>
            </tr>
            <tr>
                <th>Data de Aniversário:</th>
                <td><?php echo htmlspecialchars($client['birth_date']); ?></td>
            </tr>
            <tr>
                <th>Gênero:</th>
                <td><?php echo htmlspecialchars($client['gender']); ?></td>
            </tr>
            <tr>
                <th>Telefone:</th>
                <td><?php echo htmlspecialchars($client['phone']); ?></td>
            </tr>
            <tr>
                <th>Login:</th>
                <td><?php echo htmlspecialchars($client['login']); ?></td>
            </tr>
        </tbody>
    </table>

    <a href="clients.php" class="btn btn-secondary">Voltar para lista de clientes</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
