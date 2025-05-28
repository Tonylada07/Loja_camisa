<?php
require_once 'includes/header.php';

// Obter itens do carrinho
$cart_items = getCartItems();
$cart_total = getCartTotal();
?>

<div class="container py-5">
    <h1 class="mb-4">Carrinho de Compras</h1>

    <?php if (empty($cart_items)): ?>
        <div class="alert alert-info">
            <p>Seu carrinho está vazio.</p>
            <a href="index.php" class="btn btn-primary mt-3">Continuar Comprando</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="cart-item row align-items-center">
                                <div class="col-md-2">
                                    <?php if (!empty($item['imagem'])): ?>
                                        <img src="assets/img/<?php echo $item['imagem']; ?>" class="cart-item-img" alt="<?php echo $item['nome']; ?>">
                                    <?php else: ?>
                                        <img src="assets/img/no-image.jpg" class="cart-item-img" alt="Sem imagem">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-4">
                                    <h5><?php echo $item['nome']; ?></h5>
                                    <p class="text-muted"><?php echo formatPrice($item['preco']); ?> cada</p>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <form id="update-form-<?php echo $item['id']; ?>" action="carrinho_atualizar.php" method="post">
                                            <input type="hidden" name="produto_id" value="<?php echo $item['id']; ?>">
                                            <div class="input-group">
                                                <button type="button" class="btn btn-outline-secondary" onclick="updateCartQuantity(<?php echo $item['id']; ?>, 'decrease')">-</button>
                                                <input type="number" id="quantity-<?php echo $item['id']; ?>" name="quantidade" class="form-control text-center" value="<?php echo $item['quantity']; ?>" min="1" readonly>
                                                <button type="button" class="btn btn-outline-secondary" onclick="updateCartQuantity(<?php echo $item['id']; ?>, 'increase')">+</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <strong><?php echo formatPrice($item['preco'] * $item['quantity']); ?></strong>
                                </div>
                                <div class="col-md-1 text-end">
                                    <a href="carrinho_remover.php?id=<?php echo $item['id']; ?>" class="text-danger" onclick="return confirm('Tem certeza que deseja remover este item?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Continuar Comprando
                    </a>
                    <a href="carrinho_limpar.php" class="btn btn-outline-danger" onclick="return confirm('Tem certeza que deseja limpar o carrinho?')">
                        <i class="fas fa-trash me-2"></i>Limpar Carrinho
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm cart-summary">
                    <div class="card-body">
                        <h4 class="mb-4">Resumo do Pedido</h4>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong><?php echo formatPrice($cart_total); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Frete:</span>
                            <strong>Grátis</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4 cart-total">
                            <span>Total:</span>
                            <strong><?php echo formatPrice($cart_total); ?></strong>
                        </div>
                        <a href="finalizar.php" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-check me-2"></i>Finalizar Compra
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
