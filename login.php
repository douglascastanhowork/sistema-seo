<?php
	session_start();
	require 'config.php';
	//unset($_SESSION['tentativa']);
	
	if(!empty($_SESSION['tentativa'])){

		if ($_SESSION['tentativa'] < 3 ) {
			$n_tentativas_login = 0;
		} else {
			$n_tentativas_login = 1;
		}

	} else {
		$n_tentativas_login = 0;
	}
		
	if (isset($_POST['email']) && empty($_POST['email']) == false) {

		$_SESSION['tentativa'] ++;				
		$teste = $_SESSION['tentativa'];

		if($teste < 3) {

			$email = addslashes($_POST['email']);
			$senha = md5(addslashes($_POST['senha']));		

			$sql = $pdo->query("SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'");
			if ($sql->rowCount() > 0) {

				$dado = $sql->fetch();

				$_SESSION['id'] = $dado['id'];
				$_SESSION['tentativa'] = 0;

				header("Location: index.php");

			} else {				
				header("Location: login.php");	
			}
		} else {

			//Verificar captcha
			if(!isset($_SESSION['captcha'])) {
				$n = rand(1000, 9999);
				$_SESSION['captcha'] = $n;
				
			}
		
			if(!empty($_POST['email'])){

				$email = addslashes($_POST['email']);
				$senha = md5(addslashes($_POST['senha']));	
				$codigo = $_POST['codigo'];	

				$sql = $pdo->query("SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'");

				if ($sql->rowCount() > 0 && $codigo == $_SESSION['captcha']) {

					$dado = $sql->fetch();

					$_SESSION['id'] = $dado['id'];

					header("Location: index.php");

				} else {
					header("Location: login.php");
					$n = rand(1000, 9999);
					$_SESSION['captcha'] = $n;
				}
			}
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
					<?php
						if ($n_tentativas_login == 1) {
							
					?>					
					<form method="POST" class="formulario">
						<span>E-mail:</span></br>
						<input type="text" name="email" autofocus required /></br></br>

						<span>Senha:</span></br>
						<input type="password" name="senha" required /></br></br>

						<img src="imagem.php" width="313" height="70" /><br/>

						<input type="text" name="codigo" placeholder="Digite o código acima" /></br></br>

						<div class="buttom">
						 	<input id="botao" type="submit" value="Acessar" />
						</div>
					</form>
					<?php
					} else {
						?>
						<form method="POST" class="formulario">
							<span>E-mail:</span></br>
							<input type="text" name="email" autofocus required /></br></br>

							<span>Senha:</span></br>
							<input type="password" name="senha" required /></br></br>

							<div class="buttom">
							 	<input id="botao" type="submit" value="Acessar" />
							</div>
						</form>
						<?php
					}
					?>
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