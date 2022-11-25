<?php
require_once '../config/config.php';

	$conexion = conexion($bd_config);

if($_SERVER['REQUEST_METHOD']=='POST'){
	$id_producto   = $_POST['id_producto'];
 $categoria   = $_POST['categoria'];
 $nombre      = $_POST['nombre'];
 $ingreso     = $_POST['ingreso'];
 $vencimiento = $_POST['vencimiento'];
 $costo       = $_POST['costo'];
 $precio      = $_POST['precio'];
 $stock       = $_POST['stock'];
 $estado      = $_POST['estado'];

 try {
 $statement=$conexion->prepare('call actualizar_producto(:nombre_producto,:fecha_ingreso,:fecha_vencimiento,:costo,:precio,:estado_producto,:id)');
 $statement->execute(array(
  ':nombre_producto'=>$nombre,
  ':fecha_ingreso'=>$ingreso,
  ':fecha_vencimiento'=>$vencimiento,
  ':costo'=>$costo,
  ':precio'=>$precio,
  ':estado_producto'=>$estado,
  ':id'=>$id_producto)
	);

 header('location: ../productos.php?datos=on');

 } catch (Exception $e) {
  header('location: ../productos.php?error=on');
 }
}

try {
	$statement = $conexion->prepare('call producto_completo(:id)');
	$statement->execute(array(':id'=>$_GET['producto']));
	$resultado = $statement->fetch();	
} catch (Exception $e) {
	header('Location: ../index.html');
}

?>

<!doctype html>
<head>
  <meta charset="utf-8">
  <title>Administrador</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">

  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/main.css">
</head>
<body>

<div class="contenido">
<h1>Ingresar productos al sistema</h1>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="insertar" method="post">

	<div class="form-group">

		<label for="categoria">Categoria:</label>
		<input type="hidden" name="id_producto" id="id_producto" value="<?php echo $_GET['producto'] ?>">
		<input type="hidden" name="categoria" id="categoria" value="<?php echo $resultado['id_categoria'] ?>">
		<input type="text" required="on" value="<?php echo $resultado['nombre_categoria'] ?>" readonly="on" >
	</div>

	<div class="form-group">
		<label for="nombre">Nombre del producto:</label>
		<input type="text" name="nombre" id="nombre" required="on" value="<?php echo $resultado['nombre_producto'] ?>">
	</div>

	<?php if ($resultado['id_categoria'] == '3' || $resultado['id_categoria'] == '6'): ?>
	<div class="form-group two">
		<label for="ingreso">Fecha de ingreso: </label>
		<input type="date" name="ingreso" id="ingreso" min="<?= date("Y-m-d"); ?>" value="<?php echo $resultado['fecha_ingreso'] ?>">
	</div>

	<div class="form-group two">
		<label for="vencimiento">Fecha de vencimiento:</label>
		<input type="date" name="vencimiento" id="vencimiento" min="<?= date("Y-m-d"); ?>" value="<?php echo $resultado['fecha_vencimiento'] ?>">
	</div>
	<?php endif ?>

	<div class="form-group four">
		<label for="costo">Costo:</label>
		<input type="number" name="costo" id="costo" required="on" min="0" step="0.01" value="<?php echo $resultado['costo'] ?>" >
	</div>

	<div class="form-group four">
		<label for="precio">Precio:</label>
		<input type="number" name="precio" id="precio" required="on" min="0" step="0.01" value="<?php echo $resultado['precio'] ?>">
	</div>

	<div class="form-group four">
		<center>
		<label for="precio">Foto:</label><br>
		<img class="producto" src="../../proyecto_clientes/productos/<?php echo $resultado['foto']; ?>" alt="chilin">
		</center>
	</div>

	<div class="form-group four">
		<label for="estado">Estado:</label>
		  <select name="estado" id="estado" required="on">
   	<option value="">Seleccione</option>
   	<option value="A">Activo</option>
   	<option value="I">Inactivo</option>
 </select>
	</div>

	<div class="enviar">
		<input type="submit" value="Modificar producto">
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