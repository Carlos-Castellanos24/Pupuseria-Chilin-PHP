<?php
$bd_config = [
'basedatos' => 'chilin_db', // La base de datos
'usuario' => 'root',        // Usuario
'pass' => ''																// Contraseña
];

function conexion($bd_config){
	try {
	 $conexion =	new PDO('mysql:host=localhost;charset=utf8;dbname='.$bd_config['basedatos'], $bd_config['usuario'], $bd_config['pass']);
	 return $conexion;
	} catch (PDOException $e) {
	 return false;
	}
}
?>
