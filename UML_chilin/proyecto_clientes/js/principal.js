function validarCampo(a, c, d) {
	var desabilitar =	document.getElementById('envio');
	if (a.value == "") {
	document.getElementById('alertaT').innerHTML = "El campo " + c + " no esta completado correctamente";
	desabilitar.disabled=true;
	} else {
		if (a.value.length < d) {
	document.getElementById('alertaT').innerHTML = "El campo "+c+" no es valido";
	desabilitar.disabled=true;
		} else {
	document.getElementById('alertaT').innerHTML = "";
	desabilitar.disabled=false;
	}
	}
}

function validarDireccion(a, c, d) {
	var desabilitar =	document.getElementById('envio');
	if (a.value == "") {
	document.getElementById('alertaA').innerHTML = "El campo " + c + " no esta completado correctamente";
	desabilitar.disabled=true;
	} else {
		if (a.value.length < d) {
	document.getElementById('alertaA').innerHTML = "El campo "+c+" no es valido";
	desabilitar.disabled=true;
		} else {
	document.getElementById('alertaA').innerHTML = "";
	desabilitar.disabled=false;
	}
	}
}

function validarDiu(a, c, d) {
	var desabilitar =	document.getElementById('envio');
	if (a.value == "") {
	document.getElementById('alertaD').innerHTML = "El campo " + c + " no esta completado correctamente";
	desabilitar.disabled=true;
	} else {
		if (a.value.length < d) {
	document.getElementById('alertaD').innerHTML = "El campo "+c+" no es valido";
	desabilitar.disabled=true;
		} else {
	document.getElementById('alertaD').innerHTML = "";
	desabilitar.disabled=false;
	}
	}
}

function validarTelefono(a, c) {
	var desabilitar =	document.getElementById('envio');
	if (isNaN(a.value)) {
	document.getElementById('alertaN').innerHTML = "El teléfono no debe llevar letras";
	desabilitar.disabled=true;
	} else {
		if (a.value.length < c) {
  	document.getElementById('alertaN').innerHTML = "El teléfono debe tener " +c+" números como mínimo";
	  desabilitar.disabled=true;
		} else {
		if (!(a.value.charAt(0) == '7' || a.value.charAt(0) == '6')) {
			document.getElementById('alertaN').innerHTML = "El teléfono no es valido para El Salvador";
			desabilitar.disabled=true;
		} else {
		 document.getElementById('alertaN').innerHTML = "";
	  desabilitar.disabled=false;
		}
		}
	}
}

function longitudClave(a, c) {
	var desabilitar =	document.getElementById('envio');
	if (a.value.length < c) {
		document.getElementById('alertaP').innerHTML = "La contraseña debe tener mas de " +c+ " caracteres";
		desabilitar.disabled=true;
	} else {
	 document.getElementById('alertaP').innerHTML = "";
	 desabilitar.disabled=false;
	}
}

function validarClave(){
	var desabilitar =	document.getElementById('envio');
  var pw1 = document.getElementById('password');
  var pw2 = document.getElementById('password2');

  if (pw1.value != pw2.value) {
  	document.getElementById('alertaC').innerHTML = "** Las contraseñas no coinciden **";
  	desabilitar.disabled=true;
  }else {
		 document.getElementById('alertaC').innerHTML = "";
	  desabilitar.disabled=false;
  }
}

function mascara(valor) {
  if (valor.match(/^\d{8}$/) !== null) {
    return valor + '-';
  }
  return cadena;
}

function mostrarOcultar() {
	var herramientas = document.getElementById('herramientas');
	if (herramientas.style.display == "block") {
		herramientas.style.display = "none";
	} else {
	herramientas.style.display = "block";
	}
}