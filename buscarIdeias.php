<?php
require_once 'conexao.php';

if (!isset($_SESSION["usuario"])) {
  header("Location: login.html");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['buscar'])){
  $termoBusca = $_POST["termo_busca"];


  // Consulta SQL para buscar as ideias relacionadas ao termo de busca
  $sql = "SELECT * FROM perfil WHERE titulo LIKE '%$termoBusca%' OR descricao LIKE '%$termoBusca%'";
  $resultado = $conexao->query($sql);

  if ($resultado && $resultado->num_rows > 0) {
    echo '<!DOCTYPE html>
    <html lang="pt-br">
    
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <style>
        body {
          margin: 0;
          padding: 0;
          color: #fff;
          font-family: Arial, sans-serif;
        }
    
        .feed {
          display: flex;
          flex-wrap: wrap;
          align-items: center;
          justify-content: center;
          gap: 20px;
        }
    
        .post {
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
        }
    
        .post img {
          padding: 30px;
          background-color: white;
          max-width: 50%;
          max-height: 40%;
          height: auto;
          border-radius: 5px;
          margin-bottom: 10px;
        }
    
        .post h3,
        .post p {
          margin: 0;
          color: #fff;
        }
    
        .post h3 {
          padding-bottom: 20px;
        }
    
        .modal {
          display: none;
          position: fixed;
          z-index: 9999;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          overflow: auto;
          background-color: rgba(0, 0, 0, 0.4);
        }
    
        .modal-content {
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          background-color: rgb(53, 59, 66);
          width: 80%;
          max-width: 1600px;
          margin: 30px;
          padding: 20px;
          border-radius: 8px;
          text-align: center;
        }
    
        .modal-content img {
          width: 50%;
          object-fit: contain;
          border-radius: 5px;
          margin-bottom: 10px;
        }
    
        .close {
          color: #aaa;
          float: right;
          font-size: 28px;
          font-weight: bold;
          cursor: pointer;
        }
    
        .close:hover,
        .close:focus {
          color: #fff;
          text-decoration: none;
          cursor: pointer;
        }
    
        .error {
          color: #fff;
        }
    
        .modal-button {
          color: #fff;
          border: none;
          border-radius: 5px;
          padding: 10px 20px;
          font-size: 16px;
          cursor: pointer;
        }
    
        .modal-button:hover {
          opacity: 0.8;
        }
    
        .notification-bar {
          display: none;
          position: fixed;
          bottom: 0;
          left: 50%;
          transform: translateX(-50%);
          color: #fff;
          width: 300px;
          padding: 10px;
          border-radius: 4px;
          text-align: center;
          z-index: 999;
        }
    
        .poha {
          width: 350px;
          height: 300px;
        }
    
        .teste {
          width: 100%;
          height: 100%;
        }
      </style>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
      <title>Título da Página</title>
    </head>
    
    <body class="bg-dark">
      <nav class="navbar bg-body-tertiary mb-5">
        <div class="container-fluid">
          <a class="navbar-brand">Ydea</a>
          <a href="index.php" class="btn btn-primary">Voltar</a>
        </div>
      </nav>';
    
    echo '<div class="feed">';
    
    if (mysqli_num_rows($resultado) > 0) {
        while ($row = mysqli_fetch_assoc($resultado)) {
          $img = $row['img'];
          $titulo = $row['titulo'];
          $descricao = $row['descricao'];
  
          echo '<div class="post">';
          echo '<img class="w-50" src="imagens/' . $img . '" alt="' . $titulo . '">';
          echo '<h3>' . $titulo . '</h3>';
          echo '<p>' . $descricao . '</p>';
          echo '</div>';
  
          // Modal
          echo '  <form action="favoritar.php" method="post">';
          $idIdeia = $row['idPerfil'];
          echo '  <div class="modal">';
          echo '    <div class="modal-content bg-secondary shadow border border-light-subtle">';
          echo '      <span class="close">&times;</span>';
          echo '      <img src="imagens/' . $img . '" alt="' . $titulo . '" class="poha">';
          echo '      <h3 class="text-white">' . $titulo . '</h3>';
          echo '      <p class="text-white">' . $descricao . '</p>';
          echo '      <input type="hidden" name="idIdeia" value="' . $idIdeia . '">' . $idIdeia . '</input>';
          echo '      <input type="hidden" name="idUser" value="' . $iduser . '">' . $iduser . '</input>';
          echo '      <button type="submit" name="modal-button" id="modal-button" class="modal-button btn-lock btn btn-outline-warning" onclick="showNotification()">Tenho interesse</button>';
          echo '    </div>';
          echo '  </div>';
          echo '  </form>';
        }
      } else {

        echo "<p class='error'>Nenhum dado encontrado</p>";

      }
    
    echo '</div>';
    
    echo '<div class="notification-bar">
      Você se interessou por essa ideia!
    </div>';
    
    echo '<script>
      // Abrir modal ao clicar no post
      const posts = document.querySelectorAll(\'.post\');
      const modals = document.querySelectorAll(\'.modal\');
      const closeModalButtons = document.querySelectorAll(\'.close\');
      const modalButtons = document.querySelectorAll(\'.modal-button\');
      const notification = document.createElement(\'div\'); // Criar um elemento div para a notificação
      notification.style.position = \'fixed\'; // Posicionar a notificação no canto superior direito da tela
      notification.style.right = \'10px\';
      notification.style.top = \'10px\';
      notification.style.backgroundColor = \'green\'; // Dar uma cor de fundo verde para a notificação
      notification.style.color = \'white\'; // Dar uma cor de texto branca para a notificação
      notification.style.padding = \'10px\'; // Dar um espaçamento interno para a notificação
      notification.style.borderRadius = \'5px\'; // Arredondar as bordas da notificação
      notification.style.display = \'none\'; // Esconder a notificação inicialmente
      notification.innerText = \'Interesse registrado!\'; // Definir o texto da notificação
      document.body.appendChild(notification); // Adicionar a notificação ao corpo do documento
    
      posts.forEach((post, index) => {
        post.addEventListener(\'click\', () => {
          modals[index].style.display = \'block\';
        });
      });
    
      // Fechar modal ao clicar no botão de fechar
      closeModalButtons.forEach((button, index) => {
        button.addEventListener(\'click\', () => {
          modals[index].style.display = \'none\';
        });
      });
    
      // Mostrar notificação ao clicar no botão de interesse
      modalButtons.forEach((button, index) => {
        button.addEventListener(\'click\', () => {
          modals[index].style.display = \'none\';
          notification.style.display = \'block\';
          setTimeout(() => {
            notification.style.display = \'none\';
          }, 3000);
        });
      });
    </script>';
    
    echo '</body>
    </html>';
  } else {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>
    <body>
        <body class="bg-dark">
            <nav class="navbar bg-body-tertiary mb-5">
              <div class="container-fluid">
                <a class="navbar-brand">Ydea</a>
                <a href="index.php" class="btn btn-primary">Voltar</a>
              </div>
            </nav>
        <div class="w-100 h-100 bd-dark d-flex justify-content-center align-items-center">
            <h1 class="text-light">Nenhum resultado encontrado</h1>
    
        </div>
    </body>
    </html>';
  }
}
}
