<?php
 session_start();

 if (isset($_SESSION['id']) && empty($_SESSION['id']) == false) {
 	echo "Área Restrita...";
 } else {
 	header("Location: login.php");
 }


?>