<?php 
require_once '../config/config.php';

	$conexion = conexion($bd_config);

try {
	$statement = $conexion->prepare('call eliminar_producto(:id)');
	$statement->execute(array(':id'=>$_GET['producto']));
	$resultado = $statement->fetch();	

	header('Location: ../productos.php');

} catch (Exception $e) {
	header('Location: ../index.html');
}	

?>