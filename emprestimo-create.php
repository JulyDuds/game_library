<?php
include 'inc/header.php';
include 'inc/db.php';

$error = '';
$success = '';
$jogo = null;

// Verifica se está logado (admin ou user)
if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Busca dados do jogo
if (isset($_GET['id_jogo']) && is_numeric($_GET['id_jogo'])) {
    $id_jogo = intval($_GET['id_jogo']);
    $sql = "SELECT * FROM jogos WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_jogo);
    $stmt->execute();
    $result = $stmt->get_result();
    $jogo = $result->fetch_assoc();
    if (!$jogo) {
        $error = "Jogo não encontrado.";
    }
} else {
    $error = "Jogo não especificado.";
}

// Processa empréstimo
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $jogo) {
    $cliente = isset($_SESSION['user']) ? $_SESSION['user'] : 'Admin';
    $data = date('Y-m-d');
    $sql = "INSERT INTO emprestimos (id_jogo, nome_cliente, data_emprestimo, devolvido) VALUES (?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $id_jogo, $cliente, $data);
    if ($stmt->execute()) {
        // Marca o jogo como indisponível
        $conn->query("UPDATE jogos SET disponivel=0 WHERE id=$id_jogo");
        $success = "Empréstimo registrado com sucesso!";
    } else {
        $error = "Erro ao registrar o empréstimo.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card card-custom shadow-card border-0 mt-5">
            <div class="card-header bg-accent text-main text-center">
                <h4>Registrar Empréstimo</h4>
            </div>
            <div class="card-body">
                <?php if($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php elseif($success): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php elseif($jogo): ?>
                    <div class="mb-3 text-center">
                        <img src="img/<?= htmlspecialchars($jogo['imagem']) ?>" alt="Capa" class="img-thumbnail mb-2" style="max-width: 120px;">
                        <div class="fw-bold text-accent"><?= htmlspecialchars($jogo['nome']) ?></div>
                        <div><?= htmlspecialchars($jogo['plataforma']) ?> · <?= htmlspecialchars($jogo['categoria']) ?></div>
                    </div>
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label text-accent">Cliente</label>
                            <input type="text" class="form-control bg-secondary text-light border-accent" value="<?= isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : 'Admin' ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-accent">Data do Empréstimo</label>
                            <input type="text" class="form-control bg-secondary text-light border-accent" value="<?= date('d/m/Y') ?>" disabled>
                        </div>
                        <button type="submit" class="btn btn-accent w-100">Confirmar Empréstimo</button>
                        <a href="index.php" class="btn btn-outline-light w-100 mt-2">Cancelar</a>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
