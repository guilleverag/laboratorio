<?php 
include_once('../../resources/php/cargar_xml_indicaciones.php');
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
            	<div class="span12">
                	<div class="rt-block">
                    	<div class="itemHeader">
                            <div class="module-title">
                                <h2 class="title" id="resultTitle">
                                    Indicaciones
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
               
        	</div>
        </div>
        
        <div class="clear"></div>
        
        <!-- Footer -->
    	<?php templateFooter('../../resources/');?>
  	</div>
</body></html>
<script>
	$(function() {
		$.ajax({
			type:		'POST',
			url:		'http://lab.ve2fsoft.com/resources/php/indicaciones.php',
			data:		'type=getIndicaciones',
			success:	function(data){
				$('#resultLoading').hide();
				$('#resultContent').html(data);
				
				$('.accordion-body.collapse').on({
					'show': function(){
						var id = this.id;
						var numid = id.substr(13);
						var c = $('#'+id+' .accordion-inner');
						
						if(c.children('#resultLoading').length > 0){
							$.ajax({
								type:		'POST',
								url:		'http://lab.ve2fsoft.com/resources/php/indicaciones.php',
								data:		'type=getPasos&idindicaciones='+numid,
								success:	function(data){
									c.html(data);
								}
							});
						}
						
						$('#imgGrupo'+numid).removeClass('icon-chevron-right').addClass('icon-chevron-down');
					},
					'hide': function(){
						var numid = this.id.substr(13);
						$('#imgGrupo'+numid).removeClass('icon-chevron-down').addClass('icon-chevron-right');
					}
				});
			}
		});
	});
</script>