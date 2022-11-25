<?php 
require_once '../config/config.php';

$conexion = conexion($bd_config);

if ($_GET['estado'] == 'A') {
	$estado_nuevo = 'I';
}else {
	$estado_nuevo = 'A';
}

try {
	$statement = $conexion->prepare('call cambiar_categoria(:cambio,:id)');
	$statement->execute(array(':cambio'=> $estado_nuevo,':id'=>$_GET['id']));
	$resultado = $statement->fetch();	

	header('Location: ../categoria.php');

} catch (Exception $e) {
	header('Location: ../index.html');
}	

?>