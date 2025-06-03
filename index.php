<?php
include 'inc/header.php';
include 'inc/db.php';
?>
<h2 class="mb-4 text-accent"><i class="fas fa-gamepad"></i> Jogos Disponíveis</h2>
<link rel="icon" type="image/x-icon" href="img/favicon.svg">
<div class="row g-4">
<?php

$sql = "SELECT * FROM jogos";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()):
?>
  <div class="col-12 mb-5 col-sm-6 col-md-4 col-lg-3">
    <div class="card card-custom h-100 d-flex flex-column justify-content-between shadow-card border-0">
      <img src="img/<?= htmlspecialchars($row['imagem']) ?>" class="card-img-top" alt="Capa do jogo" style="height: 250px; object-fit: cover;">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title text-accent"><?= htmlspecialchars($row['nome']) ?></h5>
        <p class="card-text mb-1">
            <span class="badge bg-accent text-main"><?= htmlspecialchars($row['plataforma']) ?></span>
            <span class="badge bg-warning text-dark"><?= htmlspecialchars($row['categoria']) ?></span>
        </p>
        <p class="card-text mb-2">Ano: <?= htmlspecialchars($row['ano_lancamento']) ?></p>
        <div class="mb-2">
          <?php if($row['disponivel']): ?>
            <span class="badge bg-success">Disponível</span>
          <?php else: ?>
            <span class="badge bg-danger">Emprestado</span>
          <?php endif; ?>
        </div>
        <div class="mt-auto">
          <?php if(isset($_SESSION['admin']) && $_SESSION['admin']): ?>
            <a href="jogo-edit.php?id=<?= $row['id'] ?>" class="btn btn-outline-accent btn-sm mb-1 w-100 border-accent text-accent"><i class="fas fa-edit"></i> Editar</a>
            <a href="jogo-delete.php?id=<?= $row['id'] ?>" class="btn btn-outline-danger btn-sm mb-1 w-100" onclick="return confirm('Tem certeza?')"><i class="fas fa-trash-alt"></i> Excluir</a>
          <?php endif; ?>
          <?php if($row['disponivel']): ?>
            <a href="emprestimo-create.php?id_jogo=<?= $row['id'] ?>" class="btn btn-accent btn-sm w-100"><i class="fas fa-arrow-right"></i> Emprestar</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
<?php endwhile; ?>
</div>
<?php include 'inc/footer.php'; ?>
