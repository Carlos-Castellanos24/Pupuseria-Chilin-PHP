<?php 	
	require_once 'config/config.php';
	$conexion = conexion($bd_config);
	$statement = $conexion->prepare('SELECT * FROM vw_comentario WHERE tipo_cometario="B" ');
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
	<center><h1>COMENTARIOS BUENOS</h1></center>
	<br>
	<table>
		<thead>
			<tr>
			<th></th>
			<th>Cliente</th>
			<th>Asunto</th>
			<th>Comentario</th>
			<th>Fecha</th>
			<th>Estado</th>	
			</tr>			
		</thead>
		<tbody>
			<?php foreach ($resultado as $comentario): ?>
				<tr>
					<td><?php echo $comentario['id_comentario']; ?></td> 
					<td><?php echo $comentario['nombre_cliente']; ?></td>
					<td><?php echo $comentario['asunto']; ?></td>
					<td><?php echo $comentario['comentario']; ?></td>
					<td><?php echo $comentario['fecha']; ?></td>
					<td>
					<?php if ($comentario['estado_comentario']=='A'): ?>
							<?= "No leído" ?>
						<?php else: ?>
							<?= "Leído" ?>
						<?php endif ?></td>
						<td>
						<a class="editar" href="procesos/comentario_borrar.php?id=<?php echo $comentario['id_comentario']; ?>&estado=<?php echo $comentario['estado_comentario']; ?>">Cambiar estado</a>
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