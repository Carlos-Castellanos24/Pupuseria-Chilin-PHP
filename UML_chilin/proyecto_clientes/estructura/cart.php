<?php
session_start();
if(isset($_POST["add_to_cart"])) {
	$id_producto = $_POST['id_producto'];
	$producto    = $_POST['nombre_producto'];
	$precio      = $_POST['precio'];
	$cantidad    = $_POST['cantidad'];
	$foto        = $_POST['img'];

	if (isset($_SESSION['carrito'])) {
	// Si el producto no esta repetido lo agregamos al carrito
	// Negamos la condicion para guardar en el carrito
	$buscarid = array_column($_SESSION["carrito"], "id_producto");
	if(!in_array($id_producto, $buscarid)) {
		$count = count($_SESSION["carrito"]);
		$cesta = array(
		'id_producto' =>  $id_producto,
		'producto'    =>  $producto,
		'precio'      =>  $precio,
		'cantidad'    =>  $cantidad,
		'foto'        =>  $foto
		);
		$_SESSION["carrito"][$id_producto] = $cesta;

		header("Location: ../index.php");
	}else{
	// SI EL PRODUCTO ESTA REPETIDO SE EJECUTA EL ELSE
		header("Location: ../index.php?repetido=on");
	}

	} else {
		// Agregamos al carrito el producto con su informacion
	$cesta = array(
		'id_producto' =>  $id_producto,
		'producto'    =>  $producto,
		'precio'      =>  $precio,
		'cantidad'    =>  $cantidad,
		'foto'        =>  $foto
		);

		$_SESSION["carrito"][$id_producto] = $cesta;

		header("Location: ../index.php");
	}

}

// Eliminamos productos del carrito de compras
if (isset($_POST["delete"])) {
	$id_producto  = $_POST['id_producto'];
	if(isset($_SESSION['carrito'])) { 
			foreach ($_SESSION["carrito"] as $key => $value) {
				if ($value["id_producto"] == $id_producto) {
				unset($_SESSION["carrito"][$key]);
				}
			}
			header("Location: ../index.php");
		}
}

?>
