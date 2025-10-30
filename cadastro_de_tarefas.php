<?php
$pdo = new PDO('mysql:host=localhost;dbname=kanban_industria', 'root', '');
$usuarios = $pdo->query("SELECT id, nome FROM Usuario")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $descricao = $_POST['descricao'];
    $nome_setor = $_POST['nome_setor'];
    $prioridade = $_POST['prioridade'];
    $stmt = $pdo->prepare("INSERT INTO Tarefa (id_usuario, descricao, nome_setor, prioridade) VALUES (?, ?, ?, ?)");
    $stmt->execute([$id_usuario, $descricao, $nome_setor, $prioridade]);
    echo "<div class='alert alert-success'>Tarefa cadastrada com sucesso!</div>";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Tarefa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Cadastrar Tarefa</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Usuário:</label>
                <select name="id_usuario" class="form-control" required>
                    <?php foreach ($usuarios as $u) echo "<option value='{$u['id']}'>{$u['nome']}</option>"; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Descrição:</label>
                <textarea name="descricao" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label>Setor:</label>
                <input type="text" name="nome_setor" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Prioridade:</label>
                <select name="prioridade" class="form-control" required>
                    <option value="baixa">Baixa</option>
                    <option value="media">Média</option>
                    <option value="alta">Alta</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
        <a href="index.php" class="btn btn-secondary mt-3">Voltar ao Menu</a>
    </div>
</body>
</html>