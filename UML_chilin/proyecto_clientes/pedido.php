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
	 <h2 class="informacion_pedido">Realizo de pedidos a <br/> pupuseria Chilin</h2>
 <span class="control">
	<button type="button" class="btn btn-demo botones carrito" data-toggle="modal" data-target="#myModal2">
		<?php if (isset($_SESSION["carrito"])):	echo count($_SESSION["carrito"]); else:	echo "0"; endif ?> <i class="fas fa-shopping-cart"></i>
	</button>
 </span>
 </div>

	<div class="contenedor">

		<form method="POST" action="detalle_pedido.php">

   <div class="form-group">
	   <div class="form-two">
						<label for="">Fecha: </label>
	  			<input type="date" name="fecha" min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" required="on">
	   </div>

	   <?php 
		   $hora_actual    = date('Y-m-d H:i:s'); 
					$hora_requerida = strtotime ('+2 hour',strtotime($hora_actual)) ; 
					$hora_requerida = date('H:i',$hora_requerida); 

					if (date('H:i') > '12:00' && date('H:i') < '21:00') {	$fecha_minima = $hora_requerida;	} else { $fecha_minima = "12:00";	}
	   ?>

	   <div class="form-two">
						<label for="">Hora: </label>
	  			<input type="time" name="hora" 
	  			min="<?= $fecha_minima ?>"	value="<?= $hora_requerida ?>" max="23:00" required="on" />
	   </div>
   </div>

   <div class="enviar pedido_datos">
    <button type="submit" id="envio">Para llevar</button>

   <div class="pedido_mensaje">
	   <div class="pedido_detalle_icon">
	   	<i class="fas fa-exclamation-circle"></i>
	   </div>
	   <div class="pedido_detalle">
	   	<p>No contamos con servicio a domicilio, usted debe visitarnos para cancelar y retirar su pedido en pupusas Chílin.</p>
	   </div>
   </div>

   </div>

		</form>

	<a href="index.php" class="volver">Volver atrás</a>
	</div>
</div>

 <!-- Estructura interna de footer -->
 <?php include 'estructura/footer.php'; ?>
 <!-- Estructura interna de script -->
 <?php include 'estructura/script.php'; ?>
</body>

</html>
