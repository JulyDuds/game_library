<?php
include 'inc/header.php';
include 'inc/db.php';

if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger mt-5'>Jogo não especificado.</div>";
    include 'inc/footer.php';
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT imagem, nome FROM jogos WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$jogo = $res->fetch_assoc();

if (!$jogo) {
    echo "<div class='alert alert-danger mt-5'>Jogo não encontrado.</div>";
    include 'inc/footer.php';
    exit;
}

if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    // Exclui imagem se não for a padrão
    if ($jogo['imagem'] !== 'default.jpg' && file_exists('img/'.$jogo['imagem'])) {
        unlink('img/'.$jogo['imagem']);
    }
    $conn->query("DELETE FROM jogos WHERE id=$id");
    echo "<div class='alert alert-success mt-5'>Jogo excluído com sucesso! <a href='index.php' class='btn btn-accent ms-2'>Voltar</a></div>";
    include 'inc/footer.php';
    exit;
}
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card bg-card shadow-card border-0 mt-5">
            <div class="card-header bg-danger text-light text-center">
                <h4>Excluir Jogo</h4>
            </div>
            <div class="card-body text-center">
                <p>Tem certeza que deseja excluir o jogo <span class="text-accent fw-bold"><?= htmlspecialchars($jogo['nome']) ?></span>?</p>
                <img src="img/<?= htmlspecialchars($jogo['imagem']) ?>" alt="Capa" class="img-thumbnail mb-3" style="max-width: 120px;">
                <form method="post">
                    <input type="hidden" name="confirm" value="yes">
                    <button type="submit" class="btn btn-danger">Sim, excluir</button>
                    <a href="index.php" class="btn btn-outline-light ms-2">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>
