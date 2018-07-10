<?php
session_start();
require 'config.php';

if (empty($_POST['email']) == false) {
	$email = addslashes($_POST['email']);
	$senha = md5(addslashes($_POST['senha']));

	$sql = "SELECT * FROM usuarios WHERE email = '$email'";
	$sql = $pdo->query($sql);

	if ($sql->rowCount() <= 0) {
		$sql = "INSERT INTO usuarios (email, senha) VALUES ('$email', '$senha')";
		$sql = $pdo->query($sql);
		$id = $pdo->lastInsertId();

		$md5 = md5($id);

		$link = "http://localhost/sistema-seo/confirmar.php?h=".$md5;

		$assunto = "Confirme seu cadastro";
		$mensagem = "Confirme sua conta clicando no link abaixo:"."\r\n".$link;
		$headers = "From: seusite@seusite.com.br"."\r\n"."X-Mailer: PHP/".phpversion();

		//mail($email, $assunto, $mensagem, $headers);

		unset($_SESSION['id']);

		//header("Location: index.php");

		echo "O link é: ".$link;
		exit;
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Cadastrar | Sistema SEO</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style-cadastrar.css">
		<meta charset="utf-8">
		<meta id="viewport" name="viewport" content="width=device-width, user-scalable=0" />
	</head>
	<body>
		<div class="container">
			<div class="logo">
				<img src="assets/images/logo.png" border="0" width="120" height="100" />
			</div>
			<div class="caixa">
				<div class="titulo">
				Crie sua conta</br>					
				</div>
				<div class="campos">					
					<form method="POST">
						<span>E-mail:</span></br>
						<input type="text" name="email" autofocus required /></br></br>
						<span>Senha:</span></br>
						<input type="password" name="senha" required /></br></br>
						<div class="buttom">
						 	<input id="botao" type="submit" value="Criar conta" />
						</div>
					</form>
				<div class="voltar_login">
					<a href="http://localhost/sistema-seo/login.php">Voltar para login</a>
				</div>
			</div>
		</div>
	</body>
</html>