<?php
include 'inc/header.php';
include 'inc/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    // Tenta admin
    $sql = "SELECT * FROM admin WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    if ($admin && password_verify($pass, $admin['password'])) {
        $_SESSION['admin'] = true;
        $_SESSION['username'] = $admin['username'];
        header("Location: index.php");
        exit;
    }

    // Tenta usuário comum
    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $userRow = $result->fetch_assoc();
    if ($userRow && password_verify($pass, $userRow['password'])) {
        $_SESSION['user'] = $userRow['username'];
        header("Location: index.php");
        exit;
    }

    $error = "Usuário ou senha inválidos!";
}
?>

<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card bg-card shadow-card border-0 mt-5">
            <div class="card-header bg-accent text-main text-center">
                <h4>Login</h4>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form method="post" novalidate>
                    <div class="mb-3">
                        <label class="form-label text-accent">Usuário</label>
                        <input type="text" name="username" class="form-control bg-secondary text-light border-accent" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-accent">Senha</label>
                        <input type="password" name="password" class="form-control bg-secondary text-light border-accent" required>
                    </div>
                    <button type="submit" class="btn btn-accent w-100">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
