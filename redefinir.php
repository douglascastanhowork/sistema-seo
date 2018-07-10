<?php
require 'config.php';
if(!empty($_GET['token'])) {
	$token = $_GET['token'];

	$sql = "SELECT * FROM usuarios_token WHERE hash = :hash AND used = 0 AND expira_em > NOW()";
	$sql = $pdo->prepare($sql);
	$sql->bindValue(":hash", $token);
	$sql->execute();

	if($sql->rowCount() >0) {
		$sql = $sql->fetch();
		$id = $sql['id_usuario'];

		if(!empty($_POST['senha'])) {
			$senha = $_POST['senha'];

			$sql = "UPDATE usuarios SET senha = :senha WHERe id=:id";
			$sql = $pdo->prepare($sql);
			$sql->bindValue(":senha", md5($senha));
			$sql->bindValue(":id", $id);
			$sql->execute();

			$sql = "UPDATE usuarios_token SET used = 1 WHERE hash = :hash";
			$sql = $pdo->prepare($sql);
			$sql->bindValue(":hash", $token);
			$sql->execute();

			header("Location: redefinir-senha-sucesso.php");			
		}
		?>
		<!DOCTYPE html>
		<html>
			<head>
				<title>Redefinir Senha | Sistema SEO</title>
				<meta name="viewport" content="width=device-width, initial-scale=1" />
				<link rel="stylesheet" type="text/css" href="assets/css/style-esqueci.css" />
			</head>
			<body>
				<div class="container">
					<div class="caixa">
						<div class="texto">
							<span>Digite uma nova senha</span>
							<form method="POST">
								<input class="senha" type="password" name="senha" placeholder="Use letras e números" /><br/>

								<input class="botao" type="submit"	Value="Redefinir Senha"	/>
							</form>
						</div>
					</div>
				</div>
			</body>
		</html>	
		<?php
		exit;		
	} else {
		?>
		<!DOCTYPE html>
		<html>
			<head>
				<title>Redefinir Senha | Sistema SEO</title>
				<meta name="viewport" content="width=device-width, initial-scale=1" />
				<link rel="stylesheet" type="text/css" href="assets/css/style-esqueci.css" />
			</head>
			<body>
				<div class="container">
					<div class="texto">
						<p class="atencao">OPS!</p>
						<p class="token">Este token é inválido ou já foi utilizado!</p>
						<div class="botao2">
							<a href="esqueci.php">Reenviar link</a>
						</div>	
					</div>					
				</div>
			</body>
		</html>
		<?php
	}
}