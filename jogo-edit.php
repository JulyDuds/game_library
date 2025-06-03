<?php
include 'inc/header.php';
include 'inc/db.php';

if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);
$error = '';
$success = '';

$sql = "SELECT * FROM jogos WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$jogo = $result->fetch_assoc();

if (!$jogo) {
    echo "<div class='alert alert-danger'>Jogo não encontrado.</div>";
    include 'inc/footer.php';
    exit;
}

$categorias = ['Open World', 'Sandbox', 'Esporte', 'Aventura'];
$plataformas = ['PC', 'Nintendo Switch', 'Xbox', 'PS4', 'PS5'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $plataforma = $_POST['plataforma'];
    $categoria = $_POST['categoria'];
    $ano = $_POST['ano_lancamento'];
    $imagem = $jogo['imagem'];

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $permitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['imagem']['type'], $permitidos)) {
            $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
            $nomeArquivo = uniqid('jogo_') . '.' . $ext;
            move_uploaded_file($_FILES['imagem']['tmp_name'], "img/$nomeArquivo");
            if ($jogo['imagem'] !== 'default.jpg' && file_exists('img/' . $jogo['imagem'])) {
                unlink('img/' . $jogo['imagem']);
            }
            $imagem = $nomeArquivo;
        }
    }

    $sql = "UPDATE jogos SET nome=?, plataforma=?, categoria=?, ano_lancamento=?, imagem=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nome, $plataforma, $categoria, $ano, $imagem, $id);
    if ($stmt->execute()) {
        $success = "Jogo atualizado com sucesso!";
        // Atualiza os dados para mostrar no formulário
        $jogo['nome'] = $nome;
        $jogo['plataforma'] = $plataforma;
        $jogo['categoria'] = $categoria;
        $jogo['ano_lancamento'] = $ano;
        $jogo['imagem'] = $imagem;
    } else {
        $error = "Erro ao atualizar o jogo.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="card bg-card shadow-card border-0 mt-4">
            <div class="card-header bg-accent text-main text-center">
                <h4>Editar Jogo</h4>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>
                <form method="post" enctype="multipart/form-data" novalidate>
                    <div class="mb-3 text-center">
                        <img src="img/<?= htmlspecialchars($jogo['imagem']) ?>" alt="Capa" class="img-thumbnail" style="max-width: 140px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-accent">Nome</label>
                        <input type="text" name="nome" class="form-control bg-secondary text-light border-accent" value="<?= htmlspecialchars($jogo['nome']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-accent">Plataforma</label>
                        <select name="plataforma" class="form-select bg-secondary text-light border-accent" required>
                            <?php foreach ($plataformas as $p): ?>
                                <option value="<?= $p ?>" <?= $jogo['plataforma'] === $p ? 'selected' : '' ?>><?= $p ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-accent">Categoria</label>
                        <select name="categoria" class="form-select bg-secondary text-light border-accent" required>
                            <?php foreach ($categorias as $c): ?>
                                <option value="<?= $c ?>" <?= $jogo['categoria'] === $c ? 'selected' : '' ?>><?= $c ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-accent">Ano de Lançamento</label>
                        <input type="number" name="ano_lancamento" class="form-control bg-secondary text-light border-accent" value="<?= htmlspecialchars($jogo['ano_lancamento']) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-accent">Nova Imagem da Capa (opcional)</label>
                        <input type="file" name="imagem" class="form-control bg-secondary text-light border-accent" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-accent w-100">Atualizar</button>
                    <a href="index.php" class="btn btn-outline-light w-100 mt-2">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
