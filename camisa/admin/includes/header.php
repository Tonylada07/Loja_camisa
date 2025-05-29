<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';

// Verificar se o usuário está logado
if (!isLoggedIn() && basename($_SERVER['PHP_SELF']) != 'login.php') {
    redirect('login.php');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php if (isLoggedIn()): ?>
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h5 class="text-white">Painel Administrativo</h5>
                        <p class="text-white-50">Camisas de Times</p>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../index.php">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../categorias/index.php">
                                <i class="fas fa-tags me-2"></i>Categorias
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../produtos/index.php">
                                <i class="fas fa-tshirt me-2"></i>Produtos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="vendas/index.php">
                                <i class="fas fa-shopping-cart me-2"></i>Vendas
                            </a>
                        </li>
                        <li class="nav-item mt-5">
                            <a class="nav-link text-white" href="../admin/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i>Sair
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <?php endif; ?>

            <!-- Conteúdo principal -->
            <main class="<?php echo isLoggedIn() ? 'col-md-9 ms-sm-auto col-lg-10 px-md-4' : 'col-12'; ?>">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <?php if (isLoggedIn()): ?>
                    <h1 class="h2">Painel Administrativo</h1>
                    <?php endif; ?>
                </div>

                <?php
                $message = getMessage();
                if ($message): 
                ?>
                <div class="alert alert-<?php echo $message['type']; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message['message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>