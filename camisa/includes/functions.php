<?php
require_once 'database.php';

// Função para verificar se o usuário está logado
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Função para redirecionar
function redirect($url) {
    header("Location: $url");
    exit;
}

// Função para exibir mensagem de alerta
function setMessage($message, $type = 'success') {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
}

// Função para obter mensagem
function getMessage() {
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $type = $_SESSION['message_type'];
        
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        
        return ['message' => $message, 'type' => $type];
    }
    
    return null;
}

// Função para formatar preço
function formatPrice($price) {
    return 'R$ ' . number_format($price, 2, ',', '.');
}

// Função para obter itens do carrinho
function getCartItems() {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    return $_SESSION['cart'];
}

// Função para adicionar item ao carrinho
function addToCart($product_id, $quantity = 1) {
    global $db;
    
    // Verifica se o produto existe
    $product = $db->select("SELECT * FROM produtos WHERE id = $product_id");
    
    if (empty($product)) {
        return false;
    }
    
    $product = $product[0];
    
    // Inicializa o carrinho se não existir
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Verifica se o produto já está no carrinho
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'id' => $product['id'],
            'nome' => $product['nome'],
            'preco' => $product['preco'],
            'imagem' => $product['imagem'],
            'quantity' => $quantity
        ];
    }
    
    return true;
}

// Função para remover item do carrinho
function removeFromCart($product_id) {
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        return true;
    }
    
    return false;
}

// Função para atualizar quantidade no carrinho
function updateCartQuantity($product_id, $quantity) {
    if (isset($_SESSION['cart'][$product_id])) {
        if ($quantity <= 0) {
            return removeFromCart($product_id);
        }
        
        $_SESSION['cart'][$product_id]['quantity'] = $quantity;
        return true;
    }
    
    return false;
}

// Função para calcular o total do carrinho
function getCartTotal() {
    $total = 0;
    
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['preco'] * $item['quantity'];
        }
    }
    
    return $total;
}

// Função para limpar o carrinho
function clearCart() {
    $_SESSION['cart'] = [];
}

// Função para obter categorias
function getCategories() {
    global $db;
    return $db->select("SELECT * FROM categorias ORDER BY nome");
}

// Função para obter produtos
function getProducts($category_id = null) {
    global $db;
    
    $sql = "SELECT p.*, c.nome as categoria FROM produtos p 
            INNER JOIN categorias c ON p.categoria_id = c.id";
    
    if ($category_id) {
        $sql .= " WHERE p.categoria_id = $category_id";
    }
    
    $sql .= " ORDER BY p.nome";
    
    return $db->select($sql);
}

// Função para obter um produto pelo ID
function getProductById($id) {
    global $db;
    
    $id = $db->escape($id);
    $result = $db->select("SELECT p.*, c.nome as categoria FROM produtos p 
                          INNER JOIN categorias c ON p.categoria_id = c.id 
                          WHERE p.id = $id");
    
    return !empty($result) ? $result[0] : null;
}

// Função para obter uma categoria pelo ID
function getCategoryById($id) {
    global $db;
    
    $id = $db->escape($id);
    $result = $db->select("SELECT * FROM categorias WHERE id = $id");
    
    return !empty($result) ? $result[0] : null;
}

// Função para obter vendas
function getSales() {
    global $db;
    return $db->select("SELECT * FROM vendas ORDER BY data_venda DESC");
}

// Função para obter uma venda pelo ID
function getSaleById($id) {
    global $db;
    
    $id = $db->escape($id);
    $sale = $db->select("SELECT * FROM vendas WHERE id = $id");
    
    if (empty($sale)) {
        return null;
    }
    
    $sale = $sale[0];
    $sale['itens'] = $db->select("SELECT vi.*, p.nome, p.imagem FROM vendas_itens vi 
                                 INNER JOIN produtos p ON vi.produto_id = p.id 
                                 WHERE vi.venda_id = $id");
    
    return $sale;
}
?>
