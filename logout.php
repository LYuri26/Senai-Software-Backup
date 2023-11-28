<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Sair</title>
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
    <link rel="icon" href="./config/assets/img/senai.ico" type="image/x-icon">
</head>
<?php 
session_start(); // Inicie a sessão, se ainda não estiver iniciada

/* Verifique se o parâmetro de erro é definido e se é igual a '1001'
if (isset($_GET['error']) && $_GET['error'] == '1001') {
  echo "<div class='failed' style='text-align: center; font-size:20px; font-weight:600;'>Login ou senha inválidos.</div>";
}
*/
// Limpe todas as variáveis de sessão
session_destroy();
if (isset($_GET['error']) && $_GET['error'] == '1001') {
  echo "<div class='failed' style='text-align: center; font-size:20px; font-weight:600;'>Login ou senha inválidos.</div>";
}
header("Location: index.html");
exit();
?>
