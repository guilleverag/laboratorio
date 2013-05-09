<?php 
include_once('../resources/php/cargar_xml_examenes.php');
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
        <?php templateHeader(false, false, true);?>
		        
        <!-- Main -->
        <div id="rt-main" class="container">
        	<div class="row-fluid">
            	<div class="span12">
                	<div class="rt-block">
                    	<div class="itemHeader">
                            <div class="module-title">
                                <h2 class="title" id="resultTitle">
                                    Nuestros Ex&aacute;menes
                                </h2>
                            </div>
                        </div>
                        <div class="rt-mainbody"> 
                        	<div class="resultContent" id="resultContent"></div>
                            <div id="resultLoading" align="center">
                            	<img src="../resources/images/loading.gif">
                            </div>
                       	</div>
                    </div>
                </div>               
        	</div>
        </div>
        
        <div class="clear"></div>
        
        <!-- Footer -->
    	<?php templateFooter('../resources/');?>
        <script src="../resources/js/jquery.placeholder.js?<?php echo filemtime(dirname(__FILE__).'/../resources/js/jquery.placeholder.js'); ?>" type="text/javascript"></script>
  	</div>
</body></html>
<script>
	$(document).ready(function() {
		function toogleOn(){
			var cdgrupo = this.id;
			var numcdgrupo = cdgrupo.substr(13);
			var c = $('#'+cdgrupo+' .accordion-inner');
			
			if(c.children('#resultLoading').length > 0){
				$.ajax({
					type:		'POST',
					url:		'http://lab.ve2fsoft.com/resources/php/presupuesto.php',
					data:		'type=getOnlyExam&CdGrupo='+numcdgrupo,
					success:	function(data){
						c.html(data);
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