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

global $db;

// Excluir categoria (a exclusão em cascata dos produtos relacionados é feita pelo banco de dados)
$result = $db->delete("DELETE FROM categorias WHERE id = $id");

if ($result !== false) {
    setMessage('Categoria excluída com sucesso', 'success');
} else {
    setMessage('Erro ao excluir categoria', 'danger');
}

redirect('index.php');
?>
