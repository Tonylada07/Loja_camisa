<?php
require_once '../includes/header.php';

// Obter todas as categorias para o select
$categorias = getCategories();

// Processar o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $preco = $_POST['preco'] ?? '';
    $estoque = $_POST['estoque'] ?? '';
    $categoria_id = $_POST['categoria_id'] ?? '';
    
    // Validar campos
    if (empty($nome) || empty($preco) || empty($estoque) || empty($categoria_id)) {
        setMessage('Preencha todos os campos obrigatórios', 'danger');
    } else {
        global $db;
        
        // Tratar o preço (substituir vírgula por ponto)
        $preco = str_replace(',', '.', $preco);
        
        // Validar valores numéricos
        if (!is_numeric($preco) || !is_numeric($estoque) || $preco <= 0 || $estoque < 0) {
            setMessage('Valores de preço e estoque devem ser números válidos', 'danger');
        } else {
            // Processar upload de imagem
            $imagem = '';
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['imagem']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                
                if (in_array(strtolower($ext), $allowed)) {
                    $new_filename = uniqid() . '.' . $ext;
                    $upload_dir = '../../assets/img/';
                    
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    
                    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $upload_dir . $new_filename)) {
                        $imagem = $new_filename;
                    } else {
                        setMessage('Erro ao fazer upload da imagem', 'danger');
                    }
                } else {
                    setMessage('Tipo de arquivo não permitido. Apenas JPG, JPEG, PNG e GIF são aceitos', 'danger');
                }
            }
            
            // Escapar valores
            $nome = $db->escape($nome);
            $descricao = $db->escape($descricao);
            $preco = $db->escape($preco);
            $estoque = $db->escape($estoque);
            $categoria_id = $db->escape($categoria_id);
            $imagem = $db->escape($imagem);
            
            // Inserir produto
            $sql = "INSERT INTO produtos (nome, descricao, preco, estoque, categoria_id, imagem) 
                    VALUES ('$nome', '$descricao', $preco, $estoque, $categoria_id, '$imagem')";
            
            $result = $db->insert($sql);
            
            if ($result) {
                setMessage('Produto adicionado com sucesso', 'success');
                redirect('index.php');
            } else {
                setMessage('Erro ao adicionar produto', 'danger');
            }
        }
    }
}
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">Adicionar Produto</h2>
        <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do Produto *</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="preco" class="form-label">Preço *</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="text" class="form-control" id="preco" name="preco" placeholder="0,00" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="estoque" class="form-label">Estoque *</label>
                            <input type="number" class="form-control" id="estoque" name="estoque" min="0" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="categoria_id" class="form-label">Categoria *</label>
                            <select class="form-select" id="categoria_id" name="categoria_id" required>
                                <option value="">Selecione uma categoria</option>
                                <?php foreach ($categorias as $categoria): ?>
                                <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nome']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="4"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="imagem" class="form-label">Imagem</label>
                            <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*" onchange="previewImage(this, 'imagePreview')">
                            <div class="mt-2">
                                <img id="imagePreview" src="#" alt="Preview" style="max-width: 100%; max-height: 200px; display: none;">
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Salvar
                </button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
