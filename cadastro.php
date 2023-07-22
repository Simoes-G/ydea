<?php
include_once('conexao.php');
// Verificar se o usuário está logado
if (!isset($_SESSION["usuario"])) {
  header("Location: login.html");
  exit;
}

if(isset($_POST['submitCadastro'])){

    
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $confirmaSenha = $_POST['confirmaSenha'];

    if($senha != $confirmaSenha) {
        echo "As senhas não coincidem.";
        exit;
    }

    $sql = "INSERT INTO usuario (idUsuario,nome,email,senha,telefone) VALUES(default,'$nome','$email','$senha','$telefone')";

    if($conexao->query($sql) == true){
        header("Location: login.php");
    } else {
        echo "Não foi possível realizar a inclusão";
    } 
}
?>