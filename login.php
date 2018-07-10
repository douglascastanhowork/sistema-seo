<?php
	session_start();

	if (isset($_POST['email']) && empty($_POST['email']) == false) {
		$email = addslashes($_POST['email']);
		$senha = md5(addslashes($_POST['senha']));

		$dsn = "mysql:dbname=sistemaseo;host=127.0.0.1";
		$dbuser = "root";
		$dbpassword = "";

		try {
			$db = new PDO($dsn, $dbuser, $dbpassword);

			$sql = $db->query("SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'");
			if ($sql->rowCount() > 0) {

				$dado = $sql->fetch();

				$_SESSION['id'] = $dado['id'];

				header("Location: index.php");
			} else {				
				header("Location: login.php");
			}

		}catch (PDOException $e) {
			echo "Falhou: ".$e->getMessage();
		}
	}	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login | Sistema SEO</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style-login.css">
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
				Acesse sua Conta</br>					
				</div>
				<div class="campos">					
					<form method="POST">
						<span>E-mail:</span></br>
						<input type="text" name="email" autofocus required /></br></br>
						<span>Senha:</span></br>
						<input type="password" name="senha" required /></br></br>
						<div class="buttom">
						 	<input id="botao" type="submit" value="Acessar" />
						</div>
					</form>
				<div class="recuperarsenha">
					Esqueceu a senha?&nbsp <a href="http://localhost/sistema-seo/esqueci.php">clique aqui</a>
				</div>
				<div class="cadastrar">
					Ainda não tem cadastro?&nbsp <a href="http://localhost/sistema-seo/cadastrar.php">cadastrar</a>
				</div>
				</div>
			</div>
		</div>
	</body>
</html>