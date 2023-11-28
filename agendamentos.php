<?php
/*
require_once './session.php';


usado para sempre verificar a sessão do usuário
require_once './session.php';

// Verificar se há uma sessão de usuário ou superusuário 
if (!(isset($_SESSION['usuario']) || isset($_SESSION['superusuario']))) { 
    // Redirecionar para a página de login 
    header("Location: index.html"); 
    exit;
}
*/
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Lista de Agendamentos</title>
    <!-- Importante deixarmos a codificação dos caracteres e o título no início de <head> para otimização e procura da página -->

    <!-- meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="robots" content="index, nofollow">
    <meta name="googlebot" content="index, nofollow">
    <meta name="googlebot" content="notranslate">
    <meta name="theme-color" content="#FFFFFF">
    <meta name="description" content="Consulta biblioteca SENAI">
    <meta name="keywords" content="SENAI, Biblioteca, agendamentos">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="author" content="SENAI">

    <!-- link tags -->
    <link rel="stylesheet" href="./config/assets/estilos/consulta.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Fira+Sans:ital,wght@1,200&family=Montserrat:wght@200&family=Source+Sans+Pro&display=swap" rel="stylesheet">
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
                    <li><a href="./menu.php">Menu</a></li>
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
    <div id="app">
        <form method="post" onsubmit="exibirAlerta(event)">

            <h1>Lista de Agendamentos</h1>
            <?php

            session_start();
            if (!isset($_SESSION['id_agendamento'])) {
            } else {
                // Exibir o ID de agendamento para o usuário
                $idAgendamento = $_SESSION['id_agendamento'];
                /*
                EXIBIR UMA MENSAGEM FORTE PARA INFORMAR O USUARIO QUE ELE DEVE SALVAR O ID DE AGENDAMENTO
                echo "<div class='alerta' id='alerta'>
                <p>OBRIGATÓRIO: ID DE AGENDAMENTO!</p>
                </div>";
                */
                echo "<div class='agendaID' id='agendaID'>
                <p>Seu ID de agendamento é: " . $idAgendamento . "</p>"
                    . "</div>";
                unset($_SESSION['id_agendamento']);
            }
            // Definir as informações de conexão
            $host = '127.0.0.1';
            $dbname = 'u683147803_biblioteca';
            $username = 'u683147803_biblioteca';
            $password = 'SenaiMg123';

            // Conectar ao banco de dados usando mysqli

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Conexão falhou" . $e->getMessage();
            }

            // buscar agendamentos no banco de dados
            $query = "SELECT * FROM agendamentos";
            $busca = $pdo->query($query);
            $agendamentos = $busca->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <table class="responsive-table">
                <thead>
                    <tr>

                        <th>Nome</th>
                        <th>Data</th>
                        <th>Hora de Início</th>
                        <th>Hora de Término</th>
                        <th>Alunos</th>
                        <th>Curso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agendamentos as $agendamento) : ?>
                        <tr>
                            <td><?php echo $agendamento['nome']; ?></td>
                            <td><?php echo $agendamento['data']; ?></td>
                            <td><?php echo $agendamento['hora_inicio']; ?></td>
                            <td><?php echo $agendamento['hora_termino']; ?></td>
                            <td><?php echo $agendamento['quantidade_alunos']; ?></td>
                            <td><?php echo $agendamento['curso']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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
    <script src="./config/assets/js/destruirSessao.js"></script>
    <footer>
        <div class="rodape">
            <p>&copy;2023 UAIBook. Todos os direitos reservados.<br>Curso de Desenvolvimento em Sistemas. Trilhas do Futuro
                II. <br>SENAI. Uberaba/MG.</p>
        </div>
    </footer>
</body>


</html>