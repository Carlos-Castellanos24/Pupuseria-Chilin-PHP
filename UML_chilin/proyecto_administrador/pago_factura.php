<?php
require_once 'config/config.php';

$id_factura   = $_POST['id_factura'];

$info_factura = conexion($bd_config)->prepare('call cargar_facturas(:id_factura)');
$info_factura->execute(array(':id_factura' => $id_factura));
$informacion_factura = $info_factura->fetch();

if (!$informacion_factura['id_pedido'] > 0 || $informacion_factura['estado_factura'] != 'P') {
	header('Location: pago.php');
}

?>
<!doctype html>
	<!-- Estructura interna del meta -->
	<?php include 'estructura/meta.php'; ?>

<body>
	<!-- Estructura interna del header -->
	<?php include 'estructura/header.php'; ?>

<div class="contenido">
	<center><h1>Información de la factura<br/>Factura: <?= $id_factura ?></h1></center>

<form action="procesos/agregar_pago.php" class="insertar" method="post">

	<input type="hidden" name="id_factura" value="<?= $id_factura ?>">
	<input type="hidden" name="id_pedido" value="<?= $id_pedido ?>">
	<div class="enviar">
		<input type="submit" value="Procesar pago de la factura">
	</div>

	<div class="form-group four">
		<label for="id_pedido">IDPedido:</label>
		<input type="text" name="id_pedido" id="id_pedido" readonly="on" value="<?= $informacion_factura['id_pedido'] ?>">
	</div>

	<div class="form-group four">
		<label for="correlativo">Correlativo: </label>
		<input type="text" name="correlativo" id="correlativo" readonly="on" value="<?= $informacion_factura['correlativo'] ?>">
	</div>

	<div class="form-group four">
		<label for="fecha">Fecha: </label>
		<input type="text" name="fecha" id="fecha" readonly="on" value="<?= $informacion_factura['fecha'] ?>">
	</div>

	<div class="form-group four">
		<label for="hora">Hora: </label>
		<input type="text" name="hora" id="hora" readonly="on" value="<?= $informacion_factura['hora'] ?>">
	</div>

	<div class="form-group two">
		<label for="tipo_factura">Tipo de factura: </label>
		<?php if ($informacion_factura['tipo_factura'] == 'E'): $tipo_factura = "Electrónica"; else: $tipo_factura = "Impresa"; endif ?>
		<input type="text" name="tipo_factura" id="tipo_factura" readonly="on" value="<?= $tipo_factura; ?>">
	</div>

	<div class="form-group two">
		<label for="estado_factura">Estado:</label>
		<?php if ($informacion_factura['estado_factura'] == 'A'): $estado_factura = "Activo"; elseif ($informacion_factura['estado_factura'] == 'I'): $estado_factura = "Inactivo"; else: $estado_factura = "Pendiente"; endif ?>
		<input type="text" name="estado_factura" id="estado_factura" readonly="on" value="<?= $estado_factura; ?>">
	</div>

	<br><br>

	<div class="form-group three">
		<label for="total_pagar">Total a pagar: </label>
		<input type="number" name="total_pagar" id="total_pagar" readonly="on" value="<?= $informacion_factura['total_pagar'] ?>">
	</div>

	<div class="form-group three">
		<label for="pago_cliente">Pago del cliente: </label>
		<input type="number" name="pago_cliente" id="pago_cliente" onkeypress="vuelto_validad(this)" onclick="vuelto_validad(this)" required="on" min="0" step="0.01">
	</div>

	<div class="form-group three">
		<label for="vuelto_cliente">Vuelto: </label>
		<input type="number" name="vuelto_cliente" id="vuelto_cliente" min="0.00" step="0.01">
	</div>

	<div class="form-group">
		<label>Comentario de despacho: </label>
		<textarea name="comentario" required="on"></textarea>
	</div>

</form>

	<div class="form-group">
		<a href="pago.php">Cancelar proceso de pago</a>
	</div>

</div>

 <!-- Estructura interna del footer -->
	<?php include 'estructura/footer.php'; ?>

 <!-- Estructura interna del script -->
	<?php include 'estructura/script.php'; ?>
</body>

</html>