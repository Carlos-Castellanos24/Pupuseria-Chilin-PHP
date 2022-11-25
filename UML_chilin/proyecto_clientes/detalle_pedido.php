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

	<!-- Modals necesarios para el usuario -->
	<?php include 'estructura/modals.php'; ?>

	<!-- carrito de compras para el usuario -->
	<?php include 'estructura/sidebar.php'; ?>

<?php comprobar_sesion(); ?>

	<div class="controles">
	 <h2 class="informacion_pedido">Estimado/a <?php echo strtoupper($_SESSION['nombre']);?>, por favor confirme el resumen de su pedido para llevar:</h2>
 </div>

	<div class="contenedor">
		<form method="POST" action="facturacion.php">
   <div class="form-group confims">
	   <div class="form-two confirmas">
	  			<i class="far fa-calendar-alt"></i><input type="date" name="fecha" value="<?= $_POST['fecha'] ?>" readonly="on" />
	   </div>

	   <div class="form-two confirmas">
	  			<i class="fas fa-clock"></i><input type="time" name="hora" value="<?= $_POST['hora'] ?>" readonly="on" />
	   </div>
   </div>

		<div class="detalles_productos">
		<table>
			<thead>
			<tr>
				<th>Cant</th>
				<th>Nombre</th>
				<th>Unitario</th>
				<th>Afectas</th>
			</tr>
			</thead>
			<tbody>
				<?php foreach ($_SESSION["carrito"] as $producto): ?>
				<tr>
					<td><?php echo $producto['cantidad']; ?></td>
					<td><?php echo $producto['producto']; ?></td>
					<td>$<?php echo number_format($producto['precio'], 2); ?></td>
					<td>$<?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>

   <div class="form-group">
	   <div class="form-two factr">
	   	Número de <br/> productos:
	   	<?php $tot_cant=0; foreach ($_SESSION["carrito"] as $producto):	$tot_cant += $producto['cantidad']; endforeach ?>
	   	<?= $tot_cant ?>
	   </div>

	   <div class="form-two factl">
   	<?php $tot_pag=0; foreach ($_SESSION["carrito"] as $producto):	$tot_pag += number_format($producto['precio'] * $producto['cantidad'], 2); endforeach; $tot_pag =number_format($tot_pag, 2); ?>
	   	Suma: $<?= $tot_pag ?><br/>Venta Total: $<?= $tot_pag ?>
	   </div>
   </div>
		</div>

		<div class="enviar confrm_pedido">
			<button type="submit" id="envio">Confirmar pedido<br/>Obtener factura digital</button>
		</div>
	</form>


	<a href="index.php" class="volver">Atrás, anular proceso de pedido</a>
	</div>
</div>

 <!-- Estructura interna de footer -->
 <?php include 'estructura/footer.php'; ?>
 <!-- Estructura interna de script -->
 <?php include 'estructura/script.php'; ?>
</body>

</html>
