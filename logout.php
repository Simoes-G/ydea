<?php

session_start();
// Verificar se o usuário está logado


// Limpar todas as variáveis de sessão
$_SESSION = array();

// Encerrar a sessão
session_destroy();

// Redirecionar para a página de login, por exemplo
header("Location: login.php");
exit;
?>