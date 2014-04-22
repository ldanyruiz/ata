// JavaScript Document
$(document).ready(function(ex){
	
	$("table#formulario[name='segundo']").hide();
	
	$("select#idHolding, select#idEmpresa").change(function(){
		$("form#formConstructor").submit();
	});
	if($("input#todosReporte").attr("checked")){
		$("select#idHolding, select#idEmpresa, select#idCampana").attr("disabled", "true");
	}else{
		$("select#idHolding, select#idEmpresa, select#idCampana").removeAttr("disabled");
	}
	$("input#todosReporte").change(function(){
		if($(this).attr("checked")){
			$("select#idHolding, select#idEmpresa, select#idCampana").attr("disabled", "true");
		}else{
			$("select#idHolding, select#idEmpresa, select#idCampana").removeAttr("disabled");
		}
	});
	$("div#cuerpo").on("change", "input[type='checkbox'][esGrupo='1']", function(e){
		var total = $(this).attr("total");
		if($(this).attr("todos")=="1"){
			$(this).attr("todos", "0");
			$("input[grupo="+$(this).attr("id")+"]").attr("checked", false);
		}else{
			$("input[grupo="+$(this).attr("id")+"]").attr("checked", true);
			$(this).attr("todos", "1");
		}
	});
	/*
	if($("input#opSeccion").val()=="li"){
		$("table#formulario[name='segundo']").fadeIn(2000);	
		$("input#opSeccion").val("ed");
		$("input#nomSeccion").focus();
	}
	*/
	$("a#crearSec").click(function(e){
		$("input#opSeccion").val("nu");
		$("table#formulario[name='segundo']").fadeIn(2000);
		e.preventDefault();
	});
	
	$("a#seccion").click(function(e){
		$("input#opSeccion").val("pes");
		$("input#idSeccionPes").val($(this).parent("li").attr("id"));
		e.preventDefault();
		$("form#formConstructor").submit();
	});
	
	$("a#editarSec").click(function(e){
		$("input#opSeccion").val("ed");
		var id = $(this).parent("div").parent("li").attr("id");
		$("input#idSeccion").val(id);
		$("input#seccion"+id).show().focus();
		$(this).parent("div").parent("li").children("a#seccion").hide();
		e.preventDefault();
		
		//Falta agregar el reset del ID de la pestaña y borrar la opcion de seccion, ademas el class sel de la pestaña
	});
	
	$("ul#pestana li input").keydown(function(e){
		var tecla = e.keyCode;
		if(tecla==27){
			var seccion = $(this).parent("li").children("a#seccion");
			seccion.show();
			$(this).hide().val(seccion.html());
		}
	});
	
	$("a#eliminarSec").click(function(e){
		e.preventDefault();
		if(confirm("\xbfEst\xe1 seguro que desea eliminar el registro?")){
			$("input#opSeccion").val("el");
			$("input#idSeccion").val($(this).parent("div").parent("li").attr("id"));
			$("form#formConstructor").submit();
		}
	});
});