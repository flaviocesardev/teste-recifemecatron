<?php
include './Includes/db.php';
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Consulta para buscar o cliente com o login fornecido
    $stmt = $conn->prepare("SELECT * FROM clients WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verificação se o usuário foi encontrado e se a senha está correta
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['login'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Login ou senha inválido.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="./Styles/login.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="form-container">
        <h2>Entrar</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="login">Login:</label>
                <input type="text" class="form-control" id="login" name="login" required>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
        <p class="mt-3">Não possui conta? <a href="register.php">Registrar</a></p>
    </div>
</div>
</body>
</html>
