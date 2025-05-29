<?php
require_once 'includes/header.php';

// Verificar se o ID foi fornecido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    setMessage('Produto não encontrado', 'danger');
    redirect('index.php');
}

$id = (int)$_GET['id'];
$produto = getProductById($id);

// Verificar se o produto existe
if (!$produto) {
    setMessage('Produto não encontrado', 'danger');
    redirect('index.php');
}

// Obter produtos relacionados (mesma categoria)
$produtos_relacionados = $db->select("SELECT p.*, c.nome as categoria FROM produtos p 
                                     INNER JOIN categorias c ON p.categoria_id = c.id 
                                     WHERE p.categoria_id = {$produto['categoria_id']} 
                                     AND p.id != {$produto['id']} 
                                     ORDER BY RAND() LIMIT 4");
?>

<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="categoria.php?id=<?php echo $produto['categoria_id']; ?>"><?php echo $produto['categoria']; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $produto['nome']; ?></li>
        </ol>
    </nav>

    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <div class="row">
                <div class="product-image-container text-center p-4">
                    <?php if (!empty($produto['imagem'])): ?>
                        <img src="assets/img/<?php echo $produto['imagem']; ?>" class="product-detail-img" alt="<?php echo $produto['nome']; ?>">
                    <?php else: ?>
                        <img src="assets/img/no-image.jpg" class="product-detail-img" alt="Sem imagem">
                    <?php endif; ?>
                </div>
                <div class="col-md-5">

                </div>
                <div class="col-md-7 product-detail-info">
                    <h1 class="h2 mb-2"><?php echo $produto['nome']; ?></h1>
                    <p class="text-muted mb-3">Categoria: <?php echo $produto['categoria']; ?></p>
                    <div class="product-detail-price"><?php echo formatPrice($produto['preco']); ?></div>

                    <?php if ($produto['estoque'] > 0): ?>
                        <div class="mb-3">
                            <span class="badge bg-success">Em estoque</span>
                            <span class="text-muted ms-2"><?php echo $produto['estoque']; ?> unidades disponíveis</span>
                        </div>
                    <?php else: ?>
                        <div class="mb-3">
                            <span class="badge bg-danger">Fora de estoque</span>
                        </div>
                    <?php endif; ?>

                    <div class="product-detail-description mb-4">
                        <?php if (!empty($produto['descricao'])): ?>
                            <h5>Descrição</h5>
                            <p><?php echo nl2br($produto['descricao']); ?></p>
                        <?php endif; ?>
                    </div>

                    <?php if ($produto['estoque'] > 0): ?>
                        <form action="carrinho_adicionar.php" method="post">
                            <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                            <div class="row g-3 align-items-center mb-4">
                                <div class="col-auto">
                                    <label for="quantidade" class="col-form-label">Quantidade:</label>
                                </div>
                                <div class="col-auto">
                                    <input type="number" id="quantidade" name="quantidade" class="form-control" value="1" min="1" max="<?php echo $produto['estoque']; ?>">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-shopping-cart me-2"></i>Adicionar ao Carrinho
                                    </button>
                                </div>
                            </div>
                        </form>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-lg" disabled>
                            <i class="fas fa-shopping-cart me-2"></i>Produto Indisponível
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Produtos Relacionados -->
    <?php if (!empty($produtos_relacionados)): ?>
        <div class="related-products">
            <h3 class="mb-4">Produtos Relacionados</h3>
            <div class="row">
                <?php foreach ($produtos_relacionados as $produto_rel): ?>
                    <div class="col-md-3 mb-4">
                        <div class="card card-product h-100">
                            <div class="position-relative">
                                <?php if (!empty($produto_rel['imagem'])): ?>
                                    <img src="assets/img/<?php echo $produto_rel['imagem']; ?>" class="card-img-top" alt="<?php echo $produto_rel['nome']; ?>">
                                <?php else: ?>
                                    <img src="assets/img/no-image.jpg" class="card-img-top" alt="Sem imagem">
                                <?php endif; ?>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo $produto_rel['nome']; ?></h5>
                                <p class="card-text text-muted"><?php echo $produto_rel['categoria']; ?></p>
                                <div class="price mb-3"><?php echo formatPrice($produto_rel['preco']); ?></div>
                                <div class="mt-auto">
                                    <a href="produto.php?id=<?php echo $produto_rel['id']; ?>" class="btn btn-outline-primary mb-2 w-100">Ver Detalhes</a>
                                    <form action="carrinho_adicionar.php" method="post">
                                        <input type="hidden" name="produto_id" value="<?php echo $produto_rel['id']; ?>">
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
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>