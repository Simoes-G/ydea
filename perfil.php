<?php

include_once("conexao.php");


// Dados do usuário logado
$usuario = $_SESSION["usuario"];

$sql = "SELECT * FROM usuario WHERE email = '$usuario'";

$resultUsuario = $conexao->query($sql);
if ($resultUsuario->num_rows > 0) {
  $dadosUsuario = $resultUsuario->fetch_assoc();
  $nome = $dadosUsuario["nome"];
  $email = $dadosUsuario["email"];
  $iduser = $dadosUsuario["idUsuario"];
}

// Variáveis para os dados do usuário
$nome = "";
$email = "";
$telefone = "";
$erro = "";

// Verificar se o formulário de atualização foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obter os dados enviados pelo formulário
  $nome = $_POST["nome"];
  $email = $_POST["email"];
  $telefone = $_POST["telefone"];

  // Verificar se o email já existe no banco de dados
  $sql = "SELECT * FROM usuario WHERE email = '$email' AND email != '$usuario'";
  $resultado = $conexao->query($sql);

  if ($resultado->num_rows > 0) {
    // Email já existe, exibir mensagem de erro
    $erro = "O email fornecido já está em uso. Por favor, escolha outro email.";
  } else {
    // Atualizar os dados no banco de dados
    $sql = "UPDATE usuario SET nome = '$nome', email = '$email', telefone = '$telefone' WHERE email = '$usuario'";
    print_r($sql);
    $resultado = $conexao->query($sql);

    if ($resultado) {
      // Atualização bem-sucedida, redirecionar para a página de perfil
      header("Location: perfil.php");
      exit;
    } else {
      // Erro ao atualizar, exibir mensagem de erro
      $erro = "Erro ao atualizar os dados. Tente novamente.";
    }
  }
} else {
  // Consulta para obter os dados do usuário
  $sql = "SELECT * FROM usuario WHERE email = '$usuario'";
  $resultado = $conexao->query($sql);

  if ($resultado->num_rows > 0) {
    // Obter os dados do usuário
    $dadosUsuario = $resultado->fetch_assoc();
    $nome = $dadosUsuario["nome"];
    $email = $dadosUsuario["email"];
    $telefone = $dadosUsuario["telefone"];
  } else {
    // Usuário não encontrado, redirecionar para a página de login
    header("Location: login.html");
    exit;
  }
}

// Consulta para obter as ideias favoritadas pelo usuário
$sqlIdeiasFavoritadas = "SELECT * FROM favoritos WHERE usuario_id = '$iduser'";
$resultadoIdeiasFavoritadas = $conexao->query($sqlIdeiasFavoritadas);

$ideiasFavoritadas = array();
if ($resultadoIdeiasFavoritadas->num_rows > 0) {
  while ($row = $resultadoIdeiasFavoritadas->fetch_assoc()) {
    $ideiaId = $row['ideia_id'];
    // Consulta para obter os dados da ideia favoritada
    $sqlIdeia = "SELECT * FROM perfil WHERE idPerfil = '$ideiaId'";
    $resultadoIdeia = $conexao->query($sqlIdeia);
    if ($resultadoIdeia->num_rows > 0) {
      $ideia = $resultadoIdeia->fetch_assoc();
      $ideiasFavoritadas[] = $ideia;
    }
  }
}
// checar o numero do owner da ideia

?>

<!DOCTYPE html>
<html>

<head>
  <title>Perfil do Usuário</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #36393f;
      color: #fff;
      font-family: Arial, sans-serif;
    }

    .container {
      max-width: 700px;
      margin: 50px auto;
      padding: 50px;
      background-color: #535b66;
      border-radius: 10px;
      border: solid 3px #6e6e6e;
      text-align: center;
    }

    h1 {
      font-size: 24px;
      margin-bottom: 20px;
    }

    p {
      margin-bottom: 10px;
    }

    .btn-primary {
      background-color: #7289da;
      border: none;
      border-radius: 4px;
      color: #fff;
      cursor: pointer;
      font-size: 16px;
      padding: 10px 20px;
      margin-top: 20px;
    }

    .btn-primary:hover {
      background-color: #677bc4;
    }

    .form-group {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 10px;
    }

    .form-group label {
      width: 100px;
      text-align: right;
    }

    .form-group input {
      flex: 1;
    }

    .error-message {
      color: #ff0000;
      margin-top: 10px;
    }

    .favorite-ideas {
      margin-top: 30px;
    }

    .favorite-ideas .post {
      display: flex;
      flex-direction: column;
      justify-content: space-around;
      align-items: center;
      width: 500px;
      height: 500px;
      border-radius: 8px;
      background-color: rgb(53, 59, 66);
      padding: 15px;
      text-align: center;
      cursor: pointer;
      margin-bottom: 20px;
    }

    .favorite-ideas .post img {
      padding: 30px;
      background-color: white;
      max-width: 50%;
      max-height: 40%;
      height: auto;
      border-radius: 5px;
      margin-bottom: 10px;
    }

    .favorite-ideas .post h3,
    .favorite-ideas .post p {
      margin: 0;
      color: #fff;
    }

    .favorite-ideas .post h3 {
      padding-bottom: 20px;
    }
  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body class="bg-dark">
  <div class="container">
    <h1>Perfil do Usuário</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="form-group">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" class="form-control" value="<?php echo $nome; ?>" required>
      </div>
      <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
      </div>
      <div class="form-group">
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" class="form-control" value="<?php echo $telefone; ?>" required>
      </div>
      <button type="submit" class="btn btn-primary">Salvar</button>
      <div class="error-message"><?php echo $erro; ?></div>
      <hr>
    </form>
    <h2>Ideias Favoritadas</h2>
    <div class="favorite-ideas d-flex justify-content-center align-items-center gap-5 flex-wrap">
      <?php
      if (!empty($ideiasFavoritadas)) {
        foreach ($ideiasFavoritadas as $ideia) {
          echo '<div class="post" data-toggle="modal" data-target="#modal-' . $ideia['idPerfil'] . '">';
          echo '<img class="w-50" src="imagens/' . $ideia['img'] . '" alt="' . $ideia['titulo'] . '">';
          echo '<h3>' . $ideia['titulo'] . '</h3>';
          echo '<p>' . $ideia['descricao'] . '</p>';
          echo '</div>';

          // Modal para exibir os detalhes da ideia
          echo '<div class="modal fade" id="modal-' . $ideia['idPerfil'] . '" tabindex="-1" role="dialog" aria-labelledby="modal-' . $ideia['idPerfil'] . '-label" aria-hidden="true">';
          echo '<div class="modal-dialog modal-dialog-centered" role="document">';
          echo '<div class="modal-content">';
          echo '<div class="modal-header">';
          echo '<h5 class="modal-title" id="modal-' . $ideia['idPerfil'] . '-label">' . $ideia['titulo'] . '</h5>';
          echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
          echo '<span aria-hidden="true">&times;</span>';
          echo '</button>';
          echo '</div>';
          echo '<div class="modal-body">';
          echo '<img class="w-50" src="imagens/' . $ideia['img'] . '" alt="' . $ideia['titulo'] . '">';
          echo '<p>' . $ideia['descricao'] . '</p>';
          echo '<a target="_blank" class="btn btn-success" href="https://wa.me/55'.$telefone.'?text=Ol%C3%A1%2C%20tenho%20interesse%20em%20seu%20projeto%21">Enviar mensagem</a>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
      } else {
        echo '<p>Você não possui ideias favoritadas.</p>';
      }
      ?>
    </div>
    <a href="index.php" class="btn btn-primary">Ir para o Feed</a>
    <a href="cadastroIdeia2.php" class="btn btn-primary">Registrar ideia</a>
    <a href="minhasIdeias.php" class="btn btn-primary">Minhas ideias</a>
    <a href="logout.php" class="btn btn-primary">Sair</a>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
