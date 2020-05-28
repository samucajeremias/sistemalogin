<?php

Class Usuario
{
	private $pdo;
	public $msgErro = ""; //tudo ok
//conectar banco de dados
	public function conectar($nome, $host, $usuario, $senha){
		global $pdo;
		try{	
			$pdo = new PDO("mysql:dbname=".$nome.";host=".$host,$usuario,$senha);	
		}catch (PDOException $e){
			$msgErro = $e->getMessage();
		}
	}
//
	public function cadastrar($nome, $telefone, $email, $senha){
		global $pdo;
		//verificar se já existe email cadastrado
		$sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e");
		$sql->bindValue(":e", $email);
		$sql->execute();
		if($sql->rowCount()>0){
			return false; //significa que já está cadastrado
		}
		//caso não, cadastrar
		else{
			$sql =$pdo->prepare("INSERT INTO usuarios (nome, telefone, email, senha) VALUES (:n, :t, :e, :s)");
			$sql->bindValue(":n", $nome);
			$sql->bindValue(":t", $telefone);
			$sql->bindValue(":e", $email);
			$sql->bindValue(":s", md5($senha));
			$sql->execute();
			return true;
		}
	}
//
	public function logar($email, $senha){

		global $pdo;
		//verificar se o email e a senha estão cadastrados, se sim
		$sql= $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e AND senha = :s");
		$sql->bindValue(":e", $email);
		$sql->bindValue(":s", md5($senha));
		$sql->execute();
		if($sql->rowCount()>0){
			$dado = $sql->fetch();
			session_start();
			$_SESSION['id_usuario'] = $dado['id_usuario'];
			return true; //logado com sucesso
		}else{
			return false; //não foi possível logar
		}
		//entrar no sistema(sessao)
	}
}
?>