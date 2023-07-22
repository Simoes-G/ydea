<?php
session_start();

    $host  = 'localhost';
    $user  = 'root';
    $senha = '';
    $banco = 'pi';

    // Conecta ao banco de dados
    $conexao = new mysqli($host, $user, $senha, $banco);

    
?>
