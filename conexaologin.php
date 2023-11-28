<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Autenticar usuário</title>
    <!-- Importante deixarmos a codificação dos caracteres e o título no início de <head> para otimização e procura da página -->


    <!-- meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="robots" content="index, nofollow">
    <meta name="googlebot" content="index, nofollow">
    <meta name="googlebot" content="notranslate">
    <meta name="theme-color" content="#FFFFFF">
    <meta name="description" content="Cadastro biblioteca SENAI">
    <meta name="keywords" content="SENAI, Biblioteca, cadastro">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="author" content="SENAI">

    <!-- link tags -->
    <link rel="stylesheet" href="./config/assets/estilos/cadastro.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Fira+Sans:ital,wght@1,200&family=Montserrat:wght@200&family=Source+Sans+Pro&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="./config/assets/js/destruirSessao.js"></script>
    <!-- O ícone da página pode ser carregado no final, por questão de organização do código e porque é interessante processarmos as fontes e estilos primeiro do que o ícone -->
    <!-- link tags -->
    <link rel="icon" href="./config/assets/img/linguicao.ico" type="image/x-icon">
</head>
<?php
session_start();
/*
require_once './session.php';

// Verificar se há uma sessão de usuário ou superusuário 
if (!(isset($_SESSION['usuario']) || isset($_SESSION['superusuario']))) { 
    // Redirecionar para a página de login 
    header("Location: index.html"); 
    exit;
}*/

$host = '127.0.0.1';
$dbname = 'u683147803_biblioteca';
$username = 'u683147803_biblioteca';
$password = 'SenaiMg123';
// Conectar ao banco de dados usando PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    /*Resto do seu código...
    $loginAdmin = "admin"; // Substitua pelo valor desejado
    $senhaAdmin = 'fixfixfix'; // Substitua 'senha_admin' pela senha do superusuário

    // Gerar o hash da senha
    $senhaHash = password_hash($senhaAdmin, PASSWORD_DEFAULT);

    // Armazenar o hash da senha no banco de dados
    $stmt = $pdo->prepare("INSERT INTO superusuario (login, senha) VALUES (:login, :senha)");
    $stmt->bindValue(':login', $loginAdmin);
    $stmt->bindValue(':senha', $senhaHash);
    $stmt->execute();
*/

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = $_POST['usuario'];
        $senha = $_POST['senha'];

        /* admin
        $consultasuper = "SELECT * FROM superusuario WHERE BINARY (login = :login || email = :login)";
        $stmt = $pdo->prepare($consultasuper);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $resconsultasuper = $stmt->fetch(PDO::FETCH_ASSOC);
        */

        $stmt = $pdo->prepare("SELECT * FROM superusuario WHERE BINARY (BINARY login = :login OR BINARY email = :login) AND BINARY senha = :senha");
        $stmt->bindValue(':login', $login);
        $stmt->bindValue(':senha', $senha);
        $stmt->execute();
        $superusuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($superusuario) {
            // É um superusuário/administrador, armazenar os dados na sessão
            $_SESSION['usuario'] = $superusuario;
            // É um superusuário/administrador, redirecionar para a página de administração
            header('Location: menu.php');
            exit;
        }

        $consultasuper = "SELECT * FROM superusuario WHERE BINARY (BINARY login = :login OR BINARY email = :login)";
        $stmt = $pdo->prepare($consultasuper);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $resconsultasuper = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resconsultasuper) {
            $hashSenhaDB = $resconsultasuper['senha'];
            $senhaCorrespondente = password_verify($senha, $hashSenhaDB);
            if ($senhaCorrespondente) {
                // É um superusuário/administrador, armazenar os dados na sessão
                $_SESSION['usuario'] = $resconsultasuper;
                // Redirecionar para a página de administração
                header('Location: menu.php');
                exit;
            }
        }

        //users
        $stmt = $pdo->prepare("SELECT * FROM users WHERE BINARY (BINARY login = :login OR BINARY email = :login) AND BINARY senha = :senha");
        $stmt->bindValue(':login', $login);
        $stmt->bindValue(':senha', $senha);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // É um usuário comum, armazenar os dados na sessão
            $_SESSION['usuario'] = $usuario;
            // É um usuário comum, redirecionar para a página principal
            header('Location: menu.php');
            exit;
        }

        // Verificar se é um usuário comum
        $consultauser = "SELECT * FROM users WHERE BINARY (BINARY login = :login OR BINARY email = :login)";
        $stmt = $pdo->prepare($consultauser);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $resconsultauser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resconsultauser) {
            $hashSenhaDBuser = $resconsultauser['senha'];
            $senhaCorrespondenteuser = password_verify($senha, $hashSenhaDBuser);
            if ($senhaCorrespondenteuser) {
                // É um superusuário/administrador, armazenar os dados na sessão
                $_SESSION['usuario'] = $resconsultauser;
                // Redirecionar para a página de administração
                header('Location: menu.php');
                exit;
            }
        }
        if (isset($_GET['error']) && $_GET['error'] == '1001') {
            echo "<div class='failed' style='text-align: center; font-size:20px; font-weight:600;'>Usuário ou senha inválidos.</div>";
        }
        // Credenciais inválidas, redirecionar para index.html com mensagem de erro
        header('Location: index.html?error=1001');
        exit;

        if (isset($_GET['skip_message']) && $_GET['skip_message'] === '1') {
            header('Location: cancelar.php?skip_message=1');
            // Se o parâmetro "skip_message" estiver presente e tiver o valor "1", não exibir a mensagem
            // Continuar normalmente com o restante do código da página "cancelar.php"
        }
        exit;
    }
} catch (PDOException $e) {
    // Tratar exceções de conexão com o banco de dados aqui, se necessário
    echo "Erro de conexão com o banco de dados: " . $e->getMessage();
    exit;
}
session_destroy();

?>