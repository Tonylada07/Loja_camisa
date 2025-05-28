// Funções para o painel administrativo

// Confirmar exclusão
function confirmDelete(message) {
    return confirm(message || 'Tem certeza que deseja excluir este item?');
}

// Pré-visualização de imagem
function previewImage(input, previewElement) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById(previewElement).src = e.target.result;
            document.getElementById(previewElement).style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
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
    
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
