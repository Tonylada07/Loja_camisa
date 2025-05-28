<?php
require_once 'includes/header.php';

// Verificar se o ID foi fornecido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    setMessage('Categoria não encontrada', 'danger');
    redirect('index.php');
}

$id = (int)$_GET['id'];
$categoria = getCategoryById($id);

// Verificar se a categoria existe
if (!$categoria) {
    setMessage('Categoria não encontrada', 'danger');
    redirect('index.php');
}

// Obter produtos da categoria
$produtos = getProducts($id);
?>

<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $categoria['nome']; ?></li>
        </ol>
    </nav>

    <h1 class="category-title"><?php echo $categoria['nome']; ?></h1>

    <div class="row">
        <?php if (empty($produtos)): ?>
            <div class="col-12">
                <div class="alert alert-info">
                    Nenhum produto disponível nesta categoria no momento.
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($produtos as $produto): ?>
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

<?php require_once 'includes/footer.php'; ?>
