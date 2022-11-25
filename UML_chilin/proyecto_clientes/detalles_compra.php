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

	$pedido = conexion($bd_config)->prepare("call listar_pedido(:correlativo)");
	$pedido->execute(array(':correlativo'=>$_POST['correlativo']));
	$contenido_pedido = $pedido->fetchAll();

	?>
	<div class="contenedor">
		<div class="detalles_productos factura">
			<div class="factura_encabezado">
				<p>Factura: <?= $_POST['id_factura'] ?></p>
				<p>Cliente: <?= $contenido_cliente['nombre_cliente'] ?> <?php if ($contenido_cliente['apellido_cliente'] > '0'): echo $contenido_cliente['apellido_cliente']; ?>
					
				<?php endif ?></p>
				<p>Fecha: <?= $_POST['fecha'] ?></p>
				<hr/>
				<p class="descr">Comer en pupuseria, factura digital.</p>
				<hr/>
			</div>

		<table>
			<thead>
			<tr>
				<th>Cant</th>
				<th>Descripcion</th>
				<th>Unitario</th>
				<th>Afectas</th>
			</tr>
			</thead>
			<tbody>
				<?php foreach ($contenido_pedido as $producto): ?>
				<tr>
					<td><?php echo $producto['cantidad']; ?></td>
					<td><?php echo $producto['nombre_producto']; ?></td>
					<td>$<?php echo number_format($producto['precio'], 2); ?></td>
					<td>$<?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>

	<div class="factura_encabezado">

  <div class="form-group">
   <div class="form-two factr fot"><p class="fotdet">Sub total:</p></div><div class="form-two factl"><p class="fotdet">$<?= $_POST['total_pagar'] ?></p></div>
  </div>

  <div class="form-group">
   <div class="form-two factr fot"><p class="fotdet">Total a pagar:</p></div><div class="form-two factl"><p class="fotdet">$<?= $_POST['total_pagar'] ?></p></div>
  </div>

		<p class="descr fot">Numero de productos: 
 	<?php $tot_cant=0; foreach ($contenido_pedido as $producto):	$tot_cant += $producto['cantidad']; endforeach ?>
 	<?= $tot_cant ?>
		</p>
		<hr/>

	<div class="factura_encabezado">
		<p>Estado factura de la compra: 
			<?php if ($_POST['estado_factura'] == 'A'): ?> 
				Activo
			<?php elseif ($_POST['estado_factura'] == 'I'): ?>
				Abonado
			<?php else: ?>
				Pendiente
			<?php endif ?>
		</p>
	</div>

	</div>



	<a href="compras.php" class="volver bgsolido">Volver al inicio</a>
	</div>
</div>

 <!-- Estructura interna de footer -->
 <?php include 'estructura/footer.php'; ?>
 <!-- Estructura interna de script -->
 <?php include 'estructura/script.php'; ?>
</body>

</html>
