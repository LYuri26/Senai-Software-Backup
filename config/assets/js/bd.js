$(document).ready(function () {
    // Executa a solicitação AJAX quando a página é carregada
    $.ajax({
        url: '../config/assets/bd/tabelas.php', // Nome do seu arquivo PHP
        method: 'POST', // Ou 'POST', dependendo das suas necessidades
        success: function (response) {
            // Manipule a resposta do PHP (se houver) aqui
            console.log(response);
        },
        error: function (xhr, status, error) {
            // Lida com erros aqui
            console.error(error);
        }
    });
});