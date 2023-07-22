<?php
include_once("conexao.php");

// Verificar se o usuário está logado


// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";
    $resultado = $conexao->query($sql);

    if ($resultado->num_rows > 0) {
        $_SESSION["usuario"] = $email;
        header("Location: perfil.php");
        exit;
    } else {
        $_SESSION["erro"] = "Usuário não cadastrado";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="login.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
  <script src="validacao.js"></script>
  <script src="mascara.js"></script>
  <script src="vericacaoSenha.js"></script>
  <script>
  </script>
</head>
<body>
  <div class="container">
    <h1>Login</h1>
    <?php if(isset($_SESSION["erro"])): ?>
      <p class="error"><?php echo $_SESSION["erro"]; ?></p>
      <?php unset($_SESSION["erro"]); ?>
    <?php endif; ?>
    <form class="formulario" id="login-form" action="" method="post">
    </form>
    <a href="cadastro.html" class="btn btn-primary">Ir para Cadastrado</a>
    <a href="login.html" class="btn btn-primary mt-3">Já tenho uma conta</a>
  </div>
</body>
</html>
