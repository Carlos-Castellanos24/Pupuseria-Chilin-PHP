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

	<!-- Modals necesarios para el usuario -->
	<?php include 'estructura/modals.php'; ?>

	<!-- carrito de compras para el usuario -->
	<?php include 'estructura/sidebar.php'; ?>

<?php
	try {
		$categoria_1 = conexion($bd_config)->prepare("call mostrar_productos(:id)");
		$categoria_1->execute(array(':id'=>1));
		$productos_categoria_1 = $categoria_1->fetchAll();
	} catch (Exception $e) {
		echo 'index.php?error=on';
	}
?>

<?php if (count($productos_categoria_1) > 0): ?>
	<div class="controles">
	 <h2 class="categories-title controls">	
 	<?php 
 	$categoria = explode(" ", $productos_categoria_1[0]['nombre_categoria']);
 	echo $categoria[1];
 	?>
 	</h2>
 <span class="control">
 	<button class="botones abrir" onclick="mostrarOcultar()">
 		<i class="fas fa-ellipsis-h"></i>
 </button>
	<button type="button" class="btn btn-demo botones carrito" data-toggle="modal" data-target="#myModal2">
		<?php if (isset($_SESSION["carrito"])):	echo count($_SESSION["carrito"]); else:	echo "0"; endif ?> <i class="fas fa-shopping-cart"></i>
	</button>
 </span>
 </div>
	 <section class="carrousel first">
  <div class="carrousel-container">

		<div class="herramientas" id="herramientas">
			<div class="form-two">
				<a href="h_comentario.php">
					<button><i class="far fa-comment-alt"></i> Hacer comentario</button>
				</a>
			</div>
			<div class="form-two">
				<a href="xsesion.php">
					<button><i class="fas fa-ban"></i> Cerrar Sesión</button>
				</a>
			</div>
			<div class="form-two contrl">
				<a href="compras.php">
					<button><i class="fas fa-history"></i> Historial compras</button>
				</a>
			</div>
			<div class="form-two contrl">
				<a href="comentarios.php">
					<button><i class="fas fa-history"></i> Historial comentarios</button>
				</a>
			</div>
		</div>

	<?php foreach ($productos_categoria_1 as $productos): ?>
	<form method="POST" action="estructura/cart.php">
	<div class="carrousel-complemet">
		<p class="pupusas-tittle"><?php echo $productos['nombre_producto']; ?></p>
			<div class="carrousel-item">
			<img class="carrousel-item-img" src="productos/<?php echo $productos['foto']; ?>" alt="chilin">
				<div class="carrousel-item-details">
					<div>
					<p class="carrousel-item-details--title">$<?php echo $productos['precio']; ?></p>
						<div class="number-input-detail">
						<button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" ></button>
						<input class="quantity" min="1" name="cantidad" value="1" type="number">
						<button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
						</div>

						<div class="cart">
						<input type="hidden" name="id_producto" value="<?php echo $productos['id_producto']; ?>">
						<input type="hidden" name="nombre_producto" value="<?php echo $productos['nombre_producto']; ?>">
						<input type="hidden" name="precio" value="<?php echo $productos['precio']; ?>">
						<input type="hidden" name="img" value="<?php echo $productos['foto']; ?>">
						<button type="submit" name="add_to_cart"><i class="fas fa-shopping-cart"></i></button>
						</div>

					</div>
				</div>
			</div>
	</div>
	</form>
 <?php endforeach ?>

  </div>
 </section>
<?php endif ?>

<?php
try {
	$categoria_2 = conexion($bd_config)->prepare("call mostrar_productos(:id)");
	$categoria_2->execute(array(':id'=>2));
	$productos_categoria_2 = $categoria_2->fetchAll();
} catch (Exception $e) {
	echo 'index.php?error=on';
}
?>

<?php if (count($productos_categoria_2) > 0): ?>
 <h2 class="categories-title">
 	<?php 
 	$categoria = explode(" ", $productos_categoria_2[0]['nombre_categoria']);
 	echo $categoria[1];
 	?>
 	</h2>
<section class="carrousel">
	<div class="carrousel-container">
	<?php foreach ($productos_categoria_2 as $productos): ?>
	<form method="POST" action="estructura/cart.php">
	<div class="carrousel-complemet">
		<p class="pupusas-tittle"><?php echo $productos['nombre_producto']; ?></p>
			<div class="carrousel-item">
			<img class="carrousel-item-img" src="productos/<?php echo $productos['foto']; ?>" alt="chilin">
				<div class="carrousel-item-details">
					<div>
					<p class="carrousel-item-details--title">$<?php echo $productos['precio']; ?></p>
						<div class="number-input-detail">
						<button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" ></button>
						<input class="quantity" min="1" name="cantidad" value="1" type="number">
						<button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
						</div>

						<div class="cart">
						<input type="hidden" name="add_to_cart">
						<input type="hidden" name="id_producto" value="<?php echo $productos['id_producto']; ?>">
						<input type="hidden" name="nombre_producto" value="<?php echo $productos['nombre_producto']; ?>">
						<input type="hidden" name="precio" value="<?php echo $productos['precio']; ?>">
						<input type="hidden" name="img" value="<?php echo $productos['foto']; ?>">
						<button type="submit"><i class="fas fa-shopping-cart"></i></button>
						</div>

					</div>
				</div>
			</div>
	</div>
	</form>
	<?php endforeach ?>
 	</div>
</section>
<?php endif ?>

<!-- comentario categoria 3  -->
<?php
try {
	$categoria_3 = conexion($bd_config)->prepare("call mostrar_productos(:id)");
	$categoria_3->execute(array(':id'=>3));
	$productos_categoria_3 = $categoria_3->fetchAll();
} catch (Exception $e) {
	echo 'index.php?error=on';
}
?>

<?php if (count($productos_categoria_3) > 0): ?>
 <h2 class="categories-title">
 <?php	echo $productos_categoria_3[0]['nombre_categoria'];	?>
 </h2>
<section class="carrousel">
	<div class="carrousel-container">
	<?php foreach ($productos_categoria_3 as $productos): ?>
	<form method="POST" action="estructura/cart.php">
	<div class="carrousel-complemet">
		<p class="pupusas-tittle"><?php echo $productos['nombre_producto']; ?></p>
			<div class="carrousel-item">
			<img class="carrousel-item-img" src="productos/<?php echo $productos['foto']; ?>" alt="chilin">
				<div class="carrousel-item-details">
					<div>
					<p class="carrousel-item-details--title">$<?php echo $productos['precio']; ?></p>
						<div class="number-input-detail">
						<button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" ></button>
						<input class="quantity" min="1" name="cantidad" value="1" type="number">
						<button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
						</div>

						<div class="cart">
						<input type="hidden" name="add_to_cart">
						<input type="hidden" name="id_producto" value="<?php echo $productos['id_producto']; ?>">
						<input type="hidden" name="nombre_producto" value="<?php echo $productos['nombre_producto']; ?>">
						<input type="hidden" name="precio" value="<?php echo $productos['precio']; ?>">
						<input type="hidden" name="img" value="<?php echo $productos['foto']; ?>">
						<button type="submit"><i class="fas fa-shopping-cart"></i></button>
						</div>

					</div>
				</div>
			</div>
	</div>
	</form>
	<?php endforeach ?>
 	</div>
</section>
<?php endif ?>

<!-- comentario categoria 4  -->
<?php
try {
	$categoria_4 = conexion($bd_config)->prepare("call mostrar_productos(:id)");
	$categoria_4->execute(array(':id'=>4));
	$productos_categoria_4 = $categoria_4->fetchAll();
} catch (Exception $e) {
	echo 'index.php?error=on';
}
?>

<?php if (count($productos_categoria_4) > 0): ?>
 <h2 class="categories-title">
 <?php	echo $productos_categoria_4[0]['nombre_categoria']; ?>
 </h2>
<section class="carrousel">
	<div class="carrousel-container">
	<?php foreach ($productos_categoria_4 as $productos): ?>
	<form method="POST" action="estructura/cart.php">
	<div class="carrousel-complemet">
		<p class="pupusas-tittle"><?php echo $productos['nombre_producto']; ?></p>
			<div class="carrousel-item">
			<img class="carrousel-item-img" src="productos/<?php echo $productos['foto']; ?>" alt="chilin">
				<div class="carrousel-item-details">
					<div>
					<p class="carrousel-item-details--title">$<?php echo $productos['precio']; ?></p>
						<div class="number-input-detail">
						<button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" ></button>
						<input class="quantity" min="1" name="cantidad" value="1" type="number">
						<button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
						</div>

						<div class="cart">
						<input type="hidden" name="add_to_cart">
						<input type="hidden" name="id_producto" value="<?php echo $productos['id_producto']; ?>">
						<input type="hidden" name="nombre_producto" value="<?php echo $productos['nombre_producto']; ?>">
						<input type="hidden" name="precio" value="<?php echo $productos['precio']; ?>">
						<input type="hidden" name="img" value="<?php echo $productos['foto']; ?>">
						<button type="submit"><i class="fas fa-shopping-cart"></i></button>
						</div>

					</div>
				</div>
			</div>
	</div>
	</form>
	<?php endforeach ?>
 	</div>
</section>
<?php endif ?>

<!-- comentario categoria 5 -->
<?php
try {
	$categoria_5 = conexion($bd_config)->prepare("call mostrar_productos(:id)");
	$categoria_5->execute(array(':id'=>5));
	$productos_categoria_5 = $categoria_5->fetchAll();
} catch (Exception $e) {
	echo 'index.php?error=on';
}
?>

<?php if (count($productos_categoria_5) > 0): ?>
 <h2 class="categories-title">
 <?php echo $productos_categoria_5[0]['nombre_categoria']; ?>
 </h2>
<section class="carrousel">
	<div class="carrousel-container">
	<?php foreach ($productos_categoria_5 as $productos): ?>
	<form method="POST" action="estructura/cart.php">
	<div class="carrousel-complemet">
		<p class="pupusas-tittle"><?php echo $productos['nombre_producto']; ?></p>
			<div class="carrousel-item">
			<img class="carrousel-item-img" src="productos/<?php echo $productos['foto']; ?>" alt="chilin">
				<div class="carrousel-item-details">
					<div>
					<p class="carrousel-item-details--title">$<?php echo $productos['precio']; ?></p>
						<div class="number-input-detail">
						<button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" ></button>
						<input class="quantity" min="1" name="cantidad" value="1" type="number">
						<button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
						</div>

						<div class="cart">
						<input type="hidden" name="add_to_cart">
						<input type="hidden" name="id_producto" value="<?php echo $productos['id_producto']; ?>">
						<input type="hidden" name="nombre_producto" value="<?php echo $productos['nombre_producto']; ?>">
						<input type="hidden" name="precio" value="<?php echo $productos['precio']; ?>">
						<input type="hidden" name="img" value="<?php echo $productos['foto']; ?>">
						<button type="submit"><i class="fas fa-shopping-cart"></i></button>
						</div>

					</div>
				</div>
			</div>
	</div>
	</form>
	<?php endforeach ?>
 	</div>
</section>
<?php endif ?>

<!-- comentario categoria 6  -->
<?php
try {
	$categoria_6 = conexion($bd_config)->prepare("call mostrar_productos(:id)");
	$categoria_6->execute(array(':id'=>6));
	$productos_categoria_6 = $categoria_6->fetchAll();
} catch (Exception $e) {
	echo 'index.php?error=on';
}
?>

<?php if (count($productos_categoria_6) > 0): ?>
 <h2 class="categories-title"><?php echo $productos_categoria_6[0]['nombre_categoria']; ?></h2>
	<section class="carrousel">
		<div class="carrousel-container">
		<?php foreach ($productos_categoria_6 as $productos): ?>
		<form method="POST" action="estructura/cart.php">
		<div class="carrousel-complemet">
			<p class="pupusas-tittle"><?php echo $productos['nombre_producto']; ?></p>
				<div class="carrousel-item">
				<img class="carrousel-item-img" src="productos/<?php echo $productos['foto']; ?>" alt="chilin">
					<div class="carrousel-item-details">
						<div>
						<p class="carrousel-item-details--title">$<?php echo $productos['precio']; ?></p>
							<div class="number-input-detail">
							<button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" ></button>
							<input class="quantity" min="1" name="cantidad" value="1" type="number">
							<button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
							</div>

							<div class="cart">
							<input type="hidden" name="add_to_cart">
							<input type="hidden" name="id_producto" value="<?php echo $productos['id_producto']; ?>">
							<input type="hidden" name="nombre_producto" value="<?php echo $productos['nombre_producto']; ?>">
							<input type="hidden" name="precio" value="<?php echo $productos['precio']; ?>">
							<input type="hidden" name="img" value="<?php echo $productos['foto']; ?>">
							<button type="submit"><i class="fas fa-shopping-cart"></i></button>
							</div>

						</div>
					</div>
				</div>
		</div>
		</form>
		<?php endforeach ?>
 </div>
	</section>
<?php endif ?>

</div>

 <!-- Estructura interna de footer -->
 <?php include 'estructura/footer.php'; ?>
 <!-- Estructura interna de script -->
 <?php include 'estructura/script.php'; ?>
</body>

</html>
