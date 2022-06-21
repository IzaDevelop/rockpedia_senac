<?php
require "../includes/header-admin.php";
require "../includes/funcoes-usuarios.php";

// carregaremos os dados da pessoa logada na sessão ($_SESSION['id'])
$usuario = lerUmUsuario($conexao, $_SESSION['id']);

if (isset($_POST['atualizar'])) {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $tipo = $_SESSION['tipo']; // recuperando o tipo de usuário 
    $id = $_SESSION['id']; // recuperando o id do usuário 

    if (empty($_POST['senha'])) {
        $senha = $usuario['senha'];
    } else {
        $senha = verificaSenha($_POST['senha'], $usuario['senha']);
    }
    atualizarUsuario($conexao, $id /* ou $_SESSION['id'] */, $nome, $email, $senha, $tipo);
    header("location:index.php");
}
?>

<h2 class="text-center display-4">Atualizar meu perfil</h2>

<form action="" method="post" id="form-atualizar" name="form-atualizar" class="mx-auto w-75">
    <div class="form-group">
        <label for="nome">Nome:</label>
        <input class="form-control" value="<?= $usuario['nome'] ?>" required type="text" id="nome" name="nome" placeholder="Nome (obrigatório)">
    </div>
    <div class="form-group">
        <label for="email">E-mail:</label>
        <input class="form-control" value="<?= $usuario['email'] ?>" required type="email" id="email" name="email" placeholder="E-mail (obrigatório)">
    </div>
    <div class="form-group">
        <label for="senha">Senha</label>
        <i class="fa-solid fa-eye senha1"></i>
        <input class="form-control" type="password" id="senha" name="senha" placeholder="Preencha apenas se for alterar">
    </div>
    <button class="btn btn-dark" name="atualizar">Atualizar</button>
</form>

<?php
require "../includes/footer-admin.php";
?>