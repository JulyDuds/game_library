<?php
include 'inc/header.php';
include 'inc/db.php';
?>
<!-- Bootstrap 5 CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Cores customizadas (DEVE vir depois do Bootstrap) -->
<link rel="stylesheet" href="css/colors.css">
<h2 class="mb-4 text-accent"><i class="fas fa-list"></i> Empréstimos</h2>

<div class="table-responsive">
<table class="table table-custom table-striped table-hover align-middle rounded shadow">    <thead>
        <tr>
            <th>Jogo</th>
            <th>Cliente</th>
            <th>Data Empréstimo</th>
            <th>Data Devolução</th>
            <th>Status</th>
            <?php if(isset($_SESSION['admin']) && $_SESSION['admin']): ?><th>Ações</th><?php endif; ?>
        </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT e.*, j.nome AS jogo_nome FROM emprestimos e JOIN jogos j ON e.id_jogo = j.id ORDER BY e.data_emprestimo DESC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()):
    ?>
        <tr>
            <td><?= htmlspecialchars($row['jogo_nome']) ?></td>
            <td><?= htmlspecialchars($row['nome_cliente']) ?></td>
            <td><?= htmlspecialchars($row['data_emprestimo']) ?></td>
            <td><?= $row['data_devolucao'] ? htmlspecialchars($row['data_devolucao']) : '-' ?></td>
            <td>
                <?php if($row['devolvido']): ?>
                    <span class="badge badge-devolvido">Devolvido</span>
                <?php else: ?>
                    <span class="badge badge-pendente">Pendente</span>
                <?php endif; ?>
            </td>
            <?php if(isset($_SESSION['admin']) && $_SESSION['admin']): ?>
            <td>
                <?php if(!$row['devolvido']): ?>
                    <a href="emprestimo-receber.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Receber</a>
                <?php endif; ?>
            </td>
            <?php endif; ?>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</div>

<?php include 'inc/footer.php'; ?>