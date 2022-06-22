<?php 
require "includes/header.php";
require "includes/funcoes-sessao.php";
require "includes/funcoes-usuarios.php";
/* Mensagens para os processos de erros no login */
if (isset($_GET['acesso_proibido'])) {
    $feedback = "Você deve logar primeiro!";
  } elseif (isset($_GET['logout'])) {
    $feedback = "Você saiu do sistema!";
  } elseif (isset($_GET['nao_encontrado'])) {
    $feedback = "Usuário não encontrado!";
  } elseif (isset($_GET['senha_incorreta'])) {
    $feedback = "A senha está errada!";
  } elseif (isset($_GET['campos_obrigatorios'])) {
    $feedback = "Você deve preencher todos os campos!";
  } else {
    $feedback = "";
  }
  
  // 1) [IF] se o botão entrar foi acionado
  if (isset($_POST['entrar'])) {
  
    // 2) [IF ELSE] verifica se os campos estão vazios
    if (empty($_POST['email']) || empty($_POST['senha'])) {
      // redireciona para login com parâmetro indicando campos obrigatorios
      header('location:login.php?campos_obrigatorios');
    } else {
      // caso contrario pegue o email e senha digitadas 
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
      $senha = $_POST['senha'];
  
      // verificar no banco se existe alguém com o email informado
      $usuario = buscarUsuario($conexao, $email);
  
      // TESTE
      // var_dump($usuario);
  
      // 3) [IF ELSE] se for diferente de nulo é porque tem usuário com esse email
      if ($usuario != null) {
  
        // 4) [IF ELSE] se as senhas forem iguais
        if (password_verify($senha, $usuario['senha'])) {
          // então inicia o login para a área administrativa
          login($usuario['id'], $usuario['nome'], $usuario['email'], $usuario['tipo']);
          header('location:admin/index.php');
        } else {
          // caso contrário, fique no login e diga que a senha está errada
          header('location:login.php?senha_incorreta');
        }
        // caso contrário, não existe usuário
      } else {
        header('location:login.php?nao_encontrado');
      }
    }
  }
?>

<div class="container">
    <h2 class="text-center display-4">Acesso administrativo</h2>
    <p class="text-center display-6">
        <?= $feedback ?>
      </p>
    <form action="" method="post" id="form-login" name="form-login" class="card">
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input class="form-control" type="email" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="senha">Senha:</label>
            <i class="fa-solid fa-eye senha1"></i>
            <input class="form-control" type="password" id="senha" name="senha">
        </div>
        <button class="btn btn-dark" name="entrar" type="submit">Entrar</button>
    </form>
</div>

<?php 
require "includes/footer.php";
?>