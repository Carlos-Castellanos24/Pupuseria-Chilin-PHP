<?php 
	require_once 'config/config.php';
	$conexion = conexion($bd_config);
	$statement = $conexion->prepare('SELECT * FROM vw_factura where estado_factura="I"; ');
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
	<br>
	<center><h1>FACTURAS</h1></center>
	<br>
	<table>
		<thead>
			<tr>
			<th>Factura</th>
			<th>Correlativo</th>
			<th>Cliente</th>
			<th>Fecha</th>
			<th>Hora</th>
			<th>Total a pagar</th>
			<th>Tipo</th>
			<th>Estado</th>	
			</tr>			
		</thead>
		<tbody>
			<?php foreach ($resultado as $factura): ?>
				<tr>
					<td><?php echo $factura['id_factura']; ?></td>
					<td><?php echo $factura['correlativo']; ?></td>
					<td><?php echo $factura['nombre_cliente']; ?></td>
					<td><?php echo $factura['fecha']; ?></td>
					<td><?php echo $factura['hora']; ?></td>
					<td>$<?php echo $factura['total_pagar']; ?></td>
					<td>
						<?php if ($factura['tipo_factura']== 'E'): ?>
							<?= "Electronica" ?>
							<?php else: ?>
							<?= "Impresa" ?>
						<?php endif ?>
						</td>
					<td class="estado">
						<?php if ($factura['estado_factura'] == 'I'): ?>
							<?= "Abonado"?>
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