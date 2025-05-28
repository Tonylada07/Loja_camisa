<?php
require_once 'includes/header.php';

// Obter produtos em destaque (os mais recentes)
$produtos_destaque = $db->select("SELECT p.*, c.nome as categoria FROM produtos p 
                                 INNER JOIN categorias c ON p.categoria_id = c.id 
                                 ORDER BY p.id DESC LIMIT 8");
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1>Camisas de Times Oficiais</h1>
                <p>Encontre as melhores camisas de times nacionais e internacionais com qualidade e preço justo.</p>
                <a href="#produtos" class="btn btn-light btn-lg">Ver Produtos</a>
            </div>
            <div class="col-md-6 d-none d-md-block">
                <img src="assets/img/image.png" alt="Camisas de Times" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Categorias -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Categorias</h2>
        <div class="row">
            <?php foreach ($categorias_menu as $categoria): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $categoria['nome']; ?></h5>
                        <a href="categoria.php?id=<?php echo $categoria['id']; ?>" class="btn btn-outline-primary">Ver Produtos</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Produtos em Destaque -->
<section class="py-5 bg-light" id="produtos">
    <div class="container">
        <h2 class="text-center mb-4">Produtos em Destaque</h2>
        <div class="row">
            <?php if (empty($produtos_destaque)): ?>
                <div class="col-12">
                    <p class="text-center">Nenhum produto disponível no momento.</p>
                </div>
            <?php else: ?>
                <?php foreach ($produtos_destaque as $produto): ?>
                <div class="col-md-3 mb-4">
                    <div class="card card-product h-100">
                        <div class="position-relative">
                            <?php if (!empty($produto['imagem'])): ?>
                                <img src="assets/img/<?php echo $produto['imagem']; ?>" class="card-img-top" alt="<?php echo $produto['nome']; ?>">
                            <?php else: ?>
                                <img src="assets/img/no-image.jpg" class="card-img-top" alt="Sem imagem">
                            <?php endif; ?>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $produto['nome']; ?></h5>
                            <p class="card-text text-muted"><?php echo $produto['categoria']; ?></p>
                            <div class="price mb-3"><?php echo formatPrice($produto['preco']); ?></div>
                            <div class="mt-auto">
                                <a href="produto.php?id=<?php echo $produto['id']; ?>" class="btn btn-outline-primary mb-2 w-100">Ver Detalhes</a>
                                <form action="carrinho_adicionar.php" method="post">
                                    <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                                    <input type="hidden" name="quantidade" value="1">
                                    <button type="submit" class="btn btn-primary w-100" onclick="addToCartWithAnimation(this)">
                                        <i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Vantagens -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Por que comprar conosco?</h2>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="p-3">
                    <i class="fas fa-truck fa-3x mb-3 text-primary"></i>
                    <h4>Entrega Rápida</h4>
                    <p class="text-muted">Enviamos para todo o Brasil com rapidez e segurança.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-3">
                    <i class="fas fa-shield-alt fa-3x mb-3 text-primary"></i>
                    <h4>Produtos Originais</h4>
                    <p class="text-muted">Garantimos a autenticidade de todos os nossos produtos.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-3">
                    <i class="fas fa-credit-card fa-3x mb-3 text-primary"></i>
                    <h4>Pagamento Seguro</h4>
                    <p class="text-muted">Diversas formas de pagamento com total segurança.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
