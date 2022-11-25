<?php
require_once 'config/config.php';
require_once 'config/funciones.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <!-- Estructura interna del meta -->
  <?php include 'estructura/meta.php'; ?>
</head> 
<body>
<div class="contenido">
	<?php include 'estructura/header.php'; ?>
	<?php
	comprobar_sesion();

	$cliente = conexion($bd_config)->prepare("call buscar_cliente(:id)");
	$cliente->execute(array(':id'=>$_SESSION['cliente']));
	$contenido_cliente = $cliente->fetch();

	$comentario = conexion($bd_config)->prepare("call buscar_comentario(:id_comentario)");
	$comentario->execute(array(':id_comentario'=>$_POST['id_comentario']));
	$contenido_comentario = $comentario->fetch();

	?>
	<div class="contenedor">
		<div class="detalles_productos factura">
			<div class="factura_encabezado">
				<p>Comentario: <?= $_POST['id_comentario'] ?></p>
				<p>Cliente: <?= $contenido_cliente['nombre_cliente'] . ' ' . $contenido_cliente['apellido_cliente'] ?></p>
				<p>Fecha: <?= $contenido_comentario['fecha'] ?></p>
				<p>Tipo comentario: <?= $_POST['tipo_cometario'] ?></p> 
			</div>

			<div class="factura_encabezado">
				<p>Asunto:<br/><div class="contenido_mensaje"><?= $contenido_comentario['asunto'] ?></div></p>
				<p>Comentario:<br/><div class="contenido_mensaje"><?= $contenido_comentario['comentario'] ?></div></p>
			</div>

			<div class="factura_encabezado">
				<p>Estado: <?= $_POST['estado_comentario'] ?></p>
			</div>
			
	<a href="comentarios.php" class="volver bgsolido">Volver al inicio</a>
	
	</div>
</div>

 <!-- Estructura interna de footer -->
 <?php include 'estructura/footer.php'; ?>
 <!-- Estructura interna de script -->
 <?php include 'estructura/script.php'; ?>
</body>

</html>
