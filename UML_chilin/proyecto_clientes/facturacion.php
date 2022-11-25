<?php
session_start();
require_once 'config/config.php';
require_once 'config/funciones.php';
comprobar_sesion();

// recuperamos el ultimo correlativo de la tabla de los pedidos
try {
 $statement_correlatico=conexion($bd_config)->prepare('call obtener_correlativo()');
 $statement_correlatico->execute();
 $resultado_correlatico= $statement_correlatico->fetch();

 foreach ($_SESSION["carrito"] as $producto) {
   $statement=conexion($bd_config)->prepare('call agregar_pedido(:correlativo,:id_cliente,:id_producto,:cantidad,:estado)');
   $statement->execute(array(
    ':correlativo'=>($resultado_correlatico['correlativo'] + 1),
    ':id_cliente'=>$_SESSION['cliente'],
    ':id_producto'=>$producto['id_producto'],
    ':cantidad'=>$producto['cantidad'],
    ':estado'=>'A')
   );
 }

  $statement_id_pedido=conexion($bd_config)->prepare('call obtener_pedido()');
  $statement_id_pedido->execute();
  $resultado_id_pedido= $statement_id_pedido->fetch();

  $tot_pag=0; 
  foreach ($_SESSION["carrito"] as $producto):	$tot_pag += number_format($producto['precio'] * $producto['cantidad'], 2); endforeach; 
  $tot_pag =number_format($tot_pag, 2);

 $statement_factura=conexion($bd_config)->prepare('call agregar_factura(:id_pedido, :correlativo, :fecha, :hora, :total_pagar, :tipo_factura, :estado_factura)');
 $statement_factura->execute(array(
  ':id_pedido'=>$resultado_id_pedido['id_pedido'],
  ':correlativo'=>($resultado_correlatico['correlativo'] + 1),
  ':fecha'=>$_POST['fecha'],
  ':hora'=>$_POST['hora'],
  ':total_pagar'=>$tot_pag,
  ':tipo_factura'=>'E',
  ':estado_factura'=>'P')
 );

} catch (Exception $e) {
  header('location:index.php?error=on');
}

  header('location:xcarrito.php?pedido=on');

?>
