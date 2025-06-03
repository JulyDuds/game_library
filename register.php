<?php
include 'inc/header.php';
include 'inc/db.php';
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];
    $pass2 = $_POST['password2'];
    if ($pass !== $pass2) {
        $error = "As senhas não coincidem!";
    } else {
        $sql = "SELECT id FROM users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Nome de usuário já existe!";
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $user, $hash);
            if ($stmt->execute()) {
                $success = "Conta criada com sucesso! <a href='login.php'>Faça login</a>";
            } else {
                $error = "Erro ao registrar. Tente novamente.";
            }
        }
    }
}
?>
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card bg-card shadow-card border-0 mt-5">
            <div class="card-header bg-accent text-main text-center">
                <h4>Registrar Usuário</h4>
            </div>
            <div class="card-body">
                <?php if($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <?php if($success): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>
                <form method="post" novalidate>
                    <div class="mb-3">
                        <label class="form-label text-accent">Nome de usuário</label>
                        <input type="text" name="username" class="form-control bg-secondary text-light border-accent" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-accent">Senha</label>
                        <input type="password" name="password" class="form-control bg-secondary text-light border-accent" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-accent">Repita a senha</label>
                        <input type="password" name="password2" class="form-control bg-secondary text-light border-accent" required>
                    </div>
                    <button class="btn btn-accent w-100" type="submit">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>
