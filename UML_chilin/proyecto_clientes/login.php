<?php
session_start();
require_once 'config/config.php';
require_once 'config/funciones.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
	// Establecemos la conexion con la funcion de la base de datos. 
	$conexion = conexion($bd_config);

	$telefono = $_POST['telefono'];
	$password = $_POST['password'];
	$password = hash('sha512' , $password);

	try {
 // buacamos que el usuario exista  
	$statement=$conexion->prepare('call login_cliente(:telefono,:pw)');
	$statement->execute(array(':telefono' => $telefono, ':pw' => $password));
	$resultado= $statement->fetch();

	if ($resultado) {
		$_SESSION['cliente']  = $resultado['id_cliente'];
		$nombres = explode(" ", $resultado['nombre_cliente']);
		// $nombres[0]; // Primer nombre
		// $nombres[1]; // Segundo nombre
		$_SESSION['nombre']   = $nombres[0];
		$_SESSION['telefono'] = $resultado['telefono'];

		if ($resultado['apellido_cliente']=="0" || $resultado['direccion']=="0" || $resultado['dui']=="0" || $resultado['correo']=="0" || $resultado['nacimiento']=="0") {
			header('location: config_datos.php');
		}else {
			header('location: index.php');
		}
	}else{
		header('location:login.php?login=on');
	}
	} catch (Exception $e) {
		header('location:login.php?error=on');
	}

}

?>
	
<!DOCTYPE html>
<html lang="es">
<head>
  <!-- Estructura interna del meta -->
		<?php include 'estructura/meta.php'; ?>
</head> 
<body>

<div class="contenido">
	<div class="principal_registro">
		<div class="registro nombre_us">
	  <div class="login"></div>
	 <span class="nombre_cliente"><a href="registro.php">Crear<br/>cuenta</a></span><i class="fas fa-user"></i>
	 </div>
		<div class="login_arriba">
			<img src="img/logo_arriba.png" alt="arriba">
		</div>
	</div>

	<section class="mini_alerta">
		<?php if (isset($_GET["login"]) == "on"): ?>
			<p>El usuario no existe, por favor <a href="registro.php">registrarse aquí</a></p>
		<?php endif ?>
		<?php if (isset($_GET["error"]) == "on"): ?>
			<p>Error en el proceso</a></p>
		<?php endif ?>
	</section>

	<?php if (isset($_GET["nuevo"]) == "on"): ?>
		<p class="registro">Su usuario fue registrado con éxito, inicie sesión con su cuenta</p>
	<?php endif ?>

<div class="contenedor">

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="formulario" name="login">

	<div class="form-group login-in">
		<label for="telefono">Teléfono:</label>
		<i class="icono izquierda fas fa-mobile-alt"></i><input type="tel" onblur="validarTelefono(this,8)" name="telefono" id="telefono" class="telefono" required="on" placeholder="0000-0000" minlength="8" maxlength="8">
		<p class="campos_alerta" id="alertaN"></p>
	</div>

		<div class="form-group login-in">
		<label for="password">Contraseña:</label>
		<i class="icono izquierda fas fa-key"></i><input type="password" onblur="longitudClave(this,5);" name="password" id="password" class="passwordlogin" id="password" required="on" placeholder="**********">
		<p class="campos_alerta" id="alertaP"></p>
		<p class="campos_clave">¿Olvidaste la contraseña?</p>
	</div>

	<div class="enviar">
		<button type="submit" id="envio" onclick="login.submit()"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</button>
	</div>			

</form>
<a href="index.php" class="volver">Volver atrás</a>
</div>

</div>

 <!-- Estructura interna de footer -->
 <?php include 'estructura/footer.php'; ?>
 <!-- Estructura interna de script -->
 <?php include 'estructura/script.php'; ?>
</body>
</html>