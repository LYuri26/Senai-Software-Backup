<?php
include_once './session.php';

/*
if (!(isset($_SESSION['usuario']) || isset($_SESSION['superusuario']))) {
  header("Location: index.html"); 
  exit;
}
if ((isset($_SESSION['usuario']) || isset($_SESSION['superusuario']))) {
  header("Location: menu.php"); 
  exit;
}
/* INCLUDE ONCE SERVE PARA INCLUIR O ARQUIVO APENAS UMA VEZ, OU SEJA, SE O ARQUIVO JÁ FOI INCLUÍDO ANTES, ELE NÃO SERÁ INCLUÍDO NOVAMENTE.
require_once './session.php';


/* TAMBÉM NÃO É NECESSÁRIO NESTE CASO 
Verificar se há uma sessão de usuário ou superusuário 
if (!(isset($_SESSION['usuario']) || isset($_SESSION['superusuario']))) { 
    // Redirecionar para a página de login 
    header("Location: index.html"); 
    exit;
}

$_SESSION['user_id'] = $usuario['id']; // Armazena o ID do usuário na sessão
$_SESSION['privilegios'] = $usuario['privilegios']; // Armazena os privilégios do usuário na sessão

Definir a mensagem na variável de sessão
$_SESSION['login_message'] = 'Para cancelar um agendamento, por favor, faça login novamente!';*/

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Menu</title>
  <!-- Importante deixarmos a codificação dos caracteres e o título no início de <head> para otimização e procura da página -->

  <!-- meta tags -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="robots" content="index, nofollow">
  <meta name="googlebot" content="index, nofollow">
  <meta name="googlebot" content="notranslate">
  <meta name="theme-color" content="#FFFFFF">
  <meta name="description" content="Menu biblioteca SENAI">
  <meta name="keywords" content="SENAI, Biblioteca, menu">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="author" content="SENAI">

  <!-- link tags -->
  <link rel="stylesheet" href="./config/assets/estilos/menu.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="icon" href="./config/assets/img/senai.ico" type="image/x-icon">
</head>

<body>
  <header>
    <nav class="navbar">
      <div class="navbar-container">
        <div class="navbar-logo">
          <a href="./menu.php">
            <img src="./config/assets/img/senailogo2.png" class="logo" href="./menu.php">
        </div>
        <a href="#" id="menu-icon">
          <i class="fas fa-bars fa-2x"></i>
        </a>
        <ul class="navbar-menu" id="menu-list">
          <li><a href="./agendar.php">Agendar</a></li>
          <li><a href="./cancelar.php">Cancelar</a></li>
          <li><a href="./cancelamentos.php">Cancelamentos</a></li>
          <li><a href="./agendamentos.php">Agendamentos</a></li>
          <li><a href="./sobre.html">Sobre</a></li>
          <li><a href="https://docs.google.com/forms/d/1EMKHJaqvL2lA1U9gmPW-AQwqyvDS0fgdP-ckh85ECwo/edit" target="_blank">Feedback</a></li>
          <li class="botaosair"><a id="botaosair" href="./logout.php">Sair</a></li>
        </ul>
      </div>

      <!-- <div class="navbar-toggle">
        <span class="navbar-toggle-icon"></span>
      </div>
      </div>-->
    </nav>
  </header>
  <div class="titulo">
    <h1>Bem-vindo ao UAIBook!</h1>
  </div>
  <div class="container" id="slider">
    <div class="imgscar" id="slider">
      <div class="slide" role="rolebox" id="slider">
        <img src="./config/assets/img/senailogo1.png" alt="Logo Senai" class="selected" id="logosenai">
        <img src="./config/assets/img/Biblioteca.jpg" alt="Logo Biblioteca" class="logobib" id="biblioteca">
        <!--<img src="/config/assets/img/img2.png" alt="imagem2" class="IMG.2">-->
      </div>
    </div>

  </div>
  <div id="conteudo">
    <p>O UAIBook é a melhor ferramenta que você, aluno, pode escolher para obter facilidade e bem-estar ao realizar a reserva de um horário na biblioteca. Com o UAIBook, agendar o horário desejado na biblioteca nunca foi tão fácil e livre de complicações. Desfrute de uma experiência tranquila e eficiente ao realizar suas reservas sem preocupações.</p>
    <p>Nosso objetivo é proporcionar a melhor experiência possível para aqueles que buscam um futuro brilhante através da utilização desse espaço valioso. O site foi desenvolvido com carinho e dedicação pelos talentosos alunos da turma de Desenvolvimento de Sistemas.</p>
  </div>

  <script>
    $(document).ready(function() {
      // Define a função toggleDropdown
      function toggleDropdown() {
        $("#menu-list").slideToggle(); // Mostra ou oculta a lista suspensa
      }

      // Adiciona um evento de clique ao elemento com o id "menu-icon"
      $("#menu-icon").click(toggleDropdown);

      // Adiciona um evento de redimensionamento ao documento
      $(window).on("resize", function() {
        // Verifica se a largura da janela é maior que 768 pixels
        if ($(window).width() > 768) {
          // Mostra a lista suspensa
          $("#menu-list").show();
        } else {
          // Oculta a lista suspensa
          $("#menu-list").hide();
        }
      });
    });
    // Obtenha o botão do menu e o elemento navbar
    const menuBtn = document.getElementById('menu-icon');
    const navbar = document.querySelector('.navbar');

    // Manipule o evento de clique do botão
    menuBtn.addEventListener('click', function() {
      // Adicione a classe "rounded" ao elemento navbar
      navbar.classList.remove('rounded');
    });

    /*
    document.addEventListener("DOMContentLoaded", function() {
      var menuIcon = document.getElementById("menu-icon");
      var menuList = document.getElementById("menu-list");

      menuIcon.addEventListener("click", function() {
        if (menuList.style.display === "none" || menuList.style.display === "") {
          menuList.style.display = "block";
        } else {
          menuList.style.display = "none";
        }
      });
    });*/
  </script>

  <!-- <script src="./config/assets/js/destruirSessao.js"></script> -->
  <script src="./config/assets/js/destruirSessao.js"></script>
  <script src="./config/assets/js/menu.js"></script>
</body>

<footer>
  <div class="rodape">
    <p>&copy;2023 UAIBook. Todos os direitos reservados.<br>Curso de Desenvolvimento em Sistemas. Trilhas do Futuro
      II. <br>SENAI. Uberaba/MG.</p>
  </div>
</footer>

</html>