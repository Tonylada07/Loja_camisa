<?php
require_once '../includes/header.php';

// Verificar se o ID foi fornecido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    setMessage('ID do produto não fornecido', 'danger');
    redirect('index.php');
}

$id = (int)$_GET['id'];
$produto = getProductById($id);

// Verificar se o produto existe
if (!$produto) {
    setMessage('Produto não encontrado', 'danger');
    redirect('index.php');
}

global $db;

// Excluir produto
$result = $db->delete("DELETE FROM produtos WHERE id = $id");

if ($result !== false) {
    // Remover imagem se existir
    if (!empty($produto['imagem'])) {
        $imagem_path = '../../assets/img/' . $produto['imagem'];
        if (file_exists($imagem_path)) {
            unlink($imagem_path);
        }
    }
    
    setMessage('Produto excluído com sucesso', 'success');
} else {
    setMessage('Erro ao excluir produto', 'danger');
}

redirect('index.php');
?>
