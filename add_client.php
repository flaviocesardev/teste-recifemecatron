<?php
include './Includes/db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$success = "";
$error = "";
    // Insere os dados do cliente pelo method POST na tabela `clients`
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $cpf = $_POST['cpf'];
    $birth_date = $_POST['birth_date'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $login = $_POST['login'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO clients (name, cpf, birth_date, gender, phone, login, password) 
            VALUES ('$name', '$cpf', '$birth_date', '$gender', '$phone', '$login', '$password')";

    if ($conn->query($sql) === TRUE) {
        $success = "Cliente adicionado com sucesso! Redirecionando.";
        // Redireciona para clients.php após 1 segundos com a mensagem de sucesso
        echo '<meta http-equiv="refresh" content="1;url=clients.php">';
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="Styles/add_client.css" rel="stylesheet">
</head>
<body>


<div class="container">
    <div class="form-container">
        <h2>Adicionar Cliente</h2>
        <?php if ($success): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" id="cpf" name="cpf" required>
            </div>
            <div class="form-group">
                <label for="birth_date">Data de aniversário:</label>
                <input type="date" class="form-control" id="birth_date" name="birth_date" required>
            </div>
            <div class="form-group">
                <label for="gender">Gênero:</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="M">Homem</option>
                    <option value="F">Mulher</option>
                </select>
            </div>
            <div class="form-group">
                <label for="phone">Telefone:</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="login">Login:</label>
                <input type="text" class="form-control" id="login" name="login" required>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar cliente</button>
        </form>
        <p class="mt-3"><a href="clients.php">Voltar para lista de clientes</a></p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
