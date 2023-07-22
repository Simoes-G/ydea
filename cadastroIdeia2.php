<?php  

require_once 'conexao.php';
// Verificar se o usuário está logado
if (!isset($_SESSION["usuario"])) {
  header("Location: login.html");
  exit;
}

$owner = $_SESSION["usuario"];
$sql = "SELECT * FROM usuario WHERE email = '$owner'";

$result = $conexao->query($sql);
if ($result->num_rows > 0) {
    $dadosUsuario = $result->fetch_assoc();
    $nome = $dadosUsuario["nome"];
    $email = $dadosUsuario["email"];
    $iduser = $dadosUsuario["idUsuario"];
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #36393f;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            margin: 0 auto;
            text-align: center;
            color: #fff;
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            width: 400px;
            background-color: #202225;
            border-radius: 4px;
            padding: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="file"],
        textarea {
            display: block;
            background-color: #36393f;
            margin-bottom: 10px;
            border: none;
            border-radius: 4px;
            color: #fff;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        button[type="submit"] {
            background-color: #7289da;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            padding: 10px 20px;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #677bc4;
        }
        button[type="button"] {
            background-color: #7289da;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            padding: 10px 20px;
            width: 100%;
        }

        button[type="button"]:hover {
            background-color: #677bc4;
        }
        a {
            outline: none;
            text-decoration: none;
            color: white;
        }
    </style>
    <title>Título da Página</title>
</head>
<body>
    <form action="cadastroIdeia.php" method="post" enctype="multipart/form-data">

        <h1>Cadastro de Imagens e Ideias</h1>

        <div class="">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
        </div>

        <div class="">
            <label for="imagem">Imagem:</label>
            <input type='file' accept='.jpg, .jpeg, .gif, .png, .webp' id='imagem' name='imagem' required />
        </div>

        <div class="">
            <label for="descricao">Defina sua ideia em algumas palavras:</label>
            <textarea id="descricao" name="descricao"></textarea>
        </div>
        <select name="owner" id="owner" >
            <option value="<?php echo $iduser ?>"><h3>Dono da ideia: <?php echo $nome ?></h3></option>
        </select>
        <!-- <input type="input" disabled name="owner" id="owner" value=""> -->

        <button type='submit' name='submitIdeia'>Cadastrar</button> 
        <button type='button' name='bottons'><a href="perfil.php">Voltar para o Perfil</a></button> 
        <button type='button' name='bottons'><a href="index.php">Voltar para o Feed</a></button> 
        <?php ?>
    </form> 
    
</body>
</html>
