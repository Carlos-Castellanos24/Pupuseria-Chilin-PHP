<?php
require_once '../config/config.php';

$conexion = conexion($bd_config);

if($_SERVER['REQUEST_METHOD']=='POST'){

	 if(is_uploaded_file($_FILES['img']['tmp_name'])) { 
	 $categoria   = $_POST['categoria'];
	 $producto    = $_POST['producto'];
	 $ingreso     = $_POST['ingreso'];
	 $vencimiento = $_POST['vencimiento'];
	 $costo       = $_POST['costo'];
	 $precio      = $_POST['precio'];
	 $estado      = $_POST['estado'];

	 if ($_FILES["img"]["type"]=="image/jpeg"|| $_FILES["img"]["type"]=="image/jpg" || $_FILES["img"]["type"]=="image/png"){

	 // Manejo de la imagen para el producto
  $ruta = "../../proyecto_clientes/productos/"; 
	 $nombrefinal	= str_replace(" ", "", $_FILES['img']['name']);  //Eliminamos los espacios en blanco
	 $upload = $ruta . $nombrefinal;

	 // Movemos el archivo a la direccion correspondiente
		if(move_uploaded_file($_FILES['img']['tmp_name'], $upload)) {

	 try {
	 $statement=$conexion->prepare('call agregar_producto(:id_categoria,:nombre_producto,:fecha_ingreso,:fecha_vencimiento,:costo,:precio,:foto,:estado_producto)');
	 $statement->execute(array(
	  ':id_categoria'=>$categoria,
	  ':nombre_producto'=>$producto,
	  ':fecha_ingreso'=>$ingreso,
	  ':fecha_vencimiento'=>$vencimiento,
	  ':costo'=>$costo,
	  ':precio'=>$precio,
	  ':foto'=>$nombrefinal,
	  ':estado_producto'=>$estado)
		);
	 header('location: ../productos.php?datos=on');

	 } catch (Exception $e) {
	  header('location: ../productos.php?error=on');
	 }
	}

		}else{
			header('location: producto_agregar.php?error=on');
		}
	}
}

try {
	// Falta PA
	$statement = $conexion->prepare('SELECT * FROM categoria');
	$statement->execute();
	$resultado = $statement->fetchAll();	
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