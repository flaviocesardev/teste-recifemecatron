<link href="styles/navbar.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand home-link" href="index.php">Home</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link clients-link" href="clients.php">Clientes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link clients-link" href="change_password.php">Alterar Senha</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="navbar-text user-name">Olá, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            </li>
            <li class="nav-item">
                <a class="nav-link logout-link" href="logout.php">Sair</a>
            </li>
        </ul>
    </div>
</nav>

