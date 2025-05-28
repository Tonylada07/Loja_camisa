// Funções para o site da loja

// Atualizar quantidade no carrinho
function updateCartQuantity(productId, action) {
    const quantityInput = document.getElementById('quantity-' + productId);
    let quantity = parseInt(quantityInput.value);
    
    if (action === 'increase') {
        quantity++;
    } else if (action === 'decrease' && quantity > 1) {
        quantity--;
    }
    
    quantityInput.value = quantity;
    
    // Atualizar formulário
    document.getElementById('update-form-' + productId).submit();
}

// Adicionar ao carrinho com animação
function addToCartWithAnimation(button) {
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-check"></i> Adicionado';
    
    setTimeout(function() {
        button.disabled = false;
        button.innerHTML = '<i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho';
    }, 2000);
}

// Validar formulário de checkout
function validateCheckoutForm() {
    const nome = document.getElementById('nome').value;
    const email = document.getElementById('email').value;
    const telefone = document.getElementById('telefone').value;
    const endereco = document.getElementById('endereco').value;
    
    if (!nome || !email || !telefone || !endereco) {
        alert('Por favor, preencha todos os campos obrigatórios.');
        return false;
    }
    
    // Validação básica de email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Por favor, insira um endereço de email válido.');
        return false;
    }
    
    return true;
}

// Inicialização quando o documento está pronto
document.addEventListener('DOMContentLoaded', function() {
    // Fechar alertas automaticamente após 5 segundos
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
