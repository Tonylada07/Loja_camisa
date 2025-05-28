<?php
require_once '../includes/header.php';

// Obter todas as vendas
$vendas = getSales();
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">Gerenciar Vendas</h2>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if (empty($vendas)): ?>
                <p class="text-center py-3">Nenhuma venda registrada.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Cliente</th>
                                <th>Email</th>
                                <th>Valor Total</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th width="10%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($vendas as $venda): ?>
                            <tr>
                                <td><?php echo $venda['id']; ?></td>
                                <td><?php echo $venda['nome_cliente']; ?></td>
                                <td><?php echo $venda['email_cliente']; ?></td>
                                <td><?php echo formatPrice($venda['valor_total']); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $venda['status'] == 'Concluída' ? 'success' : 'warning'; ?>">
                                        <?php echo $venda['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($venda['data_venda'])); ?></td>
                                <td>
                                    <a href="visualizar.php?id=<?php echo $venda['id']; ?>" class="btn btn-sm btn-info btn-action" data-bs-toggle="tooltip" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if ($venda['status'] != 'Concluída'): ?>
                                    <a href="concluir.php?id=<?php echo $venda['id']; ?>" class="btn btn-sm btn-success btn-action" data-bs-toggle="tooltip" title="Marcar como Concluída" onclick="return confirm('Confirmar conclusão desta venda?')">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
