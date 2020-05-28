<?php
	require_once 'classes/usuarios.php';
	$u	= new Usuario;
?>

<!DOCTYPE html>
<html lagn="pt-br">
<head>
	<meta charset="UTF-8">
	<title>
		Projeto Login
	</title>
	<link rel="stylesheet" href="css/estilo.css">

</head>
<body>
<div id="corpo-form-cad">
	<h1>Cadastrar</h1>
	<form method="POST">
		<input type="text" name="nome" placeholder="Nome Completo" maxlenght="30">
		<input type="text" name="telefone" placeholder="Telefone" maxlenght="30">
		<input type="email" name="email" placeholder="Usuário" maxlenght="40">		
		<input type="password" name="senha" placeholder="Senha" maxlenght="15">
		<input type="password" name="confSenha" placeholder="Confirmar Senha" maxlenght="15">
		<input type="submit" value="Cadastrar">		
	</form>
</div>	

<?php
//verificar se clicou no botao
if(isset($_POST['nome'])){
	$nome = addslashes($_POST['nome']);
	$telefone = addslashes($_POST['telefone']);
	$email = addslashes($_POST['email']);
	$senha = addslashes($_POST['senha']);
	$confirmarSenha = addslashes($_POST['confSenha']);
	//verificar se está preenchido
	if(!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha) && !empty($confirmarSenha)){
		$u->conectar("projeto_login", "localhost", "root", "");
		if($senha == $confirmarSenha){
			if($u->msgErro == ""){//se está vazia, está OK
				if($u->cadastrar($nome,$telefone,$email,$senha)){
					?>
					<div id="msg-sucesso">Cadastrado com sucesso! Acesse para entrar!
					</div>

					<?php
				}
				else{
					?>
					<div class="msg-erro">
						Email já cadastrado!
					</div>
					<?php
				}
			}
			else{
				?>
				<div class="msg-erro">
					Senha e confirmar senha não correspondem!
				</div>
				<?php
			}
		}else{
			?>
			<div class="msg-erro">
				 echo "Erro: ".$u->msgErro;
			</div>
			<?php

		}
	}else{
		?>
		<div class="msg-erro">
			Preencha todos os campos!
		</div>
		<?php
	}
}
?>

</body>
</html>