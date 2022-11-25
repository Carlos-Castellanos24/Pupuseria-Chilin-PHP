<?php
require_once 'config/config.php';
require_once 'config/funciones.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <!-- Estructura interna del meta -->
  <?php include 'estructura/meta.php'; ?>
</head> 
<body>
<div class="contenido">
	<?php include 'estructura/header.php'; ?>

<?php 

comprobar_sesion();

if($_SERVER['REQUEST_METHOD']=='POST'){
 $conexion = conexion($bd_config);
	$tipo    = $_POST['tipo'];
 $asunto  = $_POST['asunto'];
 $comentario = $_POST['comentario'];
 
 try {
 $statement=$conexion->prepare('call agregar_comentario(:id_cliente, :tipo_cometario, :asunto, :comentario, :fecha, :estado_comentario)');
 $statement->execute(array(
  ':id_cliente'=>$_SESSION['cliente'],
  ':tipo_cometario'=>$tipo,
  ':asunto'=>$asunto,
  ':comentario'=>$comentario,
  ':fecha'=>date('Y-m-d H:i:s'),
  ':estado_comentario'=>'A')
 );
 header('location: index.php?comentario=on');

 } catch (Exception $e) {
  header('location: login.php?error=on');
 }
}

?>

	<!-- Modals necesarios para el usuario -->
	<?php include 'estructura/modals.php'; ?>

	<!-- carrito de compras para el usuario -->
	<?php include 'estructura/sidebar.php'; ?>

	<div class="controles">
	 <h2 class="informacion_comentario">Hola <?php echo strtoupper($_SESSION['nombre']);?>, este espacio es para usted, para conocer su opinión y presentarle un mejor servicio.
	 </h2>
 </div>
	<div class="contenedor">

	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
		<div class="comentario">
			<p>¿Cual es su tipo de comentario?</p>

		 <input type="radio" id="bueno" name="tipo" value="B"><label for="bueno">Bueno</label>
	  <input type="radio" id="malo" name="tipo" value="M"><label for="malo">Malo</label>
	  <input type="radio" id="reclamo" name="tipo" value="R"><label for="reclamo">Reclamo</label>

   <div class="form-group">
    <label>Asunto: </label>
     <input type="text" name="asunto" placeholder="Me gusto..." required="on">
   </div>

  <div class="form-group">
	  <label>Comentario: </label>
	  <textarea name="comentario" placeholder="Me gusto..." required="on"></textarea>
	 </div>

		<div class="form-group">

		<div class="form-two">
			<a href="index.php" class="volver_comentario">atrás, anular comentario</a>
		</div>

		<div class="form-two enviar_comentario" >
  	<button type="submit">Enviar comentario</button>
		</div>
		</div>


		</div>
	</form>

	</div>
</div>

 <!-- Estructura interna de footer -->
 <?php include 'estructura/footer.php'; ?>
 <!-- Estructura interna de script -->
 <?php include 'estructura/script.php'; ?>
</body>

</html>
