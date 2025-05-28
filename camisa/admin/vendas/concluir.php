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

// Verificar se a venda já está concluída
if ($venda['status'] == 'Concluída') {
    setMessage('Esta venda já está marcada como concluída', 'warning');
    redirect('index.php');
}

global $db;

// Atualizar status da venda
$result = $db->update("UPDATE vendas SET status = 'Concluída' WHERE id = $id");

if ($result !== false) {
    setMessage('Venda marcada como concluída com sucesso', 'success');
} else {
    setMessage('Erro ao atualizar status da venda', 'danger');
}

redirect('index.php');
?>
