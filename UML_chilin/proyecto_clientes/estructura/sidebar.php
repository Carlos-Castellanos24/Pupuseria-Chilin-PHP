<!-- Sidebar correspondiente al carrito de compras -->
<div class="modal left fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<div class="modal-header encabezado">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<i class="fas fa-clipboard-list"></i>
				<img src="img/chilin.png" alt="Chilin">
				<h5 class="modal-title" id="myModalLabel">Lista de productos<br/>de su pedido</h5>
			</div>

			<div class="modal-body">
				<?php if (isset($_SESSION["carrito"])): ?>
					<?php foreach ($_SESSION["carrito"] as $producto): ?>
						<form method="POST" action="estructura/cart.php">
							<div class="listado">
								<div class="lista"><img src="productos/<?php echo $producto['foto']; ?>" alt="Chilin"></div>
								<div class="lista"><p class="titulo"><?php echo $producto['producto']; ?></p></div>
								<div class="lista"><p>Cantidad: <?php echo $producto['cantidad']; ?></p></div>
								<div class="lista"><p>Total: $<?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?></p></div>
								<input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
								<div class="lista"><button type="submit" name="delete">Eliminar</button></div>
							</div>
						</form>
					<?php endforeach ?>
				<?php else: ?>
					<p>No hay productos en su canasta</p>
				<?php endif ?>
			</div>

  <div class="modal-footer">
  	<?php if (isset($_SESSION['cliente'])): ?>
    <button type="button" class="proceso"><a href="pedido.php">Procesar pedido</a></button>
    <?php else: ?>
    	<a href="login.php" class="error">Inicie sesión para procesar el pedido</a>
    <?php endif ?>
  </div>

		</div>
	</div>
</div>