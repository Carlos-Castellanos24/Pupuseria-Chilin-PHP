<?php 
require_once 'config/config.php';
require_once 'config/funciones.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
	// Establecemos la conexion con la funcion de la base de datos. 
	$conexion = conexion($bd_config);

	$nombre   = $_POST['nombre'];
	$telefono = $_POST['telefono'];
	$password = $_POST['password'];

	// Falta procedimiento almacenado
	// Evaluamos que el usuario no exista
	$statement=$conexion->prepare('call buscar_telefono_cliente(:telefono)');
	$statement->execute(array(':telefono' => $telefono));
	$resultado= $statement->fetch();

	if ($resultado) {
		header('location: registro.php?existe=on');
	}else{
			// Encriptamos la contraseña 
			$password = hash('sha512' , $password);

			// insertamos la consulta
			try {
			$statement=$conexion->prepare('call agregar_cliente(:nombre,:apellido,:dui,:telefono,:nacimiento,:correo,:direccion,:pw,:sexo,:estado)');
			$statement->execute(array(
				':nombre'=>$nombre,
				':apellido'=>'0',
				':dui'=>'0',
				':telefono'=>$telefono,
				':pw'=> $password,
				':correo'=>'0',
				':direccion'=>'0',
				':nacimiento'=>'0',
				':sexo'=>'M',
				':estado'=>'A')
			);

			if ($statement) {
				header('location: login.php?nuevo=on');
			}else {
				header('location: login.php?nuevo=off');
			}

			} catch (Exception $e) {
				header('location: login.php?error=on');
			}
	
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
			<div class="registro">
				<img src="img/chilin.png" alt="chilin">
			</div>
			<div class="registro">
				<i class="fas fa-user"></i>
			</div>
			<div class="registro_arriba">
				<img src="img/arriba.png" alt="arriba">
			</div>
		</div>

		<section class="mini_alerta">
			<?php if (isset($_GET["existe"]) == "on"): ?>
				<p>Su número de teléfono ya esta registrado.</p>
			<?php endif ?>
		</section>

	<div class="contenedor">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="formulario" name="login">

			<div class="form-group">
				<label for="nombre">Nombres:</label>
				<input type="text" onblur="validarCampo(this,'nombre',3)" name="nombre" id="nombre" class="nombre" required="on" placeholder="Nombre Nombre">
				<p class="campos_alerta" id="alertaT"></p>
			</div>
						   
			<div class="form-group">
				<label for="telefono">Teléfono:</label>
				<input type="tel" onblur="validarTelefono(this,8)" name="telefono" id="telefono" class="telefono" required="on" placeholder="0000-0000" minlength="8" maxlength="8">
				<p class="campos_alerta" id="alertaN"></p>
			</div>

			<div class="form-group">
				<label for="password">Contraseña:</label>
				<input type="password" onblur="longitudClave(this,5);" name="password" id="password" class="password" id="password" required="on" placeholder="**********">
				<p class="campos_alerta" id="alertaP"></p>
			</div>

			<div class="form-group">
				<label for="password2">Repita la Contraseña:</label>
				<input type="password" onblur="validarClave();" name="password2" id="password2" class="password_btn" required="on" placeholder="**********">
				<p class="campos_alerta" id="alertaC"></p>
			</div>
			</div>

				<div class="aceptar">
					<input type="checkbox" id="acp" required="on">
	  		<label for="acp">Acepto términos y condiciones</label>
	 		</div>

			<div class="contenedor">
  		<div class="enviar">
  			<button type="submit" id="envio"><i class="fas fa-user-plus"></i> Registrarme</button>
				</div>			
		</form>
				<a href="login.php" class="volver">Volver atrás</a>
		</div>

 <!-- Estructura interna de footer -->
 <?php include 'estructura/footer.php'; ?>
 <!-- Estructura interna de script -->
 <?php include 'estructura/script.php'; ?>
</body>
</html>