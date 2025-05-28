<?php
require_once 'includes/header.php';

// Verificar se há itens no carrinho
$cart_items = getCartItems();
$cart_total = getCartTotal();

if (empty($cart_items)) {
    setMessage('Seu carrinho está vazio', 'warning');
    redirect('carrinho.php');
}

// Processar o formulário de checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    
    // Validar campos
    if (empty($nome) || empty($email) || empty($telefone) || empty($endereco)) {
        setMessage('Preencha todos os campos obrigatórios', 'danger');
    } else {
        global $db;
        
        // Escapar valores
        $nome = $db->escape($nome);
        $email = $db->escape($email);
        $telefone = $db->escape($telefone);
        $endereco = $db->escape($endereco);
        $valor_total = $cart_total;
        
        // Inserir venda
        $sql = "INSERT INTO vendas (nome_cliente, email_cliente, telefone_cliente, endereco_cliente, valor_total, status) 
                VALUES ('$nome', '$email', '$telefone', '$endereco', $valor_total, 'Pendente')";
        
        $venda_id = $db->insert($sql);
        
        if ($venda_id) {
            // Inserir itens da venda
            $success = true;
            
            foreach ($cart_items as $item) {
                $produto_id = $item['id'];
                $quantidade = $item['quantity'];
                $preco_unitario = $item['preco'];
                $subtotal = $preco_unitario * $quantidade;
                
                $sql = "INSERT INTO vendas_itens (venda_id, produto_id, quantidade, preco_unitario, subtotal) 
                        VALUES ($venda_id, $produto_id, $quantidade, $preco_unitario, $subtotal)";
                
                if (!$db->insert($sql)) {
                    $success = false;
                    break;
                }
                
                // Atualizar estoque
                $sql = "UPDATE produtos SET estoque = estoque - $quantidade WHERE id = $produto_id";
                $db->update($sql);
            }
            
            if ($success) {
                // Limpar o carrinho
                clearCart();
                
                // Redirecionar para a página de agradecimento
                redirect('agradecimento.php?id=' . $venda_id);
            } else {
                setMessage('Erro ao processar os itens da venda', 'danger');
            }
        } else {
            setMessage('Erro ao processar a venda', 'danger');
        }
    }
}
?>

<div class="container py-5">
    <h1 class="mb-4">Finalizar Compra</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="mb-3">Informações de Entrega</h4>
                    <form method="POST" action="" class="checkout-form" onsubmit="return validateCheckoutForm()">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nome" class="form-label">Nome Completo *</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">Telefone *</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="endereco" class="form-label">Endereço Completo *</label>
                                <textarea class="form-control" id="endereco" name="endereco" rows="3" required></textarea>
                            </div>
                        </div>
                        <hr class="my-4">
                        <h4 class="mb-3">Forma de Pagamento</h4>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="pagamento" id="pix" value="pix" checked>
                            <label class="form-check-label" for="pix">
                                <i class="fas fa-qrcode me-2"></i>PIX
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="pagamento" id="cartao" value="cartao">
                            <label class="form-check-label" for="cartao">
                                <i class="fas fa-credit-card me-2"></i>Cartão de Crédito
                            </label>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="radio" name="pagamento" id="boleto" value="boleto">
                            <label class="form-check-label" for="boleto">
                                <i class="fas fa-barcode me-2"></i>Boleto Bancário
                            </label>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-check me-2"></i>Confirmar Pedido
                            </button>
                            <a href="carrinho.php" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Voltar ao Carrinho
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm cart-summary">
                <div class="card-body">
                    <h4 class="mb-4">Resumo do Pedido</h4>
                    <?php foreach ($cart_items as $item): ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span><?php echo $item['nome']; ?> x <?php echo $item['quantity']; ?></span>
                        <strong><?php echo formatPrice($item['preco'] * $item['quantity']); ?></strong>
                    </div>
                    <?php endforeach; ?>
                    <hr>
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
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
