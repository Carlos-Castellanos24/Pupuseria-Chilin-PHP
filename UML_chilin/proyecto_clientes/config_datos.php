<?php 
session_start();
error_reporting(0);
require_once 'config/config.php';
require_once 'config/funciones.php';
comprobar_sesion();

 // Establecemos la conexion con la funcion de la base de datos. 
 $conexion = conexion($bd_config);
if($_SERVER['REQUEST_METHOD']=='POST'){
 $apellido  = $_POST['apellido'];
 $direccion = $_POST['direccion'];
 $correo    = $_POST['correo'];
 $dui       = $_POST['dui'];
 $sexo      = $_POST['sexo'];
 $nacimiento= $_POST['nacimiento'];

 try {
 // Falta procedimiento almacenado
 // Actualizamos la informacion del usuario
 $statement=$conexion->prepare('call actualizar_cliente2(:id,:apellido,:dui,:correo,:direccion,:nacimiento,:sexo)');
 $statement->execute(array(
  ':apellido'=>$apellido,
  ':dui'=>$dui,
  ':correo'=>$correo,
  ':direccion'=>$direccion,
  ':nacimiento'=>$nacimiento,
  ':sexo'=>$sexo,
  ':id'=>$_SESSION['cliente'])
 );
 header('location: index.php?datos=on');

 } catch (Exception $e) {
  header('location:login.php?error=on');
 }
}

try {
 // Llenamos los campos que ya existen
 $statement=$conexion->prepare('call buscar_cliente(:id)');
 $statement->execute(array(':id'=>$_SESSION['cliente']));
 $resultado= $statement->fetch();
} catch (Exception $e) {
  header('location:login.php?error=on');
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
<?php include 'estructura/header.php'; ?>

<div class="contenedor">
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">

   <div class="form-group">
    <label>Apellidos: </label>
    <?php if ($resultado['apellido_cliente'] == '0'): ?>
     <input type="text" onblur="validarCampo(this,'apellido',3)" name="apellido" placeholder="Apellido Apellido" required="on">
    <?php else: ?>
     <input type="text" name="apellido" value="<?php echo $resultado['apellido_cliente']; ?>" readonly="on">
    <?php endif ?>
    <p class="campos_alerta" id="alertaT"></p>
   </div>   

   <div class="form-group">
    <label>Dirección: </label>
    <?php if ($resultado['direccion'] == '0'): ?>
     <input type="text" onblur="validarDireccion(this,'direccion',10)" name="direccion" placeholder="Dirección" required="on">
    <?php else: ?>
     <input type="text" name="direccion" value="<?php echo $resultado['direccion']; ?>" readonly="on">
    <?php endif ?>
    <p class="campos_alerta" id="alertaA"></p>
   </div>

   <div class="form-group">
    <label>Correo: </label>
    <?php if ($resultado['correo'] == '0'): ?>
     <input type="email" name="correo" placeholder="Email" required="on">
    <?php else: ?>
     <input type="email" name="correo" value="<?php echo $resultado['correo']; ?>" readonly="on">
    <?php endif ?>
   </div>

   <div class="form-group">
    <label>DUI: </label>
    <?php if ($resultado['dui'] == '0'): ?>
     <input type="text" name="dui" onkeyup="this.value = mascara(this.value)" onblur="validarDiu(this,'DUI',10)"  placeholder="00000000-0" required="on" maxlength="10">
    <?php else: ?>
     <input type="text" name="dui" value="<?php echo $resultado['dui']; ?>" readonly="on" maxlength="10">
    <?php endif ?>
    <p class="campos_alerta" id="alertaD"></p>
   </div>  

   <div class="form-group">

   <div class="form-two">
    <label>Sexo: </label>
    <select name="sexo" required>
    <option value="">Seleccione</option>    
    <option value="F">F</option>       
    <option value="M">M</option>
    </select>
   </div>

    <div class="form-two">
     <label>Nacimiento: </label>
     <?php 
     // Validacion de fecha, para que la fecha de nacimiento sea valida 
     $fechaactual = date('Y-m-d');
     $fechanacimiento = strtotime('-18 year' , strtotime($fechaactual));
     $fechanacimiento = date('Y-m-d',$fechanacimiento);
     ?>
     <?php if ($resultado['nacimiento'] == '0000-00-00'): ?>
      <input type="date" name="nacimiento" min="1960-01-01" max="<?php echo $fechanacimiento; ?>" required>
     <?php else: ?>
      <input type="date" name="nacimiento" value="<?php echo $resultado['nacimiento']; ?>" readonly="on">
     <?php endif ?>
     
    </div>
   </div>

   <div class="aceptar">
    <input type="checkbox" id="acp" name="acepto" required="on">
    <label for="acp">Hago constar que toda la información es verídica y real.</label>
   </div>

   <div class="enviar">
    <button type="submit" id="envio"><i class="fas fa-arrow-circle-right"></i></i> Confirmar datos</button>
   </div>   
 </form>
 <a href="index.php" class="volver">Saltar de todas formas</a>
</div>
</div>

 <!-- Estructura interna de footer -->
 <?php include 'estructura/footer.php'; ?>
 <!-- Estructura interna de script -->
 <?php include 'estructura/script.php'; ?>
</body>
</html>