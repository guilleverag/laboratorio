<?php include_once('../../resources/template/template.php');?>
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
                                <div class="span9">
                                    <h2 class="title" id="resultTitle">
                                        Resultados obtenidos
                                    </h2>
                                </div>
                                <div class="span3 refback">
                                	<a href="<?php echo $_GET['back'].'.php';?>" class="moduleItemReadMore">
                                        Salir			
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="rt-mainbody span12"> 
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
	<?php 
		if(isset($_GET['idPaciente'])){
			echo 'var variables = "idPaciente='.$_GET['idPaciente'].'&comprobante='.$_GET['comprobante'].'&fecha='.$_GET['fecha'].'";';
		}else{
			echo 'var variables = "CdEmpresa='.$_GET['CdEmpresa'].'&contrasena='.$_GET['contrasena'].'&combo='.$_GET['combo'].'&filtro='.$_GET['filtro'].'&fechaD='.$_GET['fechaD'].'&fechaH='.$_GET['fechaH'].'";';
		}
	?>
	$(function() {
		$.ajax({
			type:		'POST',
			url:		'http://lab.ve2fsoft.com/resources/php/login.php',
			data:		variables,
			success:	function(data){
				$('#resultLoading').hide();
				$('#resultContent').html(data);
			}
		});
	});
	
	function resultadosPDF(tr,idPaciente,fecha,empresa){
		<?php if(!isset($_GET['idPaciente'])){?>
		$(tr).children('td:first').html('<i class="icon-ok" style="margin-left:10px;"></i>');
		window.location.href = 'http://lab.ve2fsoft.com/resources/php/resultado_pdf.php?idPaciente='+idPaciente+'&fecha='+fecha+'&empresa=si';
		<?php }else{?>
		window.location.href = 'http://lab.ve2fsoft.com/resources/php/resultado_pdf.php?idPaciente='+idPaciente+'&fecha='+fecha;
		<?php }?>
	}
</script>