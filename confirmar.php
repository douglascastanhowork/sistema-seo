<?php
require 'config.php';
$h = $_GET['h'];

if (!empty($h)) {	

	$sql = "UPDATE usuarios SET status = '1' WHERE MD5(id) = '$h'";
	$sql = $pdo->query($sql);

	echo "Cadastro confirmado com sucesso";

	echo '<a href="index.php">Voltar para o sistema</a>';
}
?>