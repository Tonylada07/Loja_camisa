<?php
require_once 'includes/header.php';

// Verificar se o ID foi fornecido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    redirect('index.php');
}

$id = (int)$_GET['id'];
$venda = getSaleById($id);

// Verificar se a venda existe
if (!$venda) {
    redirect('index.php');
}
?>

<div class="container py-5 text-center">
    <div class="card shadow-sm mb-5">
        <div class="card-body py-5">
            <i class="fas fa-check-circle text-success fa-5x mb-4"></i>
            <h1 class="mb-4">Pedido Realizado com Sucesso!</h1>
            <p class="lead mb-4">Obrigado por comprar conosco, <?php echo $venda['nome_cliente']; ?>!</p>
            <p class="mb-4">Seu pedido #<?php echo $venda['id']; ?> foi registrado e está sendo processado.</p>
            <p class="mb-4">Enviamos um e-mail para <strong><?php echo $venda['email_cliente']; ?></strong> com os detalhes da sua compra.</p>
            
            <div class="card mb-4 mx-auto" style="max-width: 500px;">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Resumo do Pedido</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th>Número do Pedido:</th>
                                <td>#<?php echo $venda['id']; ?></td>
                            </tr>
                            <tr>
                                <th>Data:</th>
                                <td><?php echo date('d/m/Y H:i', strtotime($venda['data_venda'])); ?></td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td><?php echo formatPrice($venda['valor_total']); ?></td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span class="badge bg-warning">Pendente</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="d-grid gap-2 col-md-6 mx-auto">
                <a href="index.php" class="btn btn-primary btn-lg">
                    <i class="fas fa-home me-2"></i>Voltar para a Loja
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
