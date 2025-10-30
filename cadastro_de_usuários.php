<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdo = new PDO('mysql:host=localhost;dbname=kanban_industria', 'root', '');
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $stmt = $pdo->prepare("INSERT INTO Usuario (nome, email) VALUES (?, ?)");
    $stmt->execute([$nome, $email]);
    echo "<div class='alert alert-success'>Cadastro concluído com sucesso!</div>";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function validarEmail() {
            const email = document.getElementById('email').value;
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!regex.test(email)) {
                alert('E-mail inválido!');
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container mt-4">
        <h2>Cadastrar Usuário</h2>
        <form method="POST" onsubmit="return validarEmail()">
            <div class="mb-3">
                <label>Nome:</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>E-mail:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
        <a href="index.php" class="btn btn-secondary mt-3">Voltar ao Menu</a>
    </div>
</body>
</html>