<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

// Verificar se o usuário já está logado
if (isLoggedIn()) {
    redirect('index.php');
}

// Processar o formulário de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    // Validar campos
    if (empty($email) || empty($senha)) {
        setMessage('Preencha todos os campos', 'danger');
    } else {
        global $db;
        
        // Buscar usuário pelo email
        $email = $db->escape($email);
        $usuario = $db->select("SELECT * FROM usuarios WHERE email = '$email'");
        
        if (!empty($usuario)) {
            $usuario = $usuario[0];
            
            // Verificar senha

            if (password_verify($senha, $usuario['senha'])) {
                // Login bem-sucedido
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['user_nome'] = $usuario['nome'];
                $_SESSION['user_email'] = $usuario['email'];
                
                setMessage('Login realizado com sucesso', 'success');
                redirect('index.php');
            } else {
                setMessage('Email ou senha incorretos', 'danger');
            }
        } else {
            setMessage('Email ou senha incorretos', 'danger');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Painel Administrativo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="login-container">
            <div class="login-logo">
                <h1>Camisas de Times</h1>
                <p class="text-muted">Painel Administrativo</p>
            </div>
            
            <?php
            $message = getMessage();
            if ($message): 
            ?>
            <div class="alert alert-<?php echo $message['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $message['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="" class="login-form">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>
                </div>
            </div>
            
            <div class="mt-3 text-center">
                <a href="../index.php" class="text-decoration-none">
                    <i class="fas fa-arrow-left me-1"></i> Voltar para a loja
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
