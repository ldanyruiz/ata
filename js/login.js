// JavaScript Document
$(document).ready(initLogin);

function initLogin(){
	$("input#user").focus();
	var x = $("#formLogin");
	x.submit(comprobar);
}

function comprobar(){
	if($("input#user").val()=="" || $("input#pass").val()==""){		
		if($("input#user").val()==""){
			msj = "Debe ingresar el usuario. ";
			txt = "#user";
		}
		if($("input#pass").val()==""){
			msj = "Debe ingresar la clave.";
			txt = "#pass";
		}		
		if($("input#user").val()=="" && $("input#pass").val()==""){
			msj = "Debe ingresar el usuario y la clave. ";
			txt = "#user";
		}
		alert(msj);
		$(txt).focus();
		return false;
	}else{
		return true;
	}
}