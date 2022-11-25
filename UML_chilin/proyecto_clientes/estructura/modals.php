<style type="text/css">
/* ============================== Modals (Estilos personalizados) ============================== */
div.modal-header {border-bottom: none;}
div.centrado {top: 35%;}
div.modal {font-family: 'Poppins', sans-serif; text-transform: uppercase; font-weight: bold; font-size: 0.5em; text-align: center; position: absolute;}
div.modal-body img{width: 70px; margin-top: -50px; padding-bottom: 10px;}

/* ============================== Carrito de compras (Estilos personalizados) ============================== */
.modal.left .modal-dialog { position: fixed; margin: auto; width: 50%; height: 100%; -webkit-transform: translate3d(0%, 0, 0); -ms-transform: translate3d(0%, 0, 0); -o-transform: translate3d(0%, 0, 0); transform: translate3d(0%, 0, 0); }
.modal.left .modal-content { height: 100%; overflow-y: auto; border-radius: 0px; }
.modal.left .modal-body { padding: 15px 15px 0px; }
.modal.left.fade .modal-dialog{ left: -320px; -webkit-transition: opacity 0.3s linear, left 0.3s ease-out; -moz-transition: opacity 0.3s linear, left 0.3s ease-out; -o-transition: opacity 0.3s linear, left 0.3s ease-out; transition: opacity 0.3s linear, left 0.3s ease-out; }
.modal.left.fade.in .modal-dialog{	left: 0; }
.carrito {	border-radius: 0;	border-right: 5px solid #000; }
div.encabezado {	font-size: 2.0em;	padding-bottom: 0px; }
div.encabezado img {	width: 60%; }
h5.modal-title {	font-weight: bold;	text-transform: none; }
div.modal-footer {	text-align: center;	border-top: none; }
button.proceso {	background-color: #f6a11b; border: none; padding: 5px 10px; border-radius: 5px; text-transform: uppercase; }
button.proceso a { color: #1d1d1b; }
div.listado{ width: 100%; height: 80px; margin: 10px 0px; }
div.lista{	width: 40%;	float: left; }
div.listado img{	width: 75%; margin: 0px auto; }
div.listado p{	font-size: .6em;	margin: 0px auto; }
div.listado p.titulo{	font-size: .7em;	margin: 0px auto; }
div.listado button{	border:none;	font-size: .8em;	border-radius: 3px; padding: 3px 1px;	background-color: red;	color: #eee; }
div.modal-footer a.error {	text-decoration: none;	color: red; }
</style>

<?php if (isset($_GET["datos"]) == "on"): ?>
<div class="modal-dialog modal fade modal-dialog centrado" id="myModal" role="dialog">
	<div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal">&times;</button>
	  </div>
	  <div class="modal-body">
	  	<img src="img/de-acuerdo.png" alt="Exito">
	    <p>Sus datos se guardaron<br/>correctamente</p>
	  </div>
	</div>
	</div>
</div>
<?php endif ?>

<?php if (isset($_GET["repetido"]) == "on"): ?>
<div class="modal-dialog modal fade modal-dialog centrado" id="myModal" role="dialog">
	<div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal">&times;</button>
	  </div>
	  <div class="modal-body">
	  	<img src="img/de-acuerdo.png" alt="Exito">
	    <p>Producto repetido<br/>¡Sigue comprando!</p>
	  </div>
	</div>
	</div>
</div>
<?php endif ?>

<?php if (isset($_GET["pedido"]) == "on"): ?>
<div class="modal-dialog modal fade modal-dialog centrado" id="myModal" role="dialog">
	<div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal">&times;</button>
	  </div>
	  <div class="modal-body">
	  	<img src="img/de-acuerdo.png" alt="Exito">
	    <p>Su pedido<br/>Se realizo con éxito<br/><a href="compras.php">Detalles aquí</a></p>
	  </div>
	</div>
	</div>
</div>
<?php endif ?>

<?php if (isset($_GET["comentario"]) == "on"): ?>
<div class="modal-dialog modal fade modal-dialog centrado" id="myModal" role="dialog">
	<div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal">&times;</button>
	  </div>
	  <div class="modal-body">
	  	<img src="img/de-acuerdo.png" alt="Exito">
	    <p>Su comentario<br/>Se realizo con éxito<br/><a href="comentarios.php">Detalles aquí</a></p>
	  </div>
	</div>
	</div>
</div>
<?php endif ?>
