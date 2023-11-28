<?php
/* 
! IMPORTANTE !
! IMPORTANTE !

SE NAO ESTOU ENGANDO, PODE HAVER A POSSIBILIDADE DE EXCLUSÃO DESTE ARQUIVO (conexao.php) POIS O MESMO JÁ NÃO CUMPRE MAIS A FUNÇÃO DESIGNADA, MAS POR ENQUANTO VAMOS MANTÊ-LO

! IMPORTANTE !
! IMPORTANTE !
*/
require_once './session.php';

// Verificar se há uma sessão de usuário ou superusuário 
if (!(isset($_SESSION['usuario']) || isset($_SESSION['superusuario']))) {
  // Redirecionar para a página de login 
  header("Location: index.html");
  exit;
}
?>
<!DOCTYPE html>
<html>

<head>
  <!-- meta tags -->
  <meta charset="UTF-8">
  <!-- link tags -->
  <link rel="stylesheet" href="./config/assets/estilos/consulta.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Fira+Sans:ital,wght@1,200&family=Montserrat:wght@200&family=Source+Sans+Pro&display=swap" rel="stylesheet">
</head>

<body>
  <?php
  // Definir as informações de conexão
  $host = '127.0.0.1';
  $dbname = 'u683147803_biblioteca';
  $username = 'u683147803_biblioteca';
  $password = 'SenaiMg123';

  // ... código de conexão ao banco de dados ...

  /*
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Recuperar os valores dos campos de login e senha do formulário
  $login = $_POST['usuario'];
  $senha = $_POST['senha'];

  // Consultar a tabela superusuario para verificar se é um admin
  $stmt = $pdo->prepare("SELECT * FROM superusuario WHERE login = :login");
  $stmt->bindValue(':login', $login);
  $stmt->execute();
  $superusuario = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($superusuario && password_verify($senha, $superusuario['senha'])) {
    // É um superusuário/administrador, redirecionar para a página de administração
    header('Location: agendamentos.php');
    exit;
  }

  // Consultar a tabela de usuários comuns para verificar o usuário e senha
  $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");
  $stmt->bindValue(':login', $login);
  $stmt->execute();
  $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($usuario && password_verify($senha, $usuario['senha'])) {
    // É um usuário comum, redirecionar para a página principal
    header('Location: agendamentos.php');
    exit;
  } else {
    // Login inválido, exibir mensagem de erro
    echo "Login ou senha inválidos.";
  }
}
// Conectar ao banco de dados usando PDO
*/
  try {

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Configurar o modo de erro para exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // Se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Obtém os dados do formulário
      $nome = $_POST['nome'];
      $id = $_POST['id'];
      $motivo = $_POST['motivo'];

      // Insere os dados na tabela "cancelamentos"
      $stmt = $pdo->prepare("INSERT INTO cancelamentos (id, nome, motivo) VALUES (:id, :nome, :motivo)");
      $stmt->bindValue(':id', $id);
      $stmt->bindValue(':nome', $nome);
      $stmt->bindValue(':motivo', $motivo);
      $stmt->execute();
      //echo "<p>Cancelamento realizado com sucesso!</p>";
    }
  } catch (PDOException $e) { // Exibir uma mensagem de erro
    echo "Erro de conexão: " . $e->getMessage();
  }
  ?>
  <p>Agendamento realizado com sucesso!</p>
  <script src="./config/assets/js/destruirSessao.js"></script>
</body>

</html>