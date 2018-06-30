<?php
session_start();
require 'config.php';

if (empty($_POST['nome2']) == false ) {
	$nome = addslashes($_POST['nome2']);
	$tipobacklink = addslashes($_POST['selecao']);
	$url = addslashes($_POST['url2']);
	$indexacao = addslashes($_POST['indexacao2']);
	$projeto = addslashes($_POST['projeto2']);
	$status = addslashes($_POST['status2']);
	$proxy = addslashes($_POST['proxy2']);

	$sql_cadastrar = "SELECT * FROM controle WHERE nome = '$nome' AND  url = '$url'";

	$sql_cadastrar = $pdo->query($sql_cadastrar);

	if ($sql_cadastrar->rowCount() <= 0) {

		$sql_cadastrar = "INSERT INTO controle (nome, url, tipo_backlink, indexado, projeto, status, proxy) VALUES ('$nome', '$url', '$tipobacklink', '$indexacao', '$projeto', '$status', '$proxy')";
		$sql_cadastrar = $pdo->query($sql_cadastrar);		

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
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
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
									<input type="text" name="url2" class="iput_url" /></br></br>
								</div>
							</div>
							<div class="table_body_1">
								<div class="item2-1">
									<div>
										Indexado?</br>
										<select class="tipo_select" name="indexacao2">
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
						    	<input type="submit" value="CADASTRAR" class="button_cadastrar">
							</div>
						</form>	
</body>
</html>