<?php 
include_once('../../resources/php/cargar_xml_empresa.php');
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
                                        Resultados clientes
                                    </h2>
                                </div>
                           	</div>
                            <div class="itemBody">
                                <form id="contact-form" class="contact-form labform">
                                    <div class="error" style="display: none;">
                                        Error!
                                        <strong> Los datos ingresados no coinciden con alg&uacute;n resultado.</strong>
                                    </div>
                                    <fieldset>
                                        <label class="name">
                                            <input name="CdEmpresa" type="text" value="" placeholder="C&oacute;digo Cliente:">
                                        </label>
                                        <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                        <br>
                                        <label class="email">
                                            <input name="contrasena" type="password" value="" placeholder="Contrase&ntilde;a:">
                                        </label>
                                        <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                        <br>
                                        <label class="halfDate">
                                            <input name="fechaD" id="fechaD" type="text" value="" placeholder="Fecha Desde:">
                                        </label>
                                        <label class="halfDate" style="float:right;">
                                            <input name="fechaH" id="fechaH" type="text" value="" placeholder="Fecha Hasta:">
                                        </label>
                                        <span class="empty" style="display: none;">*Estos campos son obligatorios.</span>
                                        <br>
                                        <label class="email">
                                            <select name="combo" id="filterCombo">
                                            	<option selected value="T">Todos</option>
                                                <option value="A">Admisi&oacute;n</option>
                                                <option value="H">Historia</option>
                                                <option value="C">Clave</option>
                                                <option value="CI">CI Paciente</option>
                                                <option value="N">Nombre PAciente</option>
                                            </select>
                                        </label>
                                        <br>
                                        <div id="filterFill" style="display:none;">
                                            <label class="email">
                                                <input name="filtro" type="text" value="" placeholder="Escriba:">
                                            </label>
                                            <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                        </div>
                                    </fieldset>
                                    <div class="pull-right">
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
                                        	<a class="moduleItemTitle" href="">Registro Cliente</a>
                                            <div class="moduleItemIntrotext">
                                            	<p>¿Quieres ser nuestro cliente?</p> 
                                            </div>
                                            <div class="clr"></div>
                                            <div class="clr"></div>
                                            <a class="moduleItemReadMore" href="registro.php?cliente=1"> Reg&iacute;strate </a>
                                            <div class="clr"></div>
                                        </li>
                                        <li class="even">
                                        	<a class="moduleItemTitle" href="">Pacientes</a>
                                            <div class="moduleItemIntrotext">
                                            	<p>¿Si t&uacute; eres nuestro paciente?</p> 
                                                <p>Ve tus resultados en l&iacute;nea con tu factura o comprobante.</p>
                                            </div>
                                            <div class="clr"></div>
                                            <div class="clr"></div>
                                            <a class="moduleItemReadMore" href="index.php"> Ver </a>
                                            <div class="clr"></div>
                                        </li>
                                        <li class="odd">
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
			padre.next('span').hide();
			
		});
		$('#filterCombo').val('T').parent().css('border','2px solid #3278CD');
		$('#filterFill').hide();
		$(formID+' .error').hide()
	}
	
	function FormSubmit(formID){
		var formSubmit = true, combo=$('#filterCombo').val();
		$(formID+' :input').each (function(){
			var input = $(this);
			var padre = input.parent();
			if(input.val().length == 0){ 
				padre.css('border','2px solid #9D261D');
				padre.next('span').show();
				formSubmit = false;
				if(input.attr('name')=='filtro' && combo=='T') formSubmit = true;
			}else{
				padre.css('border','2px solid #3278CD');
				padre.next('span').hide();
			}
		});
		
		if(!formSubmit){
			$(formID+' .error').show().delay(3000).fadeOut();
		}else{
			$.ajax({
				type:		'POST',
				url:		'http://lab.ve2fsoft.com/resources/php/login.php',
				data:		'type=login&back=clientes&'+$(formID).serialize(),
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
	
	var opt = {
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
	};
	
	$("#fechaD").datepicker(opt);
	$("#fechaH").datepicker(opt);
	$('#filterCombo').change(function(e) {
		if($(this).val() == 'T')
			$('#filterFill').hide();
		else{
			$('#filterFill input').val('');
			$('#filterFill').show();
		}
    });
</script>