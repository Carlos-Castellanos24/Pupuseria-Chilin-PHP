<?php 	
require_once 'config/config.php';
	$conexion = conexion($bd_config);
	$statement = $conexion->prepare('SELECT * FROM vw_clientes');
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
		<center><h1>CLIENTES</h1></center>
		<br>
		<table>
			<thead>
			<tr>
				<th></th>
				<th>Nombre</th>
				<th>Apellido</th>
				<th>DUI</th>
				<th>Telefono</th>
				<th>Fecha nacimiento</th>
				<th>Email</th>
				<th>Dirección</th>
				<th>Sexo</th>
				<th>Estado</th>
			</tr>
			</thead>
			<tbody>
				<?php foreach ($resultado as $cliente): ?>
				<tr>
					<td><?php echo $cliente['id_cliente']; ?></td>
					<td><?php echo $cliente['nombre_cliente']; ?></td>
					<td>
					<?php if ($cliente['apellido_cliente'] > '0'): ?>
							<?php echo $cliente['apellido_cliente']; ?>
							<?php else: ?>
								<?= "No disponible" ?>
						<?php endif ?>
					<td>
						<?php if ($cliente['dui'] > '0'): ?>
							<?php echo $cliente['dui']; ?>
							<?php else: ?>
								<?= "No disponible" ?>
						<?php endif ?>
						</td>
					<td><?php echo $cliente['telefono']; ?></td>
					<td>
							<?php if ($cliente['nacimiento'] != '0000-00-00'): ?>
							<?php echo $cliente['nacimiento']; ?>
							<?php else: ?>
								<?= "No disponible" ?>
						<?php endif ?>
							
						</td>
					<td>
							<?php if ($cliente['correo'] > '0'): ?>
							<?php echo $cliente['correo']; ?>
							<?php else: ?>
								<?= "No disponible" ?>
						<?php endif ?>
							
						</td>
						<td>
							<?php if ($cliente['direccion'] > '0'): ?>
							<?php echo $cliente['direccion']; ?>
							<?php else: ?>
								<?= "No disponible" ?>
						<?php endif ?>
							
						</td>
					<td><?php if ($cliente['apellido_cliente'] != '0'): ?>
									<?php 	if($cliente['sexo'] == 'F'): ?>
											<?= "Femenino" ?>
									<?php	else: ?>	
											<?= "Masculino" ?>
									<?php endif ?>
							<?php else: ?>
								<?= "No disponible" ?>
						<?php endif ?>	
					</td>
					<td class="estado">
						<?php if ($cliente['estado_cliente'] == 'A'): ?>
							<?= "Activo";  ?>	
						<?php else: ?>	
							<?= "Inactivo"; 	 ?>
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
















