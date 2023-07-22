<?php
require_once('conexao.php');

// Verificar se o usuário está logado
if (!isset($_SESSION["usuario"])) {
    header("Location: login.html");
    exit;
}

// Processar o salvamento
if (isset($_POST['salvar'])) {
    $titulos = $_POST['titulo'];
    $descricoes = $_POST['descricao'];
    $idIdeias = $_POST['idIdeia'];

    // Iterar sobre os arrays dos campos enviados
    foreach ($idIdeias as $index => $idIdeia) {
        $titulo = $titulos[$index];
        $descricao = $descricoes[$index];

        $sql = "UPDATE perfil SET descricao = '$descricao', titulo = '$titulo' WHERE perfil.idPerfil = '$idIdeia'";

        $result = $conexao->query($sql);
    }

    // Redirecionar para a página desejada após o salvamento
    header("Location: minhasIdeias.php");
    exit;
}

// Processar a deleção
if (isset($_POST['deletar'])) {
    $titulos = $_POST['titulo'];
    $descricoes = $_POST['descricao'];
    $idIdeiass = $_POST['idIdeia'];

    // Iterar sobre os arrays dos campos enviados
    foreach ($idIdeiass as $index => $idIdeia) {
        $titulo = $titulos[$index];
        $descricao = $descricoes[$index];

        $sql = "DELETE FROM perfil WHERE perfil.idPerfil = '$idIdeia'";

        $result = $conexao->query($sql);
    }

    // Redirecionar para a página desejada após a deleção
    header("Location: minhasIdeias.php");
    exit;
}
?>
