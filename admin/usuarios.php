<?php
require "../includes/funcoes-usuarios.php";
require "../includes/header-admin.php";
verificaAcessoAdmin();

$usuarios = lerUsuarios($conexao);
$quantidade = count($usuarios);
?>
<h2 class="text-center display-4">
	Usuários <span class="badge bg-dark"><?= $quantidade ?></span>
</h2>
<p class="lead text-right">
	<a class="btn btn-dark" href="usuario-insere.php">Inserir novo usuário</a>
</p>

<div class="table-responsive">

	<table class="table table-hover">
		<thead class="thead-light">
			<tr>
				<th>Nome</th>
				<th>E-mail</th>
				<th>Tipo</th>
				<th colspan="2" class="text-center">Operações</th>
			</tr>
		</thead>

		<tbody>
			<?php
			foreach ($usuarios as $usuario) {
			?>
				<tr>
					<td> <?= $usuario['nome'] ?> </td>
					<td> <?= $usuario['email'] ?> </td>
					<td> <?= $usuario['tipo'] ?> </td>
					<td class="text-center">
						<a class="btn btn-warning btn-sm" href="usuario-atualiza.php?id=<?= $usuario['id'] ?>">
							Atualizar
						</a>
					</td>
					<td class="text-center">
						<a class="btn btn-danger btn-sm excluir" href="usuario-exclui.php?id=<?= $usuario['id'] ?>">
							Excluir
						</a>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

<?php
require "../includes/footer-admin.php";
?>