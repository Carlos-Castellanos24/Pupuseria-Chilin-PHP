<?php
require_once '../config/config.php';

if($_SERVER['REQUEST_METHOD']=='POST'){

$id_factura     = $_POST['id_factura'];
$id_pedido      = $_POST['id_pedido'];
$pago_cliente   = $_POST['pago_cliente'];
$vuelto_cliente = $_POST['vuelto_cliente'];
$comentario     = $_POST['comentario'];

try {
	$pagar_factura = conexion($bd_config)->prepare('call cancelar_factura(:id)');
	$pagar_factura->execute(array(':id'=>$id_factura));
	$pago_factura = $pagar_factura->fetch();	
	header('Location: ../pago.php');
} catch (Exception $e) {
	header('Location: ../index.html');
}

try {
	$pagar_factura = conexion($bd_config)->prepare('call agregar_pago(:id_factura, :fecha, :pago_cliente, :vuelto, :estado_pago)');
	$pagar_factura->execute(array(
		':id_factura'=>$id_factura,
		':fecha'=> date("Y-m-d H:i:s"),
		':pago_cliente'=>$pago_cliente,
		':vuelto'=>$vuelto_cliente,
		':estado_pago'=>'C'
	));
	$pago_factura = $pagar_factura->fetch();	
	header('Location: ../pago.php');
} catch (Exception $e) {
	header('Location: ../index.html');
}

 $obtener_pago=conexion($bd_config)->prepare('call obtener_pago()');
 $obtener_pago->execute();
 $cargar_pago= $obtener_pago->fetch();

try {
	$finalizar_despacho = conexion($bd_config)->prepare('call agregar_despacho(:id_pago, :id_pedido, :fecha, :comentario, :estado_despacho)');
	$finalizar_despacho->execute(array(
		':id_pago'=>$cargar_pago['id_pago'],
		':id_pedido'=> $id_pedido,
		':fecha'=> date("Y-m-d H:i:s"),
		':comentario'=>$comentario,
		':estado_despacho'=>'F'
	));
	$despacho = $finalizar_despacho->fetch();	
	header('Location: ../pago.php');
} catch (Exception $e) {
	header('Location: ../index.html');
}



}
