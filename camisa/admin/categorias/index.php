<?php
require_once '../includes/header.php';

// Obter todas as categorias
$categorias = getCategories();
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">Gerenciar Categorias</h2>
        <a href="adicionar.php" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Nova Categoria
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if (empty($categorias)): ?>
                <p class="text-center py-3">Nenhuma categoria cadastrada.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Nome</th>
                                <th>Data de Criação</th>
                                <th width="15%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categorias as $categoria): ?>
                            <tr>
                                <td><?php echo $categoria['id']; ?></td>
                                <td><?php echo $categoria['nome']; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($categoria['created_at'])); ?></td>
                                <td>
                                    <a href="editar.php?id=<?php echo $categoria['id']; ?>" class="btn btn-sm btn-primary btn-action" data-bs-toggle="tooltip" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="excluir.php?id=<?php echo $categoria['id']; ?>" class="btn btn-sm btn-danger btn-action" data-bs-toggle="tooltip" title="Excluir" onclick="return confirmDelete('Tem certeza que deseja excluir esta categoria? Todos os produtos relacionados também serão excluídos.')">
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
