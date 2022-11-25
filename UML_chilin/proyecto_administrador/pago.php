<?php 
	require_once 'config/config.php';
	$conexion = conexion($bd_config);
	$statement = $conexion->prepare('SELECT * FROM vw_pago');
	$statement->execute();
	$resultado = $statement->fetchAll();

?>
<!doctype html>
	<!-- Estructura interna del meta -->
	<?php include 'estructura/meta.php'; ?>

<body>
	<!-- Estructura interna del header -->
	<?php include 'estructura/header.php'; ?>
<div class="contenido">
	<center><h1>PROCESAR PAGO DE PEDIDO</h1></center>

<form action="pago_factura.php" method="post">
	<div class="proceso_factura">
		<label for="id_factura">Ingrese el ID de la factura: </label>
		<input type="number" name="id_factura" id="id_factura" required="on">
		<button type="submit">Procesar pago</button>
	</div>
</form>

	<br>
	<center><h1>PAGOS</h1></center>
	<br>
	<table>
		<thead>
			<tr>
			<th>Pago</th>
			<th>Factura</th>
			<th>Cliente</th>
			<th>Fecha</th>
			<th>Total a pagar</th>
			<th>Pago del cliente</th>
			<th>Vuelto</th>
			<th>Estado</th>
			</tr>			
		</thead>
		<tbody>
			<?php foreach ($resultado as $pago): ?>
				<tr>
					<td><?php echo $pago['id_pago']; ?></td> 
					<td><?php echo $pago['id_factura']; ?></td>
					<td><?php echo $pago['nombre_cliente']; ?></td>
					<td><?php echo $pago['fecha']; ?></td>
					<td>$<?php echo $pago['total_pagar']; ?></td>
					<td>$<?php echo $pago['pago_cliente']; ?></td>
					<td>$<?php echo $pago['vuelto']; ?></td>
					<td class="estado">
						<?php if ($pago['estado_pago'] == 'P'): ?>
							Pendiente
							<?php else: ?>
							Abonado
						<?php endif ?>
						</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

</div>
 <!-- Estructura interna del footer -->
	<?php include 'estructura/footer.php'; ?>

 <!-- Estructura interna del script -->
	<?php include 'estructura/script.php'; ?>
</body>

</html>

