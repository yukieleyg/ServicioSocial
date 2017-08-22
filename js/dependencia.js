var dependencia = function (){
	var parametros="";
	const TECLA_ENTER = 13;
	var cambioClave = function(){
		$('#opcDependencia>div').hide();
		$('#cambioClaveDep').show("slow");
	}

	$("#btnCambioClaveDep").on("click",cambioClave);
}
$(document).on("ready",dependencia);