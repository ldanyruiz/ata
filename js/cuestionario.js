$(document).ready(function(er){
	$("button#resolver, a button").click(function(){
		window.location = $(this).parent("a").attr("href");
	});
	$($("input#fecha").val()).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1900:2020"
	});
        var i = 1000;
        $("input[esFecha='1']").each(function(e2){
            $(this).attr("id", "fecha"+i);
            $(this).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "1900:2020"
            });
            i++;
        });        
	$("div#cuerpo").on("change", "select#idNivel", function(e){
		var nombre = $(this).parent("p").attr("id");
		nombre = nombre.substring(5);
		var numero = parseInt(nombre) + 1;
		
		$("p#nivel"+numero+" select#idNivel").load("cuestionario.php?ajaxNivel="+$(this).find(":selected").val()+" select#idNivel option")
		.ajaxStart(loadingShow).ajaxStop(loadingHide);
	});
	$("div#cuerpo").on("keyup", "input[type='text']", function(){
		if($(this).attr("num")=="1"){
			if(isNaN($(this).val())){
				alert("El valor ingresado debe ser num\xe9rico.");
				$(this).val("");
			}
		}
	});
	$("div#cuerpo").on("click", "option, input[type='radio'], input[type='checkbox']", function(){
		var bool= parseInt($(this).attr("depen"));
		if(bool){
			var num = $(this).attr('name');
			var num = num.replace('r', '');
			var num = num.replace('[]', '');
			if($(this).parent('td').find('table#cuestionario').length==0){
				var id = $(this).attr('id');
				var td = $(this).parent('td');
				var anterior = td.html();
				td.load("cuestionario.php?ajax=1&multi="+$("input#p"+num).attr("multi")+"&num="+num+"&id="+$("input#p"+num).val()+"&campana="+$("input#campana").val()+" div#ajax", function(e){			
					td.prepend(anterior);
					if($("#"+id).tagName!='option'){
						$("#"+id).attr("checked", true);
					}else{
						$("#"+id).attr("selected", true);
					}
				});
			}
		}else{
			$(this).parent('td').find('table#cuestionario').remove();
		}
	});
	$("div#cuerpo").on("click", "a#delQuestion", function(e){
		var actual = $(this);
		actual.prev('input[type="text"], textarea').remove();
		actual.prev('br').remove();
		actual.remove();
		e.preventDefault();
	});
	$("div#cuerpo").on("click", "a#delQuestionGroup", function(e){
		$(this).parent('td').parent('tr').remove();
		e.preventDefault();
	});
	$("div#cuerpo").on("click", "a#addGroup", function(e){
		var quitar = " <a id='delQuestionGroup' href='#'>Quitar</a>";
		var fila = $(this).parent('td').parent('tr').parent('thead').parent('table').children('tbody').find('tr:last').clone();
		$(this).parent('td').parent('tr').parent('thead').parent('table').find('tbody').append(fila);
		$(this).parent('td').parent('tr').parent('thead').parent('table').find('tbody').children('tr:last').children('td:first').html(quitar);
		var i = 1;
		$("input[class='hasDatepicker']").each(function(datos){
			$(this).attr("id", $(this).attr("id")+i);
			$(this).removeClass();
			$(this).datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: "1900:2020"
			});
			i++;
		});
		$(this).parent('td').parent('tr').parent('thead').parent('table').children('tbody').children('tr:last').find("input[type='text'], textarea").each(function(datos){
			$(this).val("");
		});
		var i = 1;
		$(this).parent('td').parent('tr').parent('thead').parent('table').children('tbody').children('tr:last').find("select[obli='1']").each(function(datos){
			$(this).attr("id", $(this).attr("id")+i);
			i++;
		});
		e.preventDefault();
	});
	$("div#cuerpo").on("click", "a#addQuestion", function(e){
		if($(this).parent('td').parent('tr').next().children('td:last').find('table#cuestionario').length==0){
			var contenido = $(this).parent('td').parent('tr').next('tr').children('td:last').find('input[type="text"]:last, textarea:last').clone();
			if(contenido.html()!=null){
				var quitar = " <a id='delQuestion' href='#'>Quitar</a>";
				$(this).parent('td').parent('tr').next('tr').children('td:last').append("<br />");
				$(this).parent('td').parent('tr').next('tr').children('td:last').append(contenido);
				$(this).parent('td').parent('tr').next('tr').children('td:last').append(quitar);
				$(this).parent('td').parent('tr').next('tr').children('td:last').find("input:last, textarea:last").val("");
			}
		}else{
			var quitar = " <a id='delQuestionGroup' href='#'>Quitar</a>";
			var fila = $(this).parent('td').parent('tr').next().children('td:last').find('table#cuestionario').find('tr:last').clone();
			$(this).parent('td').parent('tr').next().children('td:last').find('table#cuestionario').append(fila);
			$(this).parent('td').parent('tr').next().children('td:last').find('table#cuestionario').find("tr:last").children('td:first').html(quitar);
			$(this).parent('td').parent('tr').next().children('td:last').find('table#cuestionario').find("tr:last").find("input[type='text'], textarea").each(function(datos){
				$(this).val("");																																	 			});
			$(this).parent('td').parent('tr').next().children('td:last').find('table#cuestionario').find("tr:last").find("input[type='radio']").each(function(datos){
				var id = $(this).attr("id");
				
				/*var index = id.substring((id.indexOf('a', 0)+1), id.length);
				var numero = parseInt(index) + 1;
				id = id.substring(id.indexOf('a', 0), index);*/
				
				var aleatorio = Math.round(Math.random() * 10000);
				id += aleatorio;
				$(this).attr("id", id);																													 			});
		}

                        var i=100;
			$("input[esFecha='1']").each(function(e2){               
                                $(this).attr("id","fecha"+i);
				$(this).removeClass("hasDatepicker").datepicker({
                                        changeMonth: true,
                                        changeYear: true,
                                        yearRange: "1900:2020"
                                });	
                                i++;
			});                
		e.preventDefault();
	});
	
	$("input[title='ajax']").each(function(e){
		var num = $(this).val();
		$(this).parent("td").load("cuestionario.php?ajax=1&multi=1&num="+num+"&id="+$("input#p"+num).val()+"&campana="+$("input#campana").val()+" div#ajax", null, function(e2){
			$("input[esFecha='1']").each(function(e2){
				$(this).datepicker({
                                        changeMonth: true,
                                        changeYear: true,
                                        yearRange: "1900:2020"
                                });	
			});
		});
	});
	
	$("form#formCuestionario").submit(function(e){
		var boolInputText = true;
		var boolSelect = true;
		var boolInputRadio = true;
		var boolTextarea = true;
                var boolCheckbox = true;
		
		var marcado = null;
		
		$(".falt").each(function(datos){
			$(this).removeClass("falt");
		});
		
                var controles = 0;
                $("input[type='checkbox']").each(function(datos){   
                    controles=controles+1;
                });                
                
                //alert(controles);             
                var marcados=0;
                if(controles>0){
                    $("input[type='checkbox']").each(function(datos){                    
                        if(($(this).prop("checked"))){
                            marcados++;
                        }
                        
                        
    //                            if($("input[name='"+$(this).attr("name")+"']:checked").length==0){
    //					boolInputRadio = false;
    //					$(this).addClass("falt");
    //					if(marcado==null){
    //						marcado = $(this);						
    //					}
    //				}                    
                    });  
                    if(marcados==0){ boolCheckbox = false;}
                }
                
                //alert('marcados:'+marcados);
                
		$("input[obli='1']").each(function(datos){
			if($(this).attr('type')=='text'){
				if($(this).val()==''){
					boolInputText = false;
					$(this).addClass("falt");
					if(marcado==null){
						marcado = $(this);						
					}
				}
			}else if($(this).attr('type')=='radio'){
				if($("input[name='"+$(this).attr("name")+"']:checked").length==0){
					boolInputRadio = false;
					$(this).addClass("falt");
					if(marcado==null){
						marcado = $(this);						
					}
				}
			}
		});
		
		$("select[obli='1']").each(function(datos){
			if($("select#"+$(this).attr('id')).find("option:selected").val()=='NULL' || $("select#"+$(this).attr('id')).find("option:selected").val()=='Ninguno'){
				boolSelect = false;
				$(this).addClass("falt");
				if(marcado==null){
					marcado = $(this);						
				}
			}
		});
		
		$("textarea[obli='1']").each(function(datos){
			if($(this).val()==''){
				boolTextarea = false;
				$(this).addClass("falt");
				if(marcado==null){
					marcado = $(this);						
				}
			}
		});
		if(boolInputText && boolInputRadio && boolSelect && boolTextarea && boolCheckbox){
			if(!confirm("\xbfEst\xe1 seguro que desea guardar sus respuestas y continuar? Las respuestas no podr\xe1n ser editas despu\xe9s.")){
				e.preventDefault();
			}
		}else{
			e.preventDefault();
			alert('Debes llenar todos los campos obligatorios.');
			if(marcado!=null){
				if(marcado.attr("type")=="text"){
					marcado.focus();
				}
			}
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