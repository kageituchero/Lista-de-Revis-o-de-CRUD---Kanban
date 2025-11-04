<?php
$pdo = new PDO('mysql:host=localhost;dbname=kanban_industria', 'root', 'root');

if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $tarefa = $pdo->prepare("SELECT * FROM Tarefa WHERE id = ?");
    $tarefa->execute([$id]);
    $t = $tarefa->fetch(PDO::FETCH_ASSOC);
    header("Location: cadastro_tarefa.php?editar=1&id={$t['id']}&id_usuario={$t['id_usuario']}&descricao={$t['descricao']}&nome_setor={$t['nome_setor']}&prioridade={$t['prioridade']}");
}

if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $pdo->prepare("DELETE FROM Tarefa WHERE id = ?")->execute([$id]);
    echo "<div class='alert alert-success'>Tarefa excluída!</div>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['alterar_status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $pdo->prepare("UPDATE Tarefa SET status = ? WHERE id = ?")->execute([$status, $id]);
}

$tarefas = $pdo->query("SELECT t.*, u.nome AS usuario FROM Tarefa t JOIN Usuario u ON t.id_usuario = u.id ORDER BY t.data_cadastro DESC")->fetchAll(PDO::FETCH_ASSOC);
$colunas = ['a fazer' => [], 'fazendo' => [], 'pronto' => []];
foreach ($tarefas as $t) $colunas[$t['status']][] = $t;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function confirmarExclusao(id) {
            if (confirm('Tem certeza que deseja excluir?')) {
                window.location.href = '?excluir=' + id;
            }
        }
    </script>
</head>
<body>
    <div class="container mt-4">
        <h2>Gerenciar Tarefas</h2>
        <div class="row">
            <?php foreach ($colunas as $status => $tarefas): ?>
                <div class="col-md-4">
                    <h3><?php echo ucfirst($status); ?></h3>
                    <?php foreach ($tarefas as $t): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <p><strong>Descrição:</strong> <?php echo $t['descricao']; ?></p>
                                <p><strong>Setor:</strong> <?php echo $t['nome_setor']; ?></p>
                                <p><strong>Prioridade:</strong> <?php echo $t['prioridade']; ?></p>
                                <p><strong>Usuário:</strong> <?php echo $t['usuario']; ?></p>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $t['id']; ?>">
                                    <select name="status" class="form-select d-inline w-auto">
                                        <option value="a fazer" <?php if ($t['status'] == 'a fazer') echo 'selected'; ?>>A Fazer</option>
                                        <option value="fazendo" <?php if ($t['status'] == 'fazendo') echo 'selected'; ?>>Fazendo</option>
                                        <option value="pronto" <?php if ($t['status'] == 'pronto') echo 'selected'; ?>>Pronto</option>
                                    </select>
                                    <button type="submit" name="alterar_status" class="btn btn-sm btn-primary">Alterar</button>
                                </form>
                                <button onclick="confirmarExclusao(<?php echo $t['id']; ?>)" class="btn btn-sm btn-danger">Excluir</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="kanban.php" class="btn btn-secondary mt-3">Voltar ao Menu</a>
    </div>
</body>
</html>