<?php
session_start();

// Verificar se há uma sessão de usuário ou superusuário
if (!(isset($_SESSION['usuario']) || isset($_SESSION['superusuario']))) {
    header("Location: index.html");
    exit;
} else {
    /* Limpar os dados da sessão
    $_SESSION = array();
    session_unset();
    // Destruir a sessão
    session_destroy();
    // Configurar o cookie da sessão para expirar quando o navegador for fechado
    setcookie(session_name(), '', 0, '/');*/
}


/*$_SESSION['user_id'] = $usuario['id']; // Armazena o ID do usuário na sessão
$_SESSION['privilegios'] = $usuario['privilegios']; // Armazena os privilégios do usuário na sessão
/*<?php
session_start();
if (!isset($_SESSION['usuario'])) { 
    // redireciona o usuário para a página de login
    header("Location: index.html"); 
    exit;
}
?>*/
