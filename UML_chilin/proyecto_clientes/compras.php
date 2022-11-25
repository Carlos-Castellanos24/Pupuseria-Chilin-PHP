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
	
	$obtener_pedido = conexion($bd_config)->prepare("call obtener_factura(:id)");
	$obtener_pedido->execute(array(':id'=>$_SESSION['cliente']));
	$cargar_pedido = $obtener_pedido->fetchAll();
?>

	<div class="controles">
	 <h2 class="informacion_pedido">Hola <?php echo strtoupper($_SESSION['nombre']);?>, en este apartado, puedes ver el historial de las compras realizadas en nuestra pupuseria.
 </div>
	<div class="contenedor">

		<div class="compras">

			<?php if (count($cargar_pedido) > 0): ?>
			<?php foreach ($cargar_pedido as $factura): ?>
					<form action="detalles_compra.php" method="POST">
							<div class="compra_informacion">
					   <div class="form-group compra">
						   <div class="form-two factr"><?= $factura['id_factura'] ?></div>
						   <div class="form-two factl"><?php echo $factura['fecha'] . " " . $factura['hora']; ?></div>
						   <div class="form-two factr">Para llevar</div>
						   <div class="form-two factl">Pago total: $<?= $factura['total_pagar'] ?></div>
						   <div class="form-two cmprlf">
						   	Estado:
										<?php if ($factura['estado_factura'] == 'A'): ?> 
											Activo
										<?php elseif ($factura['estado_factura'] == 'I'): ?>
											Abonado
										<?php else: ?>
											Pendiente
										<?php endif ?>
						   	</div>
						   <div class="form-two cmprrg"><button type="submit"><i class="fas fa-plus-circle"></i></button></div>
						   <input type="hidden" name="id_factura" value="<?= $factura['id_factura'] ?>">
						   <input type="hidden" name="correlativo" value="<?= $factura['correlativo'] ?>">
						   <input type="hidden" name="total_pagar" value="<?= $factura['total_pagar'] ?>">
						   <input type="hidden" name="estado_factura" value="<?= $factura['estado_factura'] ?>">
						   <input type="hidden" name="fecha" value="<?= $factura['fecha'] . ' ' . $factura['hora']; ?>">
					   </div>
							</div>
						</form>
			<?php endforeach ?>
			<?php else: ?>
				<div class="compra_informacion">
		   <div class="form-group compra vacio">
		   	<?php echo strtoupper($_SESSION['nombre']);?>, usted aún no ha hecho ninguna compra en nuestra pupuseria.
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
