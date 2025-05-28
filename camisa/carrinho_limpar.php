<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';

// Limpar o carrinho
clearCart();

// Redirecionar
setMessage('Carrinho limpo com sucesso', 'success');
redirect('carrinho.php');
?>
