<?php 
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
                                        Solicitud de Registro
                                    </h2>
                                </div>
                           	</div>
                            <div class="itemBody">
                                <form id="contact-form" class="contact-form labform">
                                    <div class="success" style="display: none;">
                                        Enviado satisfactoriamente!
                                        <strong> Estaremos en contacto pronto, con sus datos para acceder a nuestro sistema en línea.</strong>
                                    </div>
                                    <fieldset>
                                        <label class="name">
                                            <input name="nombre" type="text" value="" placeholder="Nombre:">
                                        </label>
                                        <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                        <br>
                                        <label class="email">
                                            <input name="email" type="text" value="" placeholder="Email:">
                                        </label>
                                        <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                        <br>
                                        <label class="email">
                                            <input name="telefono" type="text" value="" placeholder="Telefono:">
                                        </label>
                                        <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                    </fieldset>
                                    <div class="pull-right">
                                        <a class="btn btn-small" data-type="reset" href="javascript:void(false)" onClick="javascript:FormReset('#contact-form');">Limpiar</a>
                                        <a class="btn btn-small" data-type="submit" href="javascript:void(false)" onClick="javascript:FormSubmit('#contact-form');">Enviar</a>
                                    </div>
                                    <div class="clr"></div>
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
                                <div class="itemHeader">
                                    <div class="module-title">
                                        <h4 class="title">
                                            Se parte de nuestros selectos <?php echo isset($_GET['cliente']) ? 'clientes' : 'doctores';?>
                                        </h4>
                                    </div>
                                </div>
                                
                                <div class="itemBody">
                                    <div class="itemFullText">
                                        <p>Realiza la solicitud completando el formulario.</p>
                                        <p>Tan pronto la recibamos, procederemos a enviarle vía email una notificación con la respuesta a su solicitud.</p>
                                        <p>De ser aprobada, encontrara los datos esenciales para consultar sus resultados a través del sistema.</p>
                                    </div>
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
	}
	
	function FormSubmit(formID){
		var formSubmit = true;
		$(formID+' :input').each (function(){
			var input = $(this);
			var padre = input.parent();
			if(input.val().length == 0){ 
				padre.css('border','2px solid #9D261D');
				padre.next('span').show();
				formSubmit = false;
			}else{
				padre.css('border','2px solid #3278CD');
				padre.next('span').hide();
			}
		});
		
		if(formSubmit){
			FormReset(formID);
			$(formID+' .success').show().delay(3000).fadeOut();
		}
	}
	
	$('input, textarea').placeholder();
</script>