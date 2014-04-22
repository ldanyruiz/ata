// JavaScript Document
$(document).ready(function(){
	$("input#inicioCampana, input#finalCampana").datepicker();
	$("input#fechnacUsuario").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1900:2020"
	});
	$("input#otroEmpresa, label[for='otroEmpresa'], input#otroNivel").hide();
	$("div#cuerpo").on("change", "input[otro='1']", function(e){
		var limite = parseInt($(this).parent("td").parent("tr").parent("tbody").parent("table").attr("name"));
		var nombre = $(this).attr("id");
		nombre = nombre.substring(4);
		var inicio = parseInt(nombre);
		if($(this).attr("checked")=="checked"){
			$(this).parent("td").next("td").children("input#otroNivel").show('slow');
			$(this).parent("td").prev("td").children("select#idNivel").find("option:selected").removeAttr("selected");
			$(this).parent("td").prev("td").children("select#idNivel").find("option:first").attr("selected", "SELECTED");
			$(this).parent("td").prev("td").children("select#idNivel").hide();
			
			if(inicio<limite){
				for(inicio=inicio+1; inicio<=limite; inicio++){
					$(this).parent("td").parent("tr").next("tr").find("td select#idNivel").find("option:selected").removeAttr("selected");
					$(this).parent("td").parent("tr").next("tr").find("td select#idNivel").find("option:first").attr("selected", "SELECTED");
					$(this).parent("td").parent("tr").next("tr").find("td select#idNivel option").remove();
					$(this).parent("td").parent("tr").next("tr").find("td select#idNivel").html("<option value='NULL'>Seleccione un elemento</option>");
					$(this).parent("td").parent("tr").next("tr").find("td select#idNivel").hide();
					$("input#otro"+inicio).attr("checked", "CHECKED").attr("disabled", "DISABLED");
					$("input#otro"+inicio).parent("td").next("td").children("input#otroNivel").show('slow');
				}
			}			
		}else{
			$(this).parent("td").next("td").children("input#otroNivel").hide('slow').val("");
			$(this).parent("td").prev("td").children("select").show();
			
			if(inicio<limite){
				for(inicio=inicio+1; inicio<=limite; inicio++){
					$(this).parent("td").parent("tr").next("tr").find("td select#idNivel").show();
					$("input#otro"+inicio).removeAttr("checked").removeAttr("disabled");
					$("input#otro"+inicio).parent("td").next("td").children("input#otroNivel").hide('slow').val("");
				}
			}
		}
	});
	$("button#finalizar").click(function(){
		window.location = $(this).parent("a").attr("href");
	});
	$("div#cuerpo").on("change", "select#idNivel", function(e){
		var nombre = $(this).parent("td").attr("id");
		nombre = nombre.substring(5);
		var numero = parseInt(nombre) + 1;
		
		$("td#nivel"+numero+" select#idNivel").load("cuestionario.php?ajaxNivel="+$(this).find(":selected").val()+" select#idNivel option")
		.ajaxStart(loadingShow).ajaxStop(loadingHide);
	});
	$("div#cuerpo").on("keypress", "form#formCampana", function(e){
		if(e.keyCode == 13){
			e.preventDefault();
		}
	});
	$("div#cuerpo").on("change", "input#noDni", function(e){
		if($(this).attr("checked")=="checked"){
			$("input#loginUsuario").attr("disabled", "disabled").val("");
		}else{
			$("input#loginUsuario").removeAttr("disabled");
		}
	});
	$("div#cuerpo").on("change", "input#altOtroEmpresa", function(e){
		if($(this).attr("checked")=="checked"){
			$("input#otroEmpresa, label[for='otroEmpresa']").show();
			$("select#idEmpresa").attr("disabled", "disabled");
		}else{
			$("input#otroEmpresa, label[for='otroEmpresa']").hide().val("");
			$("select#idEmpresa").removeAttr("disabled");
		}
	});
	$("div#cuerpo").on("submit", "form#formCampana", function(e){
		if(confirm("\xbfEst\xe1 seguro que desea continuar?")){
			var ord = $("input#ord").val();
			switch(ord){
				case '4':
					if($("input#archCampana").val()!=""){
						$("input#ord").val(3);
					}
					break;
			}
		}else{
			return false;
		}
	});
	$("div#cuerpo").on("click", "a#eliminarUsuario", function(e){
		if(!confirm("\xbfEst\xe1 seguro que desea eliminar el usuario?")){
			e.preventDefault();
		}
	});
	$("div#cuerpo").on("click", "button#guardar, button#lanza", function(e){
		$("input#estCampana").val($(this).attr("name"));
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
});

$(document).ajaxStart(loadingShow).ajaxStop(loadingHide);

function loadingShow(){
	$("img#loading").show();
}
function loadingHide(){
	$("img#loading").hide();
}