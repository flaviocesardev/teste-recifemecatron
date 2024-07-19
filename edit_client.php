<?php
include './Includes/db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$client_id = $_GET['id'];
$sql = "SELECT * FROM clients WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();
$client = $result->fetch_assoc();

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $cpf = $_POST['cpf'];
    $birth_date = $_POST['birth_date'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $login = $_POST['login'];

    $sql = "UPDATE clients SET name = ?, cpf = ?, birth_date = ?, gender = ?, phone = ?, login = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $name, $cpf, $birth_date, $gender, $phone, $login, $client_id);

    if ($stmt->execute()) {
        $success = "Cliente atualizado com sucesso! Redirecionando...";
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="Styles/edit_client.css" rel="stylesheet">
    
    <script>
        function redirectAfterDelay() {
            setTimeout(function() {
                window.location.href = 'clients.php';
            }, 1000);
        }
    </script>
</head>
<body onload="<?php if ($success) echo 'redirectAfterDelay()'; ?>">
    



<div class="container">
    <div class="form-container">
        <h2>Editar cliente</h2>
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
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($client['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="number" class="form-control" id="cpf" name="cpf" value="<?php echo htmlspecialchars($client['cpf']); ?>" required>
            </div>
            <div class="form-group">
                <label for="birth_date">Data de aniversário:</label>
                <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?php echo htmlspecialchars($client['birth_date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">Gênero:</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="M" <?php if ($client['gender'] == 'M') echo 'selected'; ?>>Homem</option>
                    <option value="F" <?php if ($client['gender'] == 'F') echo 'selected'; ?>>Mulher</option>
                </select>
            </div>
            <div class="form-group">
                <label for="phone">Telefone:</label>
                <input type="number" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($client['phone']); ?>" required>
            </div>
            <div class="form-group">
                <label for="login">Login:</label>
                <input type="text" class="form-control" id="login" name="login" value="<?php echo htmlspecialchars($client['login']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar cliente</button>
        </form>
        <p class="mt-3"><a href="clients.php">Voltar para lista de cliente</a></p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
