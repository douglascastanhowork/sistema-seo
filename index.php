<?php
 session_start();
 require 'config.php';

 if (isset($_SESSION['id']) && empty($_SESSION['id']) == false) {
 	
 	try {
 		$pdo = new PDO("mysql:dbname=sistemaseo;host=127.0.0.1", "root", "");
 		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 	} catch (PDOException $e) {
 		echo "Erro: ".$e->getMessage();
 		exit;
 	}
 	if (isset($_GET['ordem']) && empty($_GET['ordem']) ==  false) {
 			$ordem = addslashes($_GET['ordem']);
 			$sql = "SELECT * FROM controle WHERE tipo_backlink = '".$ordem."' ";
 		} else {
 			$ordem = "";
 			$sql = "SELECT * FROM controle";
 		}

 	$emailusuario = '';
 	$sqlemail = "SELECT * FROM usuarios WHERE id= '".addslashes($_SESSION['id'])."'";
 	$sqlemail = $pdo->query($sqlemail);

 	if ($sqlemail->rowCount() >0) {
 		$info = $sqlemail->fetch();
 		$emailusuario = $info['email'];
 	}
 	?>
<?php
if (empty($_POST['nome2']) == false ) {
	$nome = addslashes($_POST['nome2']); 
	$tipobacklink = addslashes($_POST['selecao']);
	$url = addslashes($_POST['url2']);
	$indexacao = addslashes($_POST['indexacao2']);
	$projeto = addslashes($_POST['projeto2']);
	$status = addslashes($_POST['status2']);
	$proxy = addslashes($_POST['proxy2']);



	$nome = strtoupper($nome);
	$tipobacklink = strtoupper($tipobacklink);
	$indexacao = strtoupper($indexacao);
	$projeto = strtoupper($projeto);
	$status = strtoupper($status);
	$proxy =strtoupper($proxy);

	$sql_cadastrar = "SELECT * FROM controle WHERE nome = '$nome' AND  url = '$url'";

	$sql_cadastrar = $pdo->query($sql_cadastrar);

	if ($sql_cadastrar->rowCount() <= 0) {

		$sql_cadastrar = "INSERT INTO controle (nome, url, tipo_backlink, indexado, projeto, status, proxy) VALUES ('$nome', '$url', '$tipobacklink', '$indexacao', '$projeto', '$status', '$proxy')";
		$sql_cadastrar = $pdo->query($sql_cadastrar);

		header("Location: index.php");		

		/*$sql_cadastrar->bindValue(":nome", $nome);
		$sql_cadastrar->bindValue(":url", $url);
		$sql_cadastrar->bindValue(":tipobacklink", $tipobacklink);
		$sql_cadastrar->bindValue(":indexacao", $indexacao);
		$sql_cadastrar->bindValue(":projeto", $projeto);
		$sql_cadastrar->bindValue(":status", $status);
		$sql_cadastrar->bindValue(":proxy", $proxy);
		$sql_cadastrar->execute();*/
	} else {
		echo "ERRO";
	}	
}
	/*
	*Selecionar cadastro logado e pegar o valor no status
	*
	*/
	$sql_confirmar = "SELECT * FROM usuarios WHERE email = '$emailusuario'";
	$sql_confirmar = $pdo->query($sql_confirmar);

	if ($sql_confirmar->rowCount() > 0) {
		$sql_confirmar = $sql_confirmar->fetch();
		$status_usuario = $sql_confirmar['status'];
	}

	if ($status_usuario <> 0) {

		$teste = "";

	} else {
		$teste = "Acesse seu e-mail e clique no link para confirmar seu cadastro";

	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sitema SEO</title>
		<meta name="viewport" content="width=device-width, initial-scale = 1" />
		<link rel="stylesheet" type="text/css" href="assets/css/style-index.css" />
	</head>
	<body>
		<?php if ($status_usuario <> 1) {
			?>
			<div class="aviso">
				<div class="container container-aviso">
					<h4><span>Atenção!</span> Acesse seu e-mail e clique no link para confirmar seu cadastro</h4>
				</div>
			</div>
			<?php
			}
		?>
		<header>
			<div class="header">
				<div class="container topo">
					<div class="logo">
						<a href="index.php"><img src="assets/images/logo.png" border="0" width="75" /></a>
					</div>
					<nav>
						<ul>
							<li><a href="index.php#bg"><button class="button">Adicionar<img src="assets/images/adicionar.png" border="0" height="20"></button></a></li>
							<li><input type="search" class="search" placeholder="Buscar" /></li>
							<li><img src="assets/images/usuario_logado.png" border="0" height="30">&nbsp&nbsp<span><?php echo $emailusuario ?></span></li>
							<li><a href="sair.php"><img src="assets/images/sair.png" border="0" height="30" /></a></li>
						</ul>
					</nav>
				</div>
		 	</div>
		</header>		
		<aside>
			<div class="container aside">
				<div id="bg">										
				</div>
				<div class="box">
					<div class="bg-title">
						<h2>Cadastrar Novo Domínio</h2>
						<a href="index.php" id="close">X</a>
					</div>
					<div class="bg-body">
						
						<form method="POST" class="table_body_cadastrar">
							<div class="table_body_1">
								<div class="item1">
									<div>
									Nome:</br>
										<input type="text" name="nome2" autofocus class="input_nome" /></br></br>
									</div>								    
								</div>
								<div class="item2">
									<div>
										Tipo de backlink:</br>
										<select class="tipo_select" name="selecao">
											<option value="PBN">PBN</option>
											<option value="WEB 2.0 NOVA">WEB 2.0 NOVA</option>
											<option value="WEB 2.0 EXPIRADA">WEB 2.0 EXPIRADA</option>
										</select>
									</div>
								</div>								
							</div>
							<div class="item3">
								<div>
									URL:</br>
									<input type="url" name="url2" class="iput_url" /></br></br>
								</div>
							</div>
							<div class="table_body_1">
								<div class="item2-1">
									<div>
										Indexado?</br>
										<select class="tipo_select2" name="indexacao2">
											<option value="SIM">SIM</option>
											<option value="NÃO">NÃO</option>
										</select>
									</div>								    
								</div>
								<div class="item2-2">
									<div class="pading">
										Projeto:</br>
									<input type="text" name="projeto2" class="input_projeto" /></br></br>
									</div>
								</div>
								<div class="item2-3">
									<div>
										Status:</br>
										<select class="tipo_select3" name="status2">
											<option value="ATIVO">ATIVO</option>
											<option value="INATIVO">INATIVO</option>
										</select>
									</div>
								</div>
								<div class="item2-4">
									<div>
										Proxy: </br>
										<input type="text" name="proxy2" class="input_proxy"/>
									</div>
								</div>								
							</div>
							<div class="cadastre">
						    	<a href="index.php"><input type="submit" value="CADASTRAR" class="button_cadastrar"></a>
							</div>
						</form>						
					</div>								
				</div>
				<div class="table">
					<div class="titletable"> Controle de Domínios</div>
					<div class="filtro">
						Filtro por tipo</br>
					</div>
					<form method="GET">
						<select name="ordem" onchange="this.form.submit()">
					 		<option></option>
					 		<option value="PBN" <?php echo($ordem == "PBN")?'selected="selected"':''; ?>>PBN</option>
					 		<option value="WEB 2.0 EXPIRADA" <?php echo($ordem == "WEB 2.0 EXPIRADA")?'selected="selected"':''; ?>>Web 2.0 Expirada</option>
					 		<option value="WEB 2.0 NOVA" <?php echo($ordem == "WEB 2.0 NOVA")?'selected="selected"':''; ?>>Web 2.0 Nova</option>
					 	</select>
					</form></br>
					
					<table class="format_table">
					 	<tr>
					 		<th>Nome</th>
					 		<th>URL</th>
					 		<th>Tipo de Backlink</th>
					 		<th>Indexado?</th>
					 		<th>Projeto</th>
					 		<th>Status</th>
					 		<th>Proxy</th>
					 	</tr>
					 	<?php
					 	$sql = $pdo->query($sql);
					 	if ($sql->rowCount() > 0) {
					 			
					 		foreach ($sql->fetchAll() as $dado):
					 			?>

					 			<tr>
					 				<td><?php echo $dado['nome']; ?></td>
					 				<td><a href="<?php echo $dado['url']; ?>" target="_blank"><?php echo $dado['url']; ?></a></td>
					 				<td><?php echo $dado['tipo_backlink']; ?></td>
					 				<td><?php echo $dado['indexado']; ?></td>
					 				<td><?php echo $dado['projeto']; ?></td>
					 				<td><?php echo $dado['status']; ?></td>
					 				<td><?php echo $dado['proxy']; ?></td>
					 			</tr>

					 			<?php
					 		endforeach;
					 	}
					 	?> 		
					</table>
					 	<?php	

					}else {
					 	header("Location: login.php");
					}

					if (empty($_SESSION['id'])) {
						header("Location: login.php");
						exit;
					}				
					?>
				</div>
			</div>
		</aside>
	</body>
</html>
