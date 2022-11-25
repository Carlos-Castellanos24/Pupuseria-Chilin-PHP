<?php 	
	require_once 'config/config.php';
	$conexion = conexion($bd_config);
	$statement = $conexion->prepare('SELECT * FROM vw_pedido');
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
	<center><h1>LISTADO DE PEDIDOS</h1></center>
	<br>
	<table>
		<thead>
			<tr>
			<th>Correlativo</th>
			<th>Cliente</th>
			<th>Producto</th>
			<th>Cantidad</th>
			<th>Estado</th>	
			</tr>			
		</thead>
		<tbody>
			<?php foreach ($resultado as $pedidos): ?>
				<tr>
					<td><?php echo $pedidos['correlativo']; ?></td>
					<td><?php echo $pedidos['nombre_cliente']; ?></td>
					<td><?php echo $pedidos['nombre_producto']; ?></td>
					<td><?php echo $pedidos['cantidad']; ?></td>
					<td class="estado"><?php if ($pedidos['estado_factura'] == 'I'): echo 'Finalizado'; else: echo 'Pendiente'; endif ?>
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






