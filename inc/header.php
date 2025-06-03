<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Locadora de Jogos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Cores customizadas -->
    <link rel="stylesheet" href="css/colors.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-card shadow-card mb-4">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2 text-accent" href="index.php" style="font-weight: bold; font-size: 1.5rem;">
      <i class="fas fa-gamepad"></i>
      Locadora de Jogos
    </a>
    <button class="navbar-toggler border-accent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item">
          <a class="nav-link<?= $currentPage === 'index.php' ? ' active text-accent' : ' text-light' ?>" href="index.php">Início</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?= $currentPage === 'emprestimos.php' ? ' active text-accent' : ' text-light' ?>" href="emprestimos.php">Empréstimos</a>
        </li>
        <?php if(isset($_SESSION['admin']) && $_SESSION['admin']): ?>
          <li class="nav-item">
            <a class="nav-link<?= $currentPage === 'jogo-create.php' ? ' active text-accent' : ' text-light' ?>" href="jogo-create.php">Novo Jogo</a>
          </li>
        <?php endif; ?>
        <?php if(isset($_SESSION['admin']) && $_SESSION['admin']): ?>
          <li class="nav-item">
            <span class="nav-link text-accent"><i class="fas fa-user-shield"></i> Admin</span>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="btn btn-accent ms-2">Logout</a>
          </li>
        <?php elseif(isset($_SESSION['user'])): ?>
          <li class="nav-item">
            <span class="nav-link text-accent"><i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['user']) ?></span>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="btn btn-accent ms-2">Logout</a>
          </li>
        <?php else: ?>
          <?php if($currentPage !== 'login.php'): ?>
            <li class="nav-item">
              <a href="login.php" class="btn btn-outline-accent ms-2 border-accent text-accent">Login</a>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <a href="register.php" class="btn btn-outline-light ms-2">Registrar</a>
          </li>
        <?php endif; ?>
        <li class="nav-item">
          <button id="modeToggle" class="btn btn-outline-accent ms-2 border-accent text-accent" type="button">
            <i id="modeIcon" class="fas fa-moon"></i>
            <span id="modeText" class="d-none d-md-inline">Modo Escuro</span>
          </button>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container pb-5">
