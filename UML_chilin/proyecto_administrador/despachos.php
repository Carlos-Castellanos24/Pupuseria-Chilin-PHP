<?php 	
require_once 'config/config.php';
	$conexion = conexion($bd_config);
	$statement = $conexion->prepare('SELECT * FROM vw_despacho');
	$statement->execute();
	$resultado = $statement->fetchAll();
?>
<!doctype html>
	<!-- Estructura interna del meta -->
	<?php include 'estructura/meta.php'; ?>

<body>
	<!-- Estructura interna del header -->
	<?php include 'estructura/header.php'; ?>
<br>
	<div class="contenido">
		<center><h1>DESPACHOS</h1></center>
		<br>
		<table>
			<thead>
			<tr>
				<th></th>
				<th>Pago</th>
				<th>Pedido</th>
				<th>Fecha</th>
				<th>Comentario</th>
				<th>Estado</th>
			</tr>
			</thead>
			<tbody>
				<?php foreach ($resultado as $despacho): ?>
				<tr>
					<td><?php echo $despacho['id_despacho']; ?></td>
					<td><?php echo $despacho['id_pago']; ?></td>
					<td><?php echo $despacho['id_pedido']; ?></td>
					<td><?php echo $despacho['fecha']; ?></td>

					<td><?php echo $despacho['comentario']; ?></td>
					
					<td class="estado">
						<?php if ($despacho['estado_despacho'] == 'F'): ?>
							<?= "Finalizado";  ?>	
						<?php else: ?>	
							<?= "Pendiente"; 	 ?>
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
















