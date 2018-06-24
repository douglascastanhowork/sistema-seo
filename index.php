<?php
 session_start();

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
 	?>
	Filtro por tipo </br>
 	<form method="GET">
 		<select name="ordem" onchange="this.form.submit()">
 			<option></option>
 			<option value="PBN" <?php echo($ordem == "PBN")?'selected="selected"':''; ?>>PBN</option>
 			<option value="WEB 2.0 EXPIRADA" <?php echo($ordem == "WEB 2.0 EXPIRADA")?'selected="selected"':''; ?>>Web 2.0 Expirada</option>
 			<option value="WEB 2.0 NOVA" <?php echo($ordem == "WEB 2.0 NOVA")?'selected="selected"':''; ?>>Web 2.0 Nova</option>
 		</select>
 	</form>
 	<table border="1" width="100%">
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
 					<td><?php echo $dado['url']; ?></td>
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

 } else {
 		header("Location: login.php");
 	}

require 'config.php';

if (empty($_SESSION['id'])) {
	header("Location: login.php");
	exit;
}

$email = '';
$sql = "SELECT * FROM usuarios WHERE id= '".addslashes($_SESSION['id'])."'";
$sql = $pdo->query($sql);

if ($sql->rowCount() > 0) {
	$info = $sql->fetch();
	$email = $info['email'];
}

?>
<p>Usuário: <?php echo $email ?> - <a href="sair.php">Sair</a> </p>
