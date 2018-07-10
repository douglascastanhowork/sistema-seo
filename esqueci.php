<?php
require 'config.php';

$aviso = 1;
if(!empty($_POST['email'])) {
	$email = addslashes($_POST['email']);

	$sql = "SELECT * FROM usuarios WHERE email = :email";
	$sql = $pdo->prepare($sql);
	$sql->bindValue(":email", $email);
	$sql->execute();

	if($sql->rowCount() > 0) {
		$sql = $sql->fetch();
		$id = $sql['id'];
		$aviso = 1;

		$token = md5(time().rand(0, 99999).rand(0, 99999));

		$sql = "INSERT INTO usuarios_token (id_usuario, hash, expira_em) VALUES (:id_usuario, :hash, :expira_em )";
		$sql = $pdo->prepare($sql);
		$sql->bindValue(":id_usuario", $id);
		$sql->bindValue(":hash", $token);
		$sql->bindValue(":expira_em", date('Y-m-d H:i', strtotime('+2 months')));
		$sql->execute();

		$link = "http://localhost/sistema-seo/redefinir.php?token=".$token;

		$mensagem = "Clique no link para redefinir sua senha"."\r\n".$link;

		$assunto = "Redefinir senha";

		$headers = "From: seusite@seusite.com"."\r\n"."X-Mailer PHP/".phpversion();

		//mail($email, $assunto, $mensagem, $headers);

		header("Location: email-enviado.php");
		exit;

	} else {
		$aviso = 0;
	}
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
					<span>Qual seu e-mail de cadastro?</span>
					<form method="POST">
						<input class="email" type="email" name="email" placeholder="exemplo@exemplo.com" /><br/>

						<?php
						if($aviso == 0) {
						?>
						<div class="aviso">
							O e-mail informado não está cadastrado!
						</div>
						<?php
						}
						?>

						<input class="botao" type="submit"	Value="Esqueci a senha"	/>
					</form>
					
				</div>				
			</div>
		</div>
	</body>
</html>