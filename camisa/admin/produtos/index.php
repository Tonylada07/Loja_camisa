<?php
require_once '../includes/header.php';

// Obter todos os produtos
$produtos = getProducts();
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">Gerenciar Produtos</h2>
        <a href="adicionar.php" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Novo Produto
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if (empty($produtos)): ?>
                <p class="text-center py-3">Nenhum produto cadastrado.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="10%">Imagem</th>
                                <th>Nome</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Categoria</th>
                                <th width="15%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtos as $produto): ?>
                            <tr>
                                <td><?php echo $produto['id']; ?></td>
                                <td>
                                    <?php if (!empty($produto['imagem'])): ?>
                                        <img src="../assets/img/<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>" class="product-image">
                                    <?php else: ?>
                                        <img src="../assets/img/no-image.jpg" alt="Sem imagem" class="product-image">
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $produto['nome']; ?></td>
                                <td><?php echo formatPrice($produto['preco']); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $produto['estoque'] <= 5 ? 'danger' : ($produto['estoque'] <= 10 ? 'warning' : 'success'); ?>">
                                        <?php echo $produto['estoque']; ?> unidades
                                    </span>
                                </td>
                                <td><?php echo $produto['categoria']; ?></td>
                                <td>
                                    <a href="editar.php?id=<?php echo $produto['id']; ?>" class="btn btn-sm btn-primary btn-action" data-bs-toggle="tooltip" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="excluir.php?id=<?php echo $produto['id']; ?>" class="btn btn-sm btn-danger btn-action" data-bs-toggle="tooltip" title="Excluir" onclick="return confirmDelete('Tem certeza que deseja excluir este produto?')">
                                        <i class="fas fa-trash"></i>
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

<?php require_once '../includes/footer.php'; ?>
