<?php
require_once 'includes/header.php';

// Obter estatísticas para o dashboard
$totalCategorias = count(getCategories());
$totalProdutos = count(getProducts());
$totalVendas = count(getSales());

// Obter vendas recentes
$vendasRecentes = $db->select("SELECT * FROM vendas ORDER BY data_venda DESC LIMIT 5");

// Obter produtos com baixo estoque
$produtosBaixoEstoque = $db->select("SELECT * FROM produtos WHERE estoque <= 10 ORDER BY estoque ASC LIMIT 5");
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-dashboard border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Categorias</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalCategorias; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <a href="categorias/index.php" class="text-decoration-none">Ver detalhes <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-dashboard border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Produtos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalProdutos; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tshirt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <a href="produtos/index.php" class="text-decoration-none">Ver detalhes <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-dashboard border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Vendas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalVendas; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <a href="vendas/index.php" class="text-decoration-none">Ver detalhes <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Vendas Recentes</h6>
                </div>
                <div class="card-body">
                    <?php if (empty($vendasRecentes)): ?>
                        <p class="text-center">Nenhuma venda registrada.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Valor</th>
                                        <th>Data</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($vendasRecentes as $venda): ?>
                                    <tr>
                                        <td><?php echo $venda['id']; ?></td>
                                        <td><?php echo $venda['nome_cliente']; ?></td>
                                        <td><?php echo formatPrice($venda['valor_total']); ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($venda['data_venda'])); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $venda['status'] == 'Concluída' ? 'success' : 'warning'; ?>">
                                                <?php echo $venda['status']; ?>
                                            </span>
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

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">Produtos com Baixo Estoque</h6>
                </div>
                <div class="card-body">
                    <?php if (empty($produtosBaixoEstoque)): ?>
                        <p class="text-center">Todos os produtos têm estoque suficiente.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th>Preço</th>
                                        <th>Estoque</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produtosBaixoEstoque as $produto): ?>
                                    <tr>
                                        <td><?php echo $produto['nome']; ?></td>
                                        <td><?php echo formatPrice($produto['preco']); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $produto['estoque'] <= 5 ? 'danger' : 'warning'; ?>">
                                                <?php echo $produto['estoque']; ?> unidades
                                            </span>
                                        </td>
                                        <td>
                                            <a href="produtos/editar.php?id=<?php echo $produto['id']; ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
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
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
