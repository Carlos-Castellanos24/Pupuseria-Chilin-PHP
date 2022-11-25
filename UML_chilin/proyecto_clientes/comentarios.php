<?php
session_start();
error_reporting(0);
require_once 'config/config.php';
require_once 'config/funciones.php';
comprobar_sesion();
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

	<!-- Modals necesarios para el usuario -->
	<?php include 'estructura/modals.php'; ?>

	<!-- carrito de compras para el usuario -->
	<?php include 'estructura/sidebar.php'; ?>

<?php
	comprobar_sesion();

	$obtener_comentario = conexion($bd_config)->prepare("call buscar_comentario_cliente(:id)");
	$obtener_comentario->execute(array(':id'=>$_SESSION['cliente']));
	$cargar_comentario = $obtener_comentario->fetchAll();
?>

	<div class="controles">
	 <h2 class="informacion_pedido">Hola <?php echo strtoupper($_SESSION['nombre']);?>, en este apartado, puede ver el historial de los comentarios realizadas a nuestra pupuseria.
 </div>
	<div class="contenedor">

		<div class="compras">

			<?php if (count($cargar_comentario) > 0): ?>
			<?php foreach ($cargar_comentario as $comentario): ?>
					<form action="detalles_comentario.php" method="POST">
							<div class="compra_informacion">
					   <div class="form-group compra">
						   <div class="form-two factr"><?= $comentario['id_comentario'] ?></div>
						   <div class="form-two factl"><?php echo $comentario['fecha']; ?></div>
						   <?php
						   if ($comentario['tipo_cometario'] == 'B'){	$tipo_comentario = "Bueno";
						  	} elseif ($comentario['tipo_cometario'] == 'R'){ $tipo_comentario = "Reclamo";
						   }else{	$tipo_comentario = "Malo"; } ?>
						   <?php
						   if ($comentario['estado_comentario'] == 'A'){ $estado = "No leído";
						  	}else{	$estado = "leído"; } ?>
						   <div class="form-two factr">Tipo: <?= $tipo_comentario ?> </div>
						   <div class="form-two factl">Estado: <?= $estado ?></div>
						   <div class="form-two cmprlf">Asunto: <?= $comentario['asunto'] ?></div>
						   <div class="form-two cmprrg"><button type="submit"><i class="fas fa-plus-circle"></i></button></div>
						   <input type="hidden" name="id_comentario" value="<?= $comentario['id_comentario'] ?>">
						   <input type="hidden" name="tipo_cometario" value="<?= $tipo_comentario ?>">
						   <input type="hidden" name="estado_comentario" value="<?= $estado ?>">
					   </div>
							</div>
						</form>
			<?php endforeach ?>
			<?php else: ?>
				<div class="compra_informacion">
		   <div class="form-group compra vacio">
		   	<?php echo strtoupper($_SESSION['nombre']);?>, usted aún no ha hecho ningún comentario en nuestra pupuseria.
		   </div>
				</div>
			<?php endif ?>

		</div>




	<a href="index.php" class="volver bgsolido">Volver al inicio</a>
	</div>
</div>

 <!-- Estructura interna de footer -->
 <?php include 'estructura/footer.php'; ?>
 <!-- Estructura interna de script -->
 <?php include 'estructura/script.php'; ?>
</body>

</html>
