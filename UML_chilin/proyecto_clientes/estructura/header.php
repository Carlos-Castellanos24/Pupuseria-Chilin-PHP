<?php session_start(); ?>
<?php if (isset($_SESSION['cliente'])): ?>
	<div class="principal_registro">
 <div class="registro">
  <img src="img/chilin.png" alt="chilin">
 </div>
 <a href="xsesion.php" title="Cerrar sesión">
 <div class="registro nombre_us">
  <span class="nombre_cliente"><?php echo strtoupper($_SESSION['nombre']);?></span><i class="fas fa-user"></i>
 </div>
 </a>
 <div class="registro_arriba">
  <img src="img/arriba.png" alt="arriba">
 </div>
</div>
<?php else: ?>
	<div class="principal_registro">
 <div class="registro">
  <img src="img/chilin.png" alt="chilin">
 </div>
 <div class="registro nombre_us">
  <span class="nombre_cliente"><a href="login.php">Iniciar<br/>sesión</a></span><i class="fas fa-user"></i>
 </div>
 <div class="registro_arriba">
  <img src="img/arriba.png" alt="arriba">
 </div>
</div>
<?php endif ?>

