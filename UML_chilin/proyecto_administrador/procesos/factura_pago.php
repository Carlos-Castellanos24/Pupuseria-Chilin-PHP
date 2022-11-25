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
<h1>Ingresar productos al sistema</h1>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="insertar" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="categoria">Categoria:</label>
  <select name="categoria" id="categoria" required="on" onchange="filtrar(this)"
>
   <option value="">Seleccione</option>
   <?php foreach ($resultado as $categorias): ?>
   	<option value="<?php echo $categorias['id_categoria']; ?>" ><?php echo $categorias['nombre_categoria']; ?></option>
   <?php endforeach ?>
 </select>
	</div>

	<div class="form-group">
		<label for="producto">Nombre del producto:</label>
		<input type="text" name="producto" id="producto" required="on">
	</div>

	<div class="form-group two" id="ingreso_validacion">
		<label for="ingreso">Fecha de ingreso: </label>
		<input type="date" name="ingreso" id="ingreso" min="<?= date("Y-m-d"); ?>" value="0000-00-00">
	</div>

	<div class="form-group two" id="vencimiento_validacion">
		<label for="vencimiento">Fecha de vencimiento:</label>
		<input type="date" name="vencimiento" id="vencimiento" min="<?= date("Y-m-d"); ?>" value="0000-00-00">
	</div>

	<div class="form-group two">
		<label for="costo">Costo:</label>
		<input type="number" name="costo" id="costo" required="on" min="0" value="0" step="0.01">
	</div>

	<div class="form-group two">
		<label for="precio">Precio:</label>
		<input type="number" name="precio" id="precio" required="on" min="0" value="0" step="0.01">
	</div>

	<div class="form-group two">
		<input type="file" name="img" id="img">
	</div>
  
	<div class="form-group two">
		<label for="estado">Estado:</label>
		  <select name="estado" id="estado" required="on">
   	<option value="">Seleccione</option>
   	<option value="A">Activo</option>
   	<option value="I">Inactivo</option>
 </select>
	</div>

	<div class="enviar">
		<input type="submit" value="Guardar producto">
	</div>			

</form>

	<br/><br/><br/>
		<a href="../productos.php">Cancelar, volver atrás</a>

</div>

 <!-- Estructura interna del footer -->
	<?php include '../estructura/footer.php'; ?>

 <!-- Estructura interna del script -->
	<?php include '../estructura/script.php'; ?>
</body>

</html>