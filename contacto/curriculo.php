<?php 
include_once('../resources/template/template.php');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Laboratorio Clínico Medex</title>

    <?php templateHeaderInclude('../resources/');?>
</head>

<body>
	<div class="wrapper">
		<!-- Header menu -->
        <?php templateHeader(false, false, false, false, true);?>
		        
        <!-- Main -->
        <div id="rt-main" class="container">
        	<div class="row-fluid">
            	
                <div class="span7">
                	<div class="rt-block">
                    	<div class="rt-mainbody">
                       
                            <div class="itemHeader">
                                <div class="module-title">
                                    <h2 class="title">
                                        Env&iacute;a tu Curr&iacute;culo
                                    </h2>
                                </div>
                           	</div>
                            <div class="itemBody">
                                <form id="contact-form" class="contact-form labform">
                                    <div class="success" style="display: none;">
                                        Enviado satisfactoriamente!
                                        <strong> Estaremos en contacto pronto.</strong>
                                    </div>
                                    <fieldset>
                                        <label class="name">
                                            <input name="nombre" type="text" value="" placeholder="Nombre:">
                                        </label>
                                        <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                        <br>
                                        <label class="name">
                                            <input name="apellido" type="text" value="" placeholder="Apellido:">
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
                                        <br>
                                        <label class="email">
                                            <select name="sexo">
                                            	<option selected value="M">Masculino</option>
                                                <option value="F">Femenino</option>
                                            </select>
                                        </label>
                                        <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                        <br>
                                        <label class="email">
                                            <select name="area">
                                            	<option selected value="B">Bionalista</option>
                                                <option value="A">Asistente</option>
                                            </select>
                                        </label>
                                        <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                        <br>
                                        <label class="email">
                                        	<input type="file" name="curriculo" placeholder="Curr&iacute;culo:">
                                        </label>
                                        <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                    </fieldset>
                                    <div class="pull-right">
                                        <a class="btn btn-small" data-type="reset" href="javascript:void(false)" onClick="javascript:FormReset('#contact-form');">Limpiar</a>
                                        <a class="btn btn-small" data-type="submit" href="javascript:void(false)" onClick="javascript:FormSubmit('#contact-form');">Enviar</a>
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
                                        	<a class="moduleItemTitle" href="">Contacto</a>
                                            <div class="moduleItemIntrotext">
                                            	<p>¿Quiere comunicarse directamente con nosotros?</p> 
                                                <p>Estamos a la orden.</p>
                                            </div>
                                            <div class="clr"></div>
                                            <div class="clr"></div>
                                            <a class="moduleItemReadMore" href="index.php"> Cont&aacute;ctanos </a>
                                            <div class="clr"></div>
                                        </li>
                                        <li class="odd firstItem">
                                        	<a class="moduleItemTitle" href="">Organizaci&oacute;n</a>
                                            <div class="moduleItemIntrotext">
                                            	<p>Conozca acerca de nosotros, de nuestra organizaci&oacute;n.</p> 
                                            </div>
                                            <div class="clr"></div>
                                            <div class="clr"></div>
                                            <a class="moduleItemReadMore" href="../laboratorio/"> ver </a>
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
    	<?php templateFooter('../resources/');?>
        <script src="../resources/js/jquery.placeholder.js?<?php echo filemtime(dirname(__FILE__).'/../resources/js/jquery.placeholder.js'); ?>" type="text/javascript"></script>
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