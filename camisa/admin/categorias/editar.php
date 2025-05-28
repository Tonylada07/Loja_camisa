<?php
require_once '../includes/header.php';

// Verificar se o ID foi fornecido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    setMessage('ID da categoria não fornecido', 'danger');
    redirect('index.php');
}

$id = (int)$_GET['id'];
$categoria = getCategoryById($id);

// Verificar se a categoria existe
if (!$categoria) {
    setMessage('Categoria não encontrada', 'danger');
    redirect('index.php');
}

// Processar o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    
    // Validar campos
    if (empty($nome)) {
        setMessage('Preencha o nome da categoria', 'danger');
    } else {
        global $db;
        
        // Verificar se já existe outra categoria com este nome
        $nome_escaped = $db->escape($nome);
        $categoria_existente = $db->select("SELECT * FROM categorias WHERE nome = '$nome_escaped' AND id != $id");
        
        if (!empty($categoria_existente)) {
            setMessage('Já existe outra categoria com este nome', 'danger');
        } else {
            // Atualizar categoria
            $result = $db->update("UPDATE categorias SET nome = '$nome_escaped' WHERE id = $id");
            
            if ($result !== false) {
                setMessage('Categoria atualizada com sucesso', 'success');
                redirect('index.php');
            } else {
                setMessage('Erro ao atualizar categoria', 'danger');
            }
        }
    }
}
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">Editar Categoria</h2>
        <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome da Categoria</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $categoria['nome']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Salvar Alterações
                </button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
