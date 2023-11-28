<?php
require_once './session.php';
/*

usado para sempre verificar a sessão do usuário
require_once './session.php';

// Verificar se há uma sessão de usuário ou superusuário 
if (!(isset($_SESSION['usuario']) || isset($_SESSION['superusuario']))) { 
    // Redirecionar para a página de login 
    header("Location: index.html"); 
    exit;
}*/
//require_once './session.php';

// Definir a mensagem na variável de sessão
$_SESSION['login_message'] = 'Para cancelar um agendamento, por favor, faça login novamente';

?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <title>Agendar</title>
    <!-- Importante deixarmos a codificação dos caracteres e o título no início de <head> para otimização e procura da página -->


    <!-- meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="robots" content="index, nofollow">
    <meta name="googlebot" content="index, nofollow">
    <meta name="googlebot" content="notranslate">
    <meta name="theme-color" content="#FFFFFF">
    <meta name="description" content="Agendar biblioteca SENAI">
    <meta name="keywords" content="SENAI, Biblioteca, agendar">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="author" content="SENAI">

    <!-- link tags -->
    <link rel="stylesheet" href="./config/assets/estilos/agendar.css">
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
                    <li><a href="./cancelar.php">Cancelar</a></li>
                    <li><a href="./agendamentos.php">Agendamentos</a></li>
                    <li><a href="./cancelamentos.php">Cancelamentos</a></li>
                    <li><a href="./menu.php">Menu</a></li>
                    <li class="botaosair"><a id="botaosair" href="./logout.php">Sair</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="text-container">

        <div class="calendario">
            <table title="Horários">
                <tr>
                    <th>Dia útil</th>
                    <th>Início</th>
                    <th>Término</th>
                </tr>
                <tr>
                    <td>Segunda</td>
                    <td>13:00</td>
                    <td>21:00</td>
                </tr>
                <tr>
                    <td>Terça</td>
                    <td>08:00</td>
                    <td>17:00</td>
                </tr>
                <tr>
                    <td>Quarta</td>
                    <td>13:00</td>
                    <td>21:00</td>
                </tr>
                <tr>
                    <td>Quinta</td>
                    <td>13:00</td>
                    <td>21:00</td>
                </tr>
                <tr>
                    <td>Sexta</td>
                    <td>08:00</td>
                    <td>17:00</td>
                </tr>
            </table>
        </div>
        <div class="forms">
            <form method="POST">
                <h1>AGENDAMENTO</h1>
                <label for="instrutor">Instrutor</label>
                <input type="text" id="instrutor" name="instrutor" required><br>

                <label for="curso">Curso</label>
                <input type="text" id="curso" name="curso" required><br>

                <label for="data">Data</label>
                <input type="date" id="data" name="data" required><br>

                <label for="hora_inicio">Início</label>
                <input type="time" id="hora_inicio" name="hora_inicio" required><br>

                <label for="hora_termino">Término</label>
                <input type="time" id="hora_termino" name="hora_termino" required><br>

                <label for="quantidade_alunos">Quantidade de Alunos</label>
                <input type="number" id="quantidade_alunos" name="quantidade_alunos" required><br>

                <button type="submit" value="AGENDAR">Agendar</button>
            </form>
        </div>

    </div>

    <?php
    $host = '127.0.0.1';
    $dbname = 'u683147803_biblioteca';
    $username = 'u683147803_biblioteca';
    $password = 'SenaiMg123';
    // Conectar ao banco de dados usando pdo

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        die();
    }
    /* datas */

    function isWeekend($date)
    {
        $timestamp = strtotime($date);
        $weekday = date('N', $timestamp);
        return ($weekday == 6 || $weekday == 7);
    }

    function isHoliday($date)
    {
        $apiUrl = "https://api.calendario.com.br/?json=true&ano=" . date('Y') . "&estado=SP&cidade=Sao_Paulo&token=SEU_TOKEN";
        // Substitua SEU_TOKEN pelo token fornecido pela API Calendário Brasileiro

        $response = file_get_contents($apiUrl);
        $holidays = json_decode($response, true);

        return isset($holidays[$date]);
    }

    function isValidTime($dayOfWeek, $time)
    {
        $validTimes = [
            1 => ['13:00', '21:00'], // Segunda
            2 => ['08:00', '17:00'], // Terça
            3 => ['13:00', '21:00'], // Quarta
            4 => ['13:00', '21:00'], // Quinta
            5 => ['08:00', '17:00'], // Sexta
        ];

        $start = $validTimes[$dayOfWeek][0];
        $end = $validTimes[$dayOfWeek][1];

        return ($time >= $start && $time <= $end);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $data = $_POST['data'];
        $hora_inicio = $_POST['hora_inicio'];
        $nome = $_POST['instrutor'];
        $curso = $_POST['curso'];
        $hora_termino = $_POST['hora_termino'];
        $quantidade_alunos = $_POST['quantidade_alunos'];
        /*$id_agendamento = $_SESSION['id_agendamento'];*/


        // Verificar se já existe um agendamento para essa data e hora no banco de dados
        $stmt = $pdo->prepare("
        SELECT COUNT(*) FROM agendamentos
        WHERE data = :data AND (
        (hora_inicio <= :hora_inicio AND hora_termino > :hora_inicio) OR
        (hora_inicio < :hora_termino AND hora_termino >= :hora_termino)
        )
        ");
        $stmt->bindValue(':data', $data);
        $stmt->bindValue(':hora_inicio', $hora_inicio);
        $stmt->bindValue(':hora_termino', $hora_termino);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            /*$_SESSION['error_message'] = "Já existe um agendamento neste horário!";*/
            // Exibir uma mensagem de erro se já existe um agendamento para essa data e hora
            echo "<div class='error-message' style='color: yellow; text-align: center; font-size:20px; font-weight:600;margin: 1rem;'>Já existe um agendamento neste horário!</div>";

            // Insere os dados na tabela "agendamentos"
        }

        if (isWeekend($data) || isHoliday($data)) {
            echo "<div class='error-message' style='color: red; text-align: center; font-size:20px; font-weight:600; margin: 1rem;'>Não é possível agendar nos sábados e domingos.</div>";
        } else {
            // Verificar se é um dia útil e horário válido
            $dayOfWeek = date('N', strtotime($data));
            if (isValidTime($dayOfWeek, $hora_inicio)) {
                $Id_bytes = 5;
                $resultado_bytes = random_bytes($Id_bytes);
                $id_agendamento  = strtoupper(bin2hex(random_bytes(4)));
                $_SESSION['id_agendamento'] = $id_agendamento;

                // Insere os dados na tabela "agendamentos"
                $stmt = $pdo->prepare("INSERT INTO agendamentos (nome, curso, data, hora_inicio, hora_termino, quantidade_alunos, id_agendamento) VALUES (:nome, :curso, :data, :hora_inicio, :hora_termino, :quantidade_alunos, :id_agendamento)");
                $stmt->bindValue(':nome', $nome);
                $stmt->bindValue(':curso', $curso);
                $stmt->bindValue(':data', $data);
                $stmt->bindValue(':hora_inicio', $hora_inicio);
                $stmt->bindValue(':hora_termino', $hora_termino);
                $stmt->bindValue(':quantidade_alunos', $quantidade_alunos);
                $stmt->bindValue(':id_agendamento', $_SESSION['id_agendamento']);
                /*$stmt->bindValue(':id_agendamento', $id_agendamento);*/
                $stmt->execute();
                $cadastroId = $pdo->lastInsertId();

                // Exibe uma mensagem de sucesso
                //echo "<div class='success-message' style='text-align: center; color: green; font-size:20px; margin: 1rem;'>Agendamento realizado com sucesso!</div>";
                //session_destroy();
                echo "<div class='success-message' style='color: green; text-align: center; font-size:20px; font-weight:600; margin: 1rem;'>Agendamento realizado com sucesso!</div> <p style='color: black; text-align: center; font-size:20px; font-weight:600;'>ID do agendamento: " . $resultado_final . "</p>";
                echo "<script>window.location.href = 'agendamentos.php'</script>;";
                header("Location: agendamentos.php");

                /*echo "<script> alert('Agendado com sucesso!') </script>";*/
                // Agendamento válido, continuar com o código existente para inserir no banco de dados
                // ...
            } else {
                echo "<div class='error-message' style='color: orange; text-align: center; font-size:20px; font-weight:600; margin: 1rem;'>Não foi possível agendar.</div>";
            }
        }
    }

    ?>
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
    <!--<script src="./config/assets/js/default.js"></script>-->

</body>

<footer>
    <div class="rodape">
        <p>&copy;2023 UAIBook. Todos os direitos reservados.<br>Curso de Desenvolvimento em Sistemas. Trilhas do Futuro II. <br>SENAI. Uberaba/MG.</p>
    </div>
</footer>

</html>