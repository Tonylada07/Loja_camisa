<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';

// Verificar se os dados foram enviados
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['produto_id']) || empty($_POST['produto_id'])) {
    setMessage('Produto inválido', 'danger');
    redirect('index.php');
}

$produto_id = (int)$_POST['produto_id'];
$quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 1;

// Validar quantidade
if ($quantidade <= 0) {
    $quantidade = 1;
}

// Verificar se o produto existe e tem estoque
$produto = getProductById($produto_id);

if (!$produto) {
    setMessage('Produto não encontrado', 'danger');
    redirect('index.php');
}

// Verificar estoque
if ($produto['estoque'] <= 0) {
    setMessage('Produto fora de estoque', 'danger');
    redirect('produto.php?id=' . $produto_id);
}

// Limitar a quantidade ao estoque disponível
if ($quantidade > $produto['estoque']) {
    $quantidade = $produto['estoque'];
    setMessage('Quantidade ajustada para o estoque disponível', 'warning');
}

// Adicionar ao carrinho
if (addToCart($produto_id, $quantidade)) {
    setMessage('Produto adicionado ao carrinho', 'success');
} else {
    setMessage('Erro ao adicionar produto ao carrinho', 'danger');
}

// Redirecionar
$referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
redirect($referer);
?>
