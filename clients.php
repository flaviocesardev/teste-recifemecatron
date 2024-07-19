<?php
include './Includes/db.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Exibe mensagem de sucesso se `success` está presente na URL
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo '<div class="alert alert-success" role="alert">Cliente adicionado com sucesso!</div>';
}

// Consulta para obter a lista de clientes
$clients = $conn->query("SELECT id, name FROM clients");
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include './Includes/navbar.php'; ?>

<div class="container">
    <h2>Lista de clientes</h2>
    
    
    <a href="add_client.php" class="btn btn-success mb-3">Adicionar novo cliente</a>
    
    <a href="index.php" class="btn btn-secondary mb-3">Voltar para Home</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($client = $clients->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($client['name']); ?></td>
                <td>
                    <a href="view_client.php?id=<?php echo htmlspecialchars($client['id']); ?>" class="btn btn-info btn-sm">Ver</a>
                    <a href="edit_client.php?id=<?php echo htmlspecialchars($client['id']); ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="delete_client.php?id=<?php echo htmlspecialchars($client['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Você tem certeza?')">Deletar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
