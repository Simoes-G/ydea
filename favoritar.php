<?php
require_once 'conexao.php';
// Verificar se o usuário está logado
if (!isset($_SESSION["usuario"])) {
  header("Location: login.html");
  exit;
}

$owner = $_SESSION["usuario"];
$sql = "SELECT * FROM usuario WHERE email = '$owner'";

if(isset($_POST['modal-button'])){
$iduser = $_POST['idUser'];
$idIdeia = $_POST['idIdeia'];

echo $iduser;
echo $idIdeia;
$sql = "INSERT INTO favoritos (id, usuario_id, ideia_id) VALUES (default, '$iduser', '$idIdeia')";

$result = $conexao->query($sql);

header("Location: index.php");
}


