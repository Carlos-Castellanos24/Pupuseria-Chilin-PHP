<?php 	
if($_SERVER['REQUEST_METHOD']=='POST'){

	$Usuario = $_POST['Usuario'];
	$password = $_POST['password'];

	if ($Usuario == "chilin" && $password == "chilin123") {
		header('location:inicio.php');
	} else {
		header('location:index.html');
	}

}else {
	header('location:index.html');
}

?>