<?php include_once('../resources/template/template.php');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Medex</title>

    <?php templateHeaderInclude('../resources/');?>
</head>

<body>
	<div class="wrapper">
		<!-- Header menu -->
        <?php templateHeader(false, false, false, false, true);?>
		        
        <!-- Main -->
        <div id="rt-main" class="hborder">
        	<div class="rt-container">
            	
                <div class="span7">
                	<div class="rt-block">
                    	<div class="rt-mainbody">
                       
                            <div class="itemHeader">
                                <div class="module-title">
                                    <h2 class="title">
                                        Cont&aacute;ctanos
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
                                            <input type="text" value="" placeholder="Nombre:">
                                        </label>
                                        <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                        <br>
                                        <label class="email">
                                            <input type="email" value="" placeholder="Email:">
                                        </label>
                            			<span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                        <br>
                                        <label class="phone">
                                            <input type="text" value="" placeholder="Telefono:">
                                        </label>
                                        <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                        <br>
                                        <label class="message">
                                            <textarea placeholder="Mensaje:"></textarea>
                                        </label>
                                        <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                    </fieldset>
                                    <div class="pull-right">
                                        <a class="btn btn-small" data-type="reset" href="javascript:void(false)" onClick="javascript:FormReset('#contact-form');">Limpiar</a>
                                        <a class="btn btn-small" data-type="submit" href="javascript:void(false)" onClick="javascript:FormSubmit('#contact-form');">Enviar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
				</div>
                
                <div class="span5">
                	<div class="rt-block">
                    	<div class="map">
                        	<iframe src="http://maps.google.co.ve/maps?f=q&amp;source=s_q&amp;hl=es-419&amp;geocode=&amp;q=Maternidad+La+Floresta+Maracay,+Aragua&amp;aq=&amp;sll=10.26748,-67.589779&amp;sspn=0.01706,0.027037&amp;ie=UTF8&amp;hq=&amp;hnear=Maternidad+La+Floresta,+Calle+Comercio,+Barrio+La+Lagunita,+Maracay,+Girardot,+Aragua&amp;t=m&amp;z=14&amp;iwloc=A&amp;output=embed" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" width="370" height="350"></iframe>
                        </div>
                        <address class="address">
                            <strong class="lead">
                                Avenida Las Delicias con Calle Comercio,
                                <br>
                                Maracay. Edo. Aragua. Venezuela.
                            </strong>
                            <br>
                            <span>Telefono:</span>
                            +1 800 123 4567
                            <br>
                            <span>FAX:</span>
                            +1 504 889 9898
                            <br>
                            E-mail:
                            <a class="link-2" href="#">mail@medex.com</a>
                        </address>
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