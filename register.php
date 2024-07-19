<?php
include './Includes/db.php';
session_start();

$success = false;
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário com verificação
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
    $birth_date = isset($_POST['birth_date']) ? $_POST['birth_date'] : ''; 
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $login = isset($_POST['login']) ? $_POST['login'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Verificaçao caso o login já exista na tabela de usuários
    $checkUser = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $checkUser->bind_param("s", $login);
    $checkUser->execute();
    $checkUser->store_result();

    if ($checkUser->num_rows > 0) {
        $error = "Usuário já existe";
    } else {
        // Cria o hash da senha
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        // Adiciona o usuário na tabela users
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $login, $hashPassword);

        if ($stmt->execute()) {
            // Adiciona o cliente na tabela clients
            $stmt = $conn->prepare("INSERT INTO clients (name, cpf, birth_date, gender, phone, login, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $name, $cpf, $birth_date, $gender, $phone, $login, $hashPassword);

            if ($stmt->execute()) {
                $success = "Registrado com sucesso! Redirecionando...";
                header("refresh:1;url=login.php"); // Redireciona para a página de login após 1 segundos
            } else {
                $error = "Error: " . $stmt->error;
            }
        } else {
            $error = "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="./Styles/register.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="register-container">
        <h2 class="text-center">Registrar</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="number" class="form-control" id="cpf" name="cpf" required>
            </div>
            <div class="form-group">
                <label for="birth_date">Data de Aniversário:</label>
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
                <input type="number" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="login">Login:</label>
                <input type="text" class="form-control" id="login" name="login" required>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
        </form>
        <?php if ($success): ?>
            <div class="alert alert-success mt-3"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
        <?php endif; ?>
        <p class="text-center mt-3">Já possui conta? <a href="login.php">Entrar</a></p>
    </div>
</div>
</body>
</html>
