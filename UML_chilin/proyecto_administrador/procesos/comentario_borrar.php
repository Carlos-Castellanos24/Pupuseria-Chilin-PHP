<?php 
require_once '../config/config.php';

$conexion = conexion($bd_config);

if ($_GET['estado'] == 'A') {
	$estado_nuevo = 'I';
}else {
	$estado_nuevo = 'A';
}

try {
	//call cambiar_comentario(:cambio,:id)
	//UPDATE comentario SET estado_comentario=:cambio where id_comentario=:id
	$statement = $conexion->prepare('call cambiar_comentario(:cambio,:id)');
	$statement->execute(array(':cambio'=> $estado_nuevo,':id'=>$_GET['id']));
	$resultado = $statement->fetch();	

	header('Location: ../comentario.php');

} catch (Exception $e) {
	header('Location: ../index.html');
}	

?>