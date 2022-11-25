<script src="js/vendor/modernizr-3.11.2.min.js"></script>
<script src="js/plugins.js"></script>
<script src="https://kit.fontawesome.com/d21a3be417.js" crossorigin="anonymous"></script>


<script type="text/javascript">
// Validacion de la categoria con respecto a las fechas
	function filtrar(valor) {
		if (valor.selectedIndex == 3 || valor.selectedIndex == 6) {
			document.getElementById('ingreso_validacion').style.display = "block";
			document.getElementById('vencimiento_validacion').style.display = "block";
		} else {
			document.getElementById('ingreso_validacion').style.display = "none";
			document.getElementById('vencimiento_validacion').style.display = "none";
		}
	}

// El vuelto automatico para el cliente
function vuelto_validad(pago_cliente) {
	var total_pagar = document.getElementById('total_pagar').value;
	var vuelto_final = (pago_cliente.value - total_pagar)
	document.getElementById('vuelto_cliente').value = vuelto_final.toFixed(2);
}

</script>