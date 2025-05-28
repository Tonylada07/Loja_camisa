<?php
require_once '../includes/header.php';

// Verificar se o ID foi fornecido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    setMessage('ID da venda não fornecido', 'danger');
    redirect('index.php');
}

$id = (int)$_GET['id'];
$venda = getSaleById($id);

// Verificar se a venda existe
if (!$venda) {
    setMessage('Venda não encontrada', 'danger');
    redirect('index.php');
}
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">Detalhes da Venda #<?php echo $venda['id']; ?></h2>
        <div>
            <?php if ($venda['status'] != 'Concluída'): ?>
            <a href="concluir.php?id=<?php echo $venda['id']; ?>" class="btn btn-success me-2" onclick="return confirm('Confirmar conclusão desta venda?')">
                <i class="fas fa-check me-1"></i> Marcar como Concluída
            </a>
            <?php endif; ?>
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informações da Venda</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">ID da Venda</th>
                                <td><?php echo $venda['id']; ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge bg-<?php echo $venda['status'] == 'Concluída' ? 'success' : 'warning'; ?>">
                                        <?php echo $venda['status']; ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Data da Venda</th>
                                <td><?php echo date('d/m/Y H:i', strtotime($venda['data_venda'])); ?></td>
                            </tr>
                            <tr>
                                <th>Valor Total</th>
                                <td><strong><?php echo formatPrice($venda['valor_total']); ?></strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informações do Cliente</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Nome</th>
                                <td><?php echo $venda['nome_cliente']; ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo $venda['email_cliente']; ?></td>
                            </tr>
                            <tr>
                                <th>Telefone</th>
                                <td><?php echo $venda['telefone_cliente']; ?></td>
                            </tr>
                            <tr>
                                <th>Endereço</th>
                                <td><?php echo $venda['endereco_cliente']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Itens da Venda</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="10%">Imagem</th>
                            <th>Produto</th>
                            <th>Preço Unitário</th>
                            <th>Quantidade</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($venda['itens'] as $item): ?>
                        <tr>
                            <td>
                                <?php if (!empty($item['imagem'])): ?>
                                    <img src="../../assets/img/<?php echo $item['imagem']; ?>" alt="<?php echo $item['nome']; ?>" class="product-image">
                                <?php else: ?>
                                    <img src="../../assets/img/no-image.jpg" alt="Sem imagem" class="product-image">
                                <?php endif; ?>
                            </td>
                            <td><?php echo $item['nome']; ?></td>
                            <td><?php echo formatPrice($item['preco_unitario']); ?></td>
                            <td><?php echo $item['quantidade']; ?></td>
                            <td><?php echo formatPrice($item['subtotal']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th><?php echo formatPrice($venda['valor_total']); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
