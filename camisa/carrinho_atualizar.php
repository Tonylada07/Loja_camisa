<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';

// Verificar se os dados foram enviados
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['produto_id']) || empty($_POST['produto_id'])) {
    setMessage('Produto inválido', 'danger');
    redirect('carrinho.php');
}

$produto_id = (int)$_POST['produto_id'];
$quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 1;

// Validar quantidade
if ($quantidade <= 0) {
    // Se a quantidade for zero ou negativa, remover o item
    if (removeFromCart($produto_id)) {
        setMessage('Item removido do carrinho', 'success');
    } else {
        setMessage('Erro ao remover item do carrinho', 'danger');
    }
} else {
    // Verificar se o produto existe e tem estoque
    $produto = getProductById($produto_id);
    
    if (!$produto) {
        setMessage('Produto não encontrado', 'danger');
        redirect('carrinho.php');
    }
    
    // Limitar a quantidade ao estoque disponível
    if ($quantidade > $produto['estoque']) {
        $quantidade = $produto['estoque'];
        setMessage('Quantidade ajustada para o estoque disponível', 'warning');
    }
    
    // Atualizar quantidade
    if (updateCartQuantity($produto_id, $quantidade)) {
        setMessage('Carrinho atualizado com sucesso', 'success');
    } else {
        setMessage('Erro ao atualizar carrinho', 'danger');
    }
}

// Redirecionar
redirect('carrinho.php');
?>
