<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Destruir a sessão
session_destroy();

// Redirecionar para a página de login
redirect('login.php');
?>
