<?php

require_once('conexao.php');
// Verificar se o usuário está logado
if (!isset($_SESSION["usuario"])) {
  header("Location: login.html");
  exit;
}

if(isset($_POST['submitIdeia'])){
    $owner = $_POST['owner'];
    $descricao = $_POST['descricao'];
    $titulo = $_POST['titulo'];
  
    echo $owner;
    //$titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
    $img = $_FILES['imagem']['name'];
    //$descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    
    if ($_FILES["imagem"]["error"] == UPLOAD_ERR_OK) {
        $destino = "imagens/" . basename($img);
        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $destino)) {
            $sql = "INSERT INTO perfil (idPerfil, img, descricao, titulo,usuario_id) VALUES (default, '$img', '$descricao', '$titulo','$owner')";
            if(mysqli_query($conexao, $sql)){
                echo "<p class='success'>Imagem cadastrado com sucesso!</p>";
                header("Location: perfil.php");
            } else {
                echo "<p class='error'>Não foi possível realizar a inclusão</p>";
            }
            
        } else {
            echo "<p class='error'>Erro ao mover a imagem para o diretório de destino</p>";
        }

    } else {
        echo "<p class='error'>Erro ao enviar a imagem</p>";
    }
}
?>
