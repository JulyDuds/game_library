<?php
include 'inc/header.php';
include 'inc/db.php';

$error = '';
$success = '';
$emprestimo = null;

// Apenas admin pode receber devolução
if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: index.php");
    exit;
}

// Busca dados do empréstimo
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT e.*, j.nome AS jogo_nome, j.imagem FROM emprestimos e JOIN jogos j ON e.id_jogo = j.id WHERE e.id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $emprestimo = $result->fetch_assoc();
    if (!$emprestimo) {
        $error = "Empréstimo não encontrado.";
    }
} else {
    $error = "Empréstimo não especificado.";
}

// Processa devolução
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $emprestimo && !$emprestimo['devolvido']) {
    $data_devolucao = date('Y-m-d');
    $sql = "UPDATE emprestimos SET devolvido=1, data_devolucao=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $data_devolucao, $id);
    if ($stmt->execute()) {
        // Marca o jogo como disponível novamente
        $conn->query("UPDATE jogos SET disponivel=1 WHERE id=" . intval($emprestimo['id_jogo']));
        $success = "Devolução registrada com sucesso!";
        $emprestimo['devolvido'] = 1;
        $emprestimo['data_devolucao'] = $data_devolucao;
    } else {
        $error = "Erro ao registrar devolução.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card card-custom shadow-card border-0 mt-5">
            <div class="card-header bg-accent text-main text-center">
                <h4>Receber Devolução</h4>
            </div>
            <div class="card-body">
                <?php if($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php elseif($success): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php elseif($emprestimo): ?>
                    <div class="mb-3 text-center">
                        <img src="img/<?= htmlspecialchars($emprestimo['imagem']) ?>" alt="Capa" class="img-thumbnail mb-2" style="max-width: 120px;">
                        <div class="fw-bold text-accent"><?= htmlspecialchars($emprestimo['jogo_nome']) ?></div>
                        <div>Cliente: <?= htmlspecialchars($emprestimo['nome_cliente']) ?></div>
                        <div>Empréstimo: <?= date('d/m/Y', strtotime($emprestimo['data_emprestimo'])) ?></div>
                        <div>Status: 
                            <?php if($emprestimo['devolvido']): ?>
                                <span class="badge bg-success">Devolvido</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Pendente</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if(!$emprestimo['devolvido']): ?>
                        <form method="post">
                            <button type="submit" class="btn btn-accent w-100">Confirmar Devolução</button>
                            <a href="emprestimos.php" class="btn btn-outline-light w-100 mt-2">Cancelar</a>
                        </form>
                    <?php else: ?>
                        <a href="emprestimos.php" class="btn btn-accent w-100">Voltar</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
