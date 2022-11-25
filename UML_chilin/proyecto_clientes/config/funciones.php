<?php 
// Definir la region de hora
setlocale(LC_TIME,"es_SV");
date_default_timezone_set('America/El_Salvador');

function comprobar_sesion(){
		if(!isset($_SESSION['cliente'])){
	 header('Location: index.php');
	}
}

?>

<!-- Validación en el tamaño de la pantalla -->
<script type="text/javascript">
	if (screen.width > 512) {
 window.location="./no_soporte.html";
}
</script>