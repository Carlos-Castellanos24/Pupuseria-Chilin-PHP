<?php
require_once 'config/config.php';

	$conexion = conexion($bd_config);
	$statement = $conexion->prepare('SELECT * FROM vw_categoria');
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
	<center><h1>CATEGORIAS</h1></center>
	<br>
	<table class="short">
		<thead>
		<tr>
			<th></th>
			<th>Nombre</th>
			<th>Estado</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
			<?php foreach ($resultado as $categoria): ?>
			<tr>
				<td><?php echo $categoria['id_categoria']; ?></td>
				<td><?php echo $categoria['nombre_categoria']; ?></td>
				<td class="estado">
					<?php if ($categoria['estado_categoria'] == 'A'): ?>
						<?= "Activo" ?>
					<?php else: ?>
						<?= "Inactivo" ?>
					<?php endif ?>
					</td>
				<td><a class="editar" href="procesos/categoria_borrar.php?id=<?php echo $categoria['id_categoria']; ?>&estado=<?php echo $categoria['estado_categoria']; ?>">Cambiar estado</a></td>
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
