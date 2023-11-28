<?php
require_once './session.php';

//require_once './session.php';

// ! IMPORTANTE !
// ! IMPORTANTE !

// ABAIXO SEGUE O SCRIPT QUE SOMENTE AUTORIZA O ACESSO À PÁGINA SE O USUÁRIO FAZER LOGIN NOVAMENTE
// DEIXAR COMENTADO POR ENQUANTO

/*// Verificar se há uma sessão de usuário ou superusuário
if (!(isset($_SESSION['usuario']) || isset($_SESSION['superusuario']))) {
    // Se a sessão não estiver ativa, exibe uma mensagem de aviso com JavaScript
    echo "<script> alert('Você precisa fazer login novamente para acessar esta página.');
    window.location.href = 'index.html?skip_message=1';
    </script>";
    exit; // Termina a execução do script
} else {
    echo " window.location.href = 'cancelar.php?skip_message=1';";
  }
*/



// ! IMPORTANTE !
// ! IMPORTANTE !
?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <title>Cancelar</title>
    <!-- Importante deixarmos a codificação dos caracteres e o título no início de <head> para otimização e procura da página -->

    <!-- meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="robots" content="index, nofollow">
    <meta name="googlebot" content="index, nofollow">
    <meta name="googlebot" content="notranslate">
    <meta name="theme-color" content="#FFFFFF">
    <meta name="description" content="Cancelar biblioteca SENAI">
    <meta name="keywords" content="SENAI, Biblioteca, cancelar">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="author" content="SENAI">

    <!-- link tags -->
    <link rel="stylesheet" href="./config/assets/estilos/cancelar.css">
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
                    <li><a href="./agendamentos.php">Agendamentos</a></li>
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
            <h1>CANCELAMENTO</h1>
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" required placeholder="Digite seu nome"><br>

            <label for="id">ID</label>
            <input type="text" id="id" name="id" required placeholder="Digite seu ID"><br>

            <label for="motivo">Motivo</label>
            <select id="motivo" name="motivo" required>
                <option value="" disabled selected hidden>Escolha uma das opções abaixo</option>
                <option value="Condições climáticas extremas.">Condições climáticas extremas.</option>
                <option value="Tortuguita">Foi oferecido tortuguitas.</option>
                <option value="Emergências e/ou urgências médicas.">Emergências e/ou urgências médicas.</option>
                <option value="Estruturais (elétrica, internet, hidráulica, etc.).">Estruturais (elétrica, internet, hidráulica, etc.).</option>
                <option value="Feriados ou eventos não previstos anteriormente.">Feriados ou eventos não previstos anteriormente.</option>
                <option value="Mudança de plano de aula">Mudança de plano de aula</option>
                <option value="Nenhuma das opções">Nenhuma das opções</option>
            </select>

            <strong>Estou ciente de que ao cancelar meu agendamento, estarei disponibilizando a data/horário para outros
                professores.<br> <span><input type="checkbox" id="concordo" name="concordo" required> <strong class="concordo"> Eu concordo e estou ciente.</strong>
                </span> </strong>


            <button type="submit" value="CANCELAR">Desmarcar</button>
            <button type="button" onclick="limparFormulario()">Limpar</button>


        </form>

        <script src="./config/assets/js/destruirSessao.js"></script>
        <script>
            function limparFormulario() {
                document.getElementById("nome").value = "";
                document.getElementById("id").value = "";
                document.getElementById("motivo").value = "";
                document.getElementById("concordo").checked = false;
            }
        </script>
        <?php
        // Tenta criar uma conexão com o banco de dados

        $host = '127.0.0.1';
        $dbname = 'u683147803_biblioteca';
        $username = 'u683147803_biblioteca';
        $password = 'SenaiMg123';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            die();
        }
        /*$id_cancelamento = $_POST['id_agendamento'];*/
        // Se o formulário foi enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtém os dados do formulário
            $nome = $_POST['nome'];
            $id = $_POST['id'];
            $motivo = $_POST['motivo'];


            // Verifica se existe um registro com o ID fornecido
            try {
                $stmt_select = $pdo->prepare("SELECT COUNT(*) FROM agendamentos WHERE id_agendamento = :id_agendamento");
                $stmt_select->bindValue(':id_agendamento', $id);
                $stmt_select->execute();
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1054) {
                    echo "<div class='id_failed' style='text-align: center; font-size:20px; color: red; font-weight:600;'>Erro: Verifique se o ID de agendamento está correto.</div>";
                    die();
                }
            }

            $count = $stmt_select->fetchColumn();

            if ($count > 0) {
                try {

                    // Insere os dados na tabela "cancelamentos" 
                    $stmt = $pdo->prepare("INSERT INTO cancelamentos (nome, motivo) VALUES (:nome, :motivo)");
                    $stmt->bindValue(':nome', $nome);
                    $stmt->bindValue(':motivo', $motivo);
                    $stmt->execute();
                } catch (PDOException $e) {
                    /*
                    if ($e->errorInfo[1] == 1062) {
                        echo "<div class='id_failed' style=' margin: 10px; text-align: center; font-size:20px; font-weight:600;'> Digite outro nome.</div>";
                    }
                    */
                }

                // Remove o registro da tabela "agendamentos"
                $stmt_delete = $pdo->prepare("DELETE FROM agendamentos WHERE id_agendamento = :id_agendamento");
                $stmt_delete->bindValue(':id_agendamento', $id);
                $stmt_delete->execute();

                // Exibe uma mensagem de sucesso 
                echo "<div class='success-message' style='text-align: center; color:green; font-size:20px; margin: 1rem; font-weight: 600;'>Cancelamento realizado com sucesso!</div>";
            } else {
                // Verifica se existe um registro com o ID fornecido
                $stmt_check = $pdo->prepare("SELECT id FROM cancelamentos WHERE id = :id");
                $stmt_check->bindValue(':id', $id);
                $stmt_check->execute();
                $count_check = $stmt_check->rowCount();

                if ($count_check > 0) {
                    try {
                        // Realiza o UPDATE no registro existente na tabela "cancelamentos"
                        $stmt_update = $pdo->prepare("UPDATE cancelamentos SET nome = :nome, motivo = :motivo WHERE id = :id");
                        $stmt_update->bindValue(':nome', $nome);
                        $stmt_update->bindValue(':motivo', $motivo);
                        $stmt_update->bindValue(':id', $id);
                        $stmt_update->execute();
                    } catch (PDOException $e) {
                        if ($e->errorInfo[1] == 1062) {
                            die();
                        }
                    }
                } else {
                    // Exibe uma mensagem de erro
                    echo "<div class='error-message' style='text-align: center; color:red; font-size:20px; margin: 1rem; font-weight: 600;'>ID de agendamento inválido</div>";
                }
            }
        }
        ?>
        <div class="content-wrapper">

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
                navbar.classList.removse('rounded');
            });
        </script>
        <script src="./config/assets/js/destruirSessao.js"></script>
        <script src="./config/assets/js/default.js"></script>
    </div>

    <footer>
        <div class="rodape">
            <p>&copy;2023 UAIBook. Todos os direitos reservados.<br>Curso de Desenvolvimento em Sistemas. Trilhas do Futuro
                II. <br>SENAI. Uberaba/MG.</p>
        </div>
    </footer>

</body>

</html>