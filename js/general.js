// JavaScript Document
$(document).ready(initGeneral);

function initGeneral(){
	/*$("div#contenido").on("click", "a#nuevo, table#grilla a#editar", function(e){
		$("div#emergente").fadeIn('slow');
		$("div#formuEmergente").fadeIn('slow');
		$("div#intFormuEmergente").load($(this).attr("href"));
		e.preventDefault();
	});*/
	$("div#cuerpo").on("click", "a#eliminar", function(e){
		if(confirm("\xbfEst\xe1 seguro que desea eliminar el registro?")){
			$("p.mensaje").load($(this).attr("href")+" p.mensaje",  function(){
			   $(this).show().delay(2000).hide('slow', function(){
					$(this).html("").show();
				});
				refrescarGrilla();
			});
		}
		e.preventDefault();
	});
	$("div#cuerpo").on("click", "button#buscarGrilla", function(){
		refrescarGrilla();
	});
	$("div#cuerpo").on("keypress", "input#txtBuscar", function(e){
		if(e.keyCode == 13){
			refrescarGrilla();
			e.preventDefault();
		}
	});
        
        $( "select#rolUsuario").change(function () {               
                if($(this).val()=='R'){
                    $("#usuario_campana_tr").css("display", "block");
                }else{
                    $("#usuario_campana_tr").css("display", "none");
                }
        });        
}
function mensajeVacio(){
	$("p.mensaje").html("");
}

$(document).ajaxStart(loadingShow).ajaxStop(loadingHide);

function loadingShow(){
	$("img#loading").show();
}
function loadingHide(){
	$("img#loading").hide();
}


// Prevent the backspace key from navigating back.
$(document).unbind('keydown').bind('keydown', function (event) {
    var doPrevent = false;
    if (event.keyCode === 8) {
        var d = event.srcElement || event.target;
        if ((d.tagName.toUpperCase() === 'INPUT' && (d.type.toUpperCase() === 'TEXT' || d.type.toUpperCase() === 'PASSWORD' || d.type.toUpperCase() === 'FILE')) 
             || d.tagName.toUpperCase() === 'TEXTAREA') {
            doPrevent = d.readOnly || d.disabled;
        }
        else {
            doPrevent = true;
        }
    }

    if (doPrevent) {
        event.preventDefault();
    }
});