<script src="js/vendor/modernizr-3.11.2.min.js"></script>
<script src="js/plugins.js"></script>
<script src="js/main.js"></script>
<script src="js/principal.js"></script>
<script src="https://kit.fontawesome.com/d21a3be417.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- JQuery para los modales -->
<?php if (isset($_GET["datos"]) == "on"): ?>
<script type="text/javascript">
	$( document ).ready(function() {
    $('#myModal').modal('toggle')
});
</script>
<?php endif ?>

<?php if (isset($_GET["repetido"]) == "on"): ?>
<script type="text/javascript">
	$( document ).ready(function() {
    $('#myModal').modal('toggle')
});
</script>
<?php endif ?>

<?php if (isset($_GET["pedido"]) == "on"): ?>
<script type="text/javascript">
	$( document ).ready(function() {
    $('#myModal').modal('toggle')
});
</script>
<?php endif ?>

<?php if (isset($_GET["comentario"]) == "on"): ?>
<script type="text/javascript">
	$( document ).ready(function() {
    $('#myModal').modal('toggle')
});
</script>
<?php endif ?>