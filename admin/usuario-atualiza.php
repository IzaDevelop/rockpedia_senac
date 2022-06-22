<?php
require "../includes/funcoes-usuarios.php";
require "../includes/header-admin.php";
verificaAcessoAdmin();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$usuario = lerUmUsuario($conexao, $id);
if (isset($_POST['atualizar'])) {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);

    /* Lógica para a senha  
    Se o campo senha do formulário estiver vazio, então significa que o usuário NÃO MUDOU A SENHA */
    if (empty($_POST['senha'])) {
        $senha = $usuario['senha']; //manter a senha já existente no banco
    } else {
        /* Caso contrário, se o usuário digitou alguma coisa no campo senha, precisamos verificar a senha digitada */
        $senha = verificaSenha($_POST['senha'], $usuario['senha']);
    }

    // TESTE DE SENHA
    /*echo 'Banco de dados'.$usuario['senha']; 
  echo '<br>';
  echo 'Formulário'.$senha; */

    atualizarUsuario($conexao, $id, $nome, $email, $senha, $tipo);
    header("location:usuarios.php");
}
?>

<h2 class="text-center display-4">Atualizar Usuário</h2>

<form class="mx-auto w-75" action="" method="post" id="form-atualizar" name="form-atualizar">

    <div class="form-group">
        <label for="nome">Nome:</label>
        <input class="form-control" required type="text" id="nome" name="nome" value="<?= $usuario['nome'] ?>">
    </div>

    <div class="form-group">
        <label for="email">E-mail:</label>
        <input class="form-control" required type="email" id="email" name="email" value="<?= $usuario['email'] ?>">
    </div>

    <div class="form-group">
        <label for="nova-senha">Senha</label>
        <i class="fa-solid fa-eye senha1"></i>
        <input class="form-control" type="password" id="senha" name="senha" placeholder="Preencha apenas se for alterar">
    </div>

    <div class="form-group">
        <label for="tipo">Tipo:</label>
        <select class="form-select" name="tipo" id="tipo" required>
            <option value="<?= $tipo ?>"></option>
            <option <?php if ($usuario['tipo'] == 'editor') {
                        echo " selected ";
                    } ?> value="editor">Editor</option>
            <option <?php if ($usuario['tipo'] == 'admin') {
                        echo " selected ";
                    } ?> value="admin">Administrador</option>
        </select>
    </div>
    <br>
    <button class="btn btn-dark" name="atualizar">Atualizar usuário</button>
</form>

<?php
require "../includes/footer-admin.php";
?>