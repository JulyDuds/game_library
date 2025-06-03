<?php
include 'inc/header.php';
include 'inc/db.php';

$categorias = ['Open World', 'Sandbox', 'Esporte', 'Aventura'];
$plataformas = ['PC', 'Nintendo Switch', 'Xbox', 'PS4', 'PS5'];

if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: index.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $plataforma = $_POST['plataforma'];
    $categoria = $_POST['categoria'];
    $ano = $_POST['ano_lancamento'];
    $imagem = 'default.jpg';

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $permitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['imagem']['type'], $permitidos)) {
            $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
            $nomeArquivo = uniqid('jogo_') . '.' . $ext;
            move_uploaded_file($_FILES['imagem']['tmp_name'], "img/$nomeArquivo");
            $imagem = $nomeArquivo;
        }
    }

    $sql = "INSERT INTO jogos (nome, plataforma, categoria, ano_lancamento, imagem) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $nome, $plataforma, $categoria, $ano, $imagem);
    if ($stmt->execute()) {
        $success = "Jogo cadastrado com sucesso!";
    } else {
        $error = "Erro ao cadastrar o jogo.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <link rel="icon" type="image/x-icon" href="img/favicon.svg">
        <div class="card bg-card shadow-card border-0 mt-4">
            <div class="card-header bg-accent text-main text-center">
                <h4>Novo Jogo</h4>
            </div>

            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>
                <form method="post" enctype="multipart/form-data" novalidate>
                    <div class="mb-3">
                        <label class="form-label text-accent">Nome</label>
                        <input type="text" name="nome" class="form-control bg-secondary text-light border-accent" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-accent">Plataforma</label>
                        <select name="plataforma" class="form-select bg-secondary text-light border-accent" required>
                            <?php foreach ($plataformas as $p): ?>
                                <option value="<?= $p ?>"><?= $p ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-accent">Categoria</label>
                        <select name="categoria" class="form-select bg-secondary text-light border-accent" required>
                            <?php foreach ($categorias as $c): ?>
                                <option value="<?= $c ?>"><?= $c ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-accent">Ano de Lançamento</label>
                        <input type="number" name="ano_lancamento" class="form-control bg-secondary text-light border-accent">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-accent">Imagem da Capa</label>
                        <input type="file" name="imagem" class="form-control bg-secondary text-light border-accent" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-accent w-100">Salvar</button>
                    <a href="index.php" class="btn btn-outline-light w-100 mt-2">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
