<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';

// Verificar se o ID foi fornecido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    setMessage('Produto inválido', 'danger');
    redirect('carrinho.php');
}

$produto_id = (int)$_GET['id'];

// Remover item do carrinho
if (removeFromCart($produto_id)) {
    setMessage('Item removido do carrinho', 'success');
} else {
    setMessage('Erro ao remover item do carrinho', 'danger');
}

// Redirecionar
redirect('carrinho.php');
?>
