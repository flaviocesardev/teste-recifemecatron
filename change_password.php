<?php
include './Includes/db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $repeat_password = $_POST['repeat_password'];
    
    // Buscar o usuário atual
    $login = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT password FROM clients WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verificar a senha atual
    if (password_verify($current_password, $user['password'])) {
        // Verificar se a nova senha e a repetição são iguais
        if ($new_password === $repeat_password) {
            // Atualizar a senha
            $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);
            $update_stmt = $conn->prepare("UPDATE clients SET password = ? WHERE login = ?");
            $update_stmt->bind_param("ss", $new_password_hash, $login);
            
            if ($update_stmt->execute()) {
                $success = "Senha atualizada com sucesso! Redirecionando...";
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'index.php';
                    }, 1000); // Redireciona após 1 segundos
                </script>";
            } else {
                $error = "Error: " . $update_stmt->error;
            }
        } else {
            $error = "A nova senha não coincidem.";
        }
    } else {
        $error = "Senha atual incorreta.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="Styles/change_password.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="form-container">
        <h2>Alterar senha</h2>
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
        <?php if (!$success): ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="current_password">Senha atual:</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">Nova senha:</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="repeat_password">Repita a senha:</label>
                    <input type="password" class="form-control" id="repeat_password" name="repeat_password" required>
                </div>
                <button type="submit" class="btn btn-primary">Alterar senha</button>
            </form>
        <?php endif; ?>
        <p class="mt-3"><a href="index.php">Voltar para Home</a></p>
    </div>
</div>
</body>
</html>
