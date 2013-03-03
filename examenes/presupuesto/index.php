<?php include_once('../../resources/template/template.php');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Medex</title>

    <?php templateHeaderInclude('../../resources/');?>
</head>

<body>
	<div class="wrapper">
		<!-- Header menu -->
        <?php templateHeader(false, false, true);?>
		        
        <!-- Main -->
        <div id="rt-main" class="hborder">
        	<div class="rt-container">
            	<div class="span7">
                	<div class="rt-block">
                    	<div class="itemHeader">
                            <div class="module-title">
                                <h2 class="title" id="resultTitle">
                                    Presupuesto
                                </h2>
                            </div>
                        </div>
                        <div class="rt-mainbody"> 
                        	<div class="resultContent" id="resultContent"></div>
                            <div id="resultLoading" align="center">
                            	<img src="../../resources/images/loading.gif">
                            </div>
                       	</div>
                    </div>
                </div> 
                
                <div class="span5" style="margin-top:50px;">
                	<div class="rt-block">
                    	<div class="rt-mainbody">
                            <div class="itemBody">
                                <form id="presupuesto-form" class="presupuesto-form labform">
                                	<fieldset>
                                        <label class="name">
                                            <input name="nombre" type="text" value="" placeholder="Nombre:">
                                        </label>
                                        <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                        <br>
                                        <label class="email">
                                            <input name="cedula" type="text" value="" placeholder="Cedula:">
                                        </label>
                                        <span class="empty" style="display: none;">*Este campo es obligatorio.</span>
                                        <div>
                                        	<input id="campoIdExamen" name="IdExamen" type="hidden" value="">
                                        	<input id="campoTotalCosto" name="TotalCosto" type="hidden" value="0">
                                        </div>
                                    </fieldset>
                                    <div>
                                    	<table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Examen</th>
                                                    <th style="width:50px;">BsF</th>
                                                </tr>
                                            </thead>
                                            <tbody id="presupuestoContentActive">
                                            	<tr>
                                                	<td colspan="2">Ningun examen seleccionado.</td>
                                                </tr>
                                                <tr class="totalPrice">
                                                	<td style="text-align:right;">Total:</td>
                                                    <td><span id="totalPrecioActive">0 </span>Bsf</td>
                                                </tr>
                                            </tbody>
                                       	</table>
                                    </div>
                                    <div class="error" style="display: none;">
                                        Error!
                                        <strong> Es necesario seleccionar al menos un examen para imprimir el presupuesto.</strong>
                                    </div>
                                    <div class="pull-right">
                                        <a class="btn btn-small" data-type="reset" href="javascript:void(false)" onClick="javascript:FormReset('#presupuesto-form');">Limpiar</a>
                                        <a class="btn btn-small" data-type="submit" href="javascript:void(false)" onClick="javascript:FormSubmit('#presupuesto-form');">Imprimir</a>
                                    </div>
                                </form>
                            </div>
                        </div>
	                </div>
                </div>               
        	</div>
        </div>
        
        <div class="clear"></div>
        
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
		
		var examen = $('#campoIdExamen'), costo = $('#campoTotalCosto'), tabla = $('#presupuestoContentActive');
		examen.val('');
		costo.val(0);
		tabla.html('<tr><td colspan="2">Ningun examen seleccionado.</td></tr><tr class="totalPrice"><td>Total:</td><td><span>0 </span>Bsf</td></tr>');
		
		$('.table tr input:checked').each(function(index, e) {
			$(e).attr('checked',false);
		});
		
		$(formID+' .error').hide();
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
		
		if(!formSubmit){
			if($('#campoIdExamen').val().length == 0) $(formID+' .error').show();
		}else{
			window.location.href = 'http://lab.ve2fsoft.com/resources/php/presupuesto_pdf.php?'+$(formID).serialize();
		}
	}
	
	function unCheck(val){
		$('#'+val).attr('checked',false);
		updateTable();
	}
	
	function updateTable(){
		var examen = $('#campoIdExamen'), costo = $('#campoTotalCosto'), tabla = $('#presupuestoContentActive');
		examen.val('');
		costo.val(0);
		tabla.html('');
		
		$('.table tr input:checked').each(function(index, e) {
			var aux = e.value.split('^');
			if(examen.val().length > 0) examen.val(examen.val()+','+aux[0]); else examen.val(aux[0]);
			costo.val(parseFloat(costo.val())+parseFloat(aux[2]));
			tabla.append('<tr><td><a href="javascript:void(false)" onClick="unCheck('+aux[0]+')"><i class="icon-remove"></i></a>'+(aux[1])+'</td><td style="text-align: right;">'+(aux[2])+' BsF</td></tr>');
		});
		
		if(examen.val().length == 0)
			tabla.html('<tr><td colspan="2">Ningun examen seleccionado.</td></tr><tr class="totalPrice"><td>Total:</td><td><span>0 </span>Bsf</td></tr>');
		else
			tabla.append('<tr class="totalPrice"><td>Total:</td><td><span>'+costo.val()+' </span>Bsf</td></tr>');
	}
	
	$(document).ready(function() {
		
		function checkToogle(){
			var e = $(this);

			if(e.is(':checked') || e.attr('checked'))
				checkOn(e);
			else
				checkOff(e);
		}
		
		function checkOn(input){
			input.attr('checked', true);
			$('#presupuesto-form .error').hide();
			updateTable();
		}
		
		function checkOff(input){
			input.attr('checked', false);
			updateTable();
		}
		
		function toogleOn(){
			var cdgrupo = this.id;
			var numcdgrupo = cdgrupo.substr(13);
			var c = $('#'+cdgrupo+' .accordion-inner');
			
			if(c.children('#resultLoading').length > 0){
				$.ajax({
					type:		'POST',
					url:		'http://lab.ve2fsoft.com/resources/php/presupuesto.php',
					data:		'type=getExam&CdGrupo='+numcdgrupo,
					success:	function(data){
						c.html(data);

						$('.table tr').on('click',function (e){
							if (e.target.type !== 'checkbox') {
								var input = $(this).find('input');
								
								if(input.is(':checked') || input.attr('checked'))
									checkOff(input);
								else
									checkOn(input);
							}
						});
						$('.table tr input').on('click',checkToogle);
						
					}
				});
			}
			
			$('#imgGrupo'+numcdgrupo).removeClass('icon-chevron-right').addClass('icon-chevron-down');
		}
		
		function toogleOff(){
			var numcdgrupo = this.id.substr(13);
			$('#imgGrupo'+numcdgrupo).removeClass('icon-chevron-down').addClass('icon-chevron-right');
		}
		
		$('input, textarea').placeholder();
		
		$.ajax({
			type:		'POST',
			url:		'http://lab.ve2fsoft.com/resources/php/presupuesto.php',
			data:		'type=getGrupo',
			success:	function(data){
				$('#resultLoading').hide();
				$('#resultContent').html(data);
				
				$('.accordion-body.collapse').on({
					'show': toogleOn,
					'hide': toogleOff
				});
			}
		});
	});
</script>