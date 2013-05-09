<?php 
include_once('../../resources/php/cargar_xml.php');
include_once('../../resources/template/template.php');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Laboratorio Clínico Medex</title>

    <?php templateHeaderInclude('../../resources/');?>
</head>

<body>
	<div class="wrapper">
		<!-- Header menu -->
        <?php templateHeader(false, false, true);?>
		        
        <!-- Main -->
        <div id="rt-main" class="container">
        	<div class="row-fluid">
            	
                <div class="span7">
                	<div class="rt-block">
                    	<div class="rt-mainbody">
                       
                            <div class="itemHeader">
                                <div class="module-title">
                                    <h2 class="title">
                                        Resultados pacientes
                                    </h2>
                                </div>
                           	</div>
                            <div class="itemBody">
                            	<div style="margin-bottom:25px; display:none;" id="resultHelp">
                                    <img width="445" src="../../resources/images/comprobante.jpg">
                                </div>
                                <form id="contact-form" class="contact-form labform">
                                    <div class="error" style="display: none;">
                                        Error!
                                        <strong> Los datos ingresados no coinciden con alg&uacute;n resultado.</strong>
                                    </div>
                                    <fieldset>
                                        <label class="name">
                                            <input name="fecha" id="resultDate" type="text" value="" placeholder="Fecha: (para pruebas 5/1/13)">
                                        </label>
                                        <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                        <br>
                                        <label class="email">
                                            <input name="idPaciente" type="number" value="" placeholder="Paciente: (para pruebas 737772)">
                                        </label>
                                        <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                        <br>
                                        <label class="phone">
                                            <input name="comprobante" type="text" value="" placeholder="Comp #: (para pruebas 0)">
                                        </label>
                                        <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                    </fieldset>
                                    <div class="pull-right">
                                        <a class="btn btn-small" data-type="help" href="javascript:void(false)" onClick="javascript:$('#resultHelp').show().delay(5000).fadeOut()">¿C&oacute;mo llenar?</a>
                                        <a class="btn btn-small" data-type="reset" href="javascript:void(false)" onClick="javascript:FormReset('#contact-form');">Limpiar</a>
                                        <a class="btn btn-small" data-type="submit" href="javascript:void(false)" onClick="javascript:FormSubmit('#contact-form');">Revisar</a>
                                    </div>
                                    <div class="clr"></div>
                                </form>
                            </div>
                        </div>
                    </div>
				</div>
                
                <div class="span4">
                	<div id="rt-sidebar-a">
                        <div class="sidebar">
                            <div class="rt-block">
                                <div id="k2ModuleBox81" class="k2ItemsBlock sidebar">
                                    <ul>
                                        <li class="odd firstItem">
                                        	<a class="moduleItemTitle" href="">Clientes</a>
                                            <div class="moduleItemIntrotext">
                                            	<p>¿Eres nuestro cliente?</p> 
                                                <p>Ve tus resultados en l&iacute;nea sin salir de tu oficina o lugar de trabajo.</p>
                                            </div>
                                            <div class="clr"></div>
                                            <div class="clr"></div>
                                            <a class="moduleItemReadMore" href="clientes.php"> Ver </a>
                                            <div class="clr"></div>
                                        </li>
                                        <li class="even">
                                        	<a class="moduleItemTitle" href="">Doctores</a>
                                            <div class="moduleItemIntrotext">
                                            	<p>¿Formas parte de nuestro doctores?</p> 
                                                <p>Ve tus resultados en l&iacute;nea sin salir de tu consultorio.</p>
                                            </div>
                                            <div class="clr"></div>
                                            <div class="clr"></div>
                                            <a class="moduleItemReadMore" href="doctores.php"> Ver </a>
                                            <div class="clr"></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                	</div>
                </div>
                
        	</div>
        </div>
        
        <div class="clear"></div>
        <br><br>
        <!-- Footer -->
    	<?php templateFooter('../../resources/');?>
        <script src="../../resources/js/jquery.placeholder.js?<?php echo filemtime(dirname(__FILE__).'/../../resources/js/jquery.placeholder.js'); ?>" type="text/javascript"></script>
  	</div>
</body></html>
<script>
	function FormReset(formID){
		$(formID+' :input').each (function(){
			var input = $(this);
			var padre = input.parent();
			
			input.val('');
			padre.css('border','2px solid #3278CD');
			padre.next().hide();
			
		});
		$(formID+' .error').hide()
	}
	
	function FormSubmit(formID){
		var formSubmit = true;
		$(formID+' :input').each (function(){
			var input = $(this);
			var padre = input.parent();
			if(input.val().length == 0){ 
				padre.css('border','2px solid #9D261D');
				padre.next().show();
				formSubmit = false;
			}else{
				padre.css('border','2px solid #3278CD');
				padre.next().hide();
			}
		});
		
		if(!formSubmit){
			$(formID+' .error').show().delay(3000).fadeOut();
		}else{
			$.ajax({
				type:		'POST',
				url:		'http://lab.ve2fsoft.com/resources/php/login.php',
				data:		'type=login&back=index&'+$(formID).serialize(),
				dataType: 	'json',
				error: 		function(xhr,status,error){
					$(formID+' .error').show().delay(3000).fadeOut();
				},
				success:	function(data){
					if(data.success){
						window.location.href = data.url;
					}else
						$(formID+' .error').show().delay(3000).fadeOut();
				}
			});
		}
	}
	
	$('input, textarea').placeholder();
	
	$("#resultDate").datepicker({
		changeYear: true,
		showButtonPanel: false,
		numberOfMonths: 1,
		dateFormat: "d/m/y",
		dayName: [
			"Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"
		],
		dayNamesMin: [
			"Do","Lu","Ma","Mi","Ju","Vi","Sa"
		],
		dayNamesShort: [
			"Dom","Lun","Mar","Mie","Jue","Vie","Sab"
		],
		monthNames: [
			"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"
		],
		monthNamesShort: [
			"Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"
		]
	});
</script>