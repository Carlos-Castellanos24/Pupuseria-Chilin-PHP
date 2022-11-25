<?php
require_once 'config/config.php';

try {
	$conexion = conexion($bd_config);
	$statement = $conexion->prepare('SELECT * FROM vw_productos');
$statement->execute();
$resultado = $statement->fetchAll();
} catch (Exception $e) {
	header('Location: /index.html');
}
?>

<!doctype html>
	<!-- Estructura interna del meta -->
<?php include 'estructura/meta.php'; ?>

<body>
	<!-- Estructura interna del header -->
	<?php include 'estructura/header.php'; ?>

<div class="contenido">

	<a class="agregar" href="procesos/producto_agregar.php">Agregar producto</a>

<table>
	<thead>
	<tr>
		<th></th>
		<th>Categoria</th>
		<th>Producto</th>
		<th>Fecha de ingreso</th>
		<th>Fecha de vencimiento</th>
		<th>Costo</th>
		<th>Precio</th>
		<th>Foto</th>
		<th>Estado</th>
		<th></th>
		<th></th>
	</tr>
	</thead>
	<tbody>
		<?php foreach ($resultado as $productos): ?>
		<tr>
			<td><?php echo $productos['id_producto']; ?></td>
			<td><?php echo $productos['nombre_categoria']; ?></td>
			<td><?php echo $productos['nombre_producto']; ?></td>
			<td><?php if ($productos['fecha_ingreso'] > 0): echo $productos['fecha_ingreso']; else: echo 'No disponible'; endif ?> </td>
			<td><?php if ($productos['fecha_vencimiento'] > 0): echo $productos['fecha_vencimiento']; else: echo 'No disponible'; endif ?> </td>
			<td>$<?php echo $productos['costo']; ?></td>
			<td>$<?php echo $productos['precio']; ?></td>
			<td class="foto">
				<img class="producto" src="../proyecto_clientes/productos/<?php echo $productos['foto']; ?>" alt="chilin">
			</td>
			<td class="estado">
				<?php 
				if ($productos['estado_producto'] == 'A') {
					echo 'Activo';
				} else {
					echo 'Inactivo';
				}
				?>
			</td>
			<td><a class="editar" href="procesos/producto_editar.php?producto=<?php echo $productos['id_producto']; ?>">Editar</a></td>
			<td><a class="borrar" href="procesos/producto_borrar.php?producto=<?php echo $productos['id_producto']; ?>">Borrar</a></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>

</div>

</div>



 <!-- Estructura interna del footer -->
	<?php include 'estructura/footer.php'; ?>

 <!-- Estructura interna del script -->
	<?php include 'estructura/script.php'; ?>
</body>

</html>
















