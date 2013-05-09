<?php

include('conexion.php');
conectar();

$especiales_caracteres=array("\\'c1","\\'e1","\\'c0","\\'e0","\\'c9","\\'e9","\\'c8","\\'e8","\\'cd","\\'ed","\\'cc","\\'ec","\\'d3","\\'f3","\\'d2","\\'f2","\\'da","\\'fa","\\'d9","\\'f9","\\'80","\\'d1","\\'f1","\\'c7","\\'e7","\\'dc","\\'fc","\\'bf","\\'a1","\\'b7","\\'a9","\\'ae","\\'ba","\\'aa","\\'b2","\\'b3");
$especiales_caracteres_c=array("&Aacute;","&aacute;","&Agrave;","&agrave;","&Eacute;","&eacute;","&Egrave;","&egrave;","&Iacute;","&iacute;","&Igrave;","&igrave;","&Oacute;","&oacute;","&Ograve;","&ograve;","&Uacute;","&uacute;","&Ugrave;","&ugrave;","&#8364;","&Ntilde;","&ntilde;","&Ccedil;","&ccedil;","&Uuml;","&uuml;","&#191;","&#161;","&middot;","&copy;","&reg;","&ordm;","&ordf;","&sup2;","&sup3;");

$idPaciente=$_GET['idPaciente'];
$fecha = $_GET['fecha'];
$pagina=1;

$query="SELECT * FROM web WHERE IdPaciente=$idPaciente AND Fecha='$fecha' ORDER BY Pagina";
$result=mysql_query($query) or die($query.mysql_error());

//Actualizacion de la vista
if(isset($_GET['empresa'])){
	$query="UPDATE web SET seen=1 WHERE idPaciente=$idPaciente AND fecha='$fecha'";
	mysql_query($query) or die($query.mysql_error());
}

include('class/rtfclass.php');
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><header><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></header><body><style>
	.pdf_titulo{
		background-color:#FFF;border:none;font-family: Verdana, Geneva, sans-serif;text-align:left;font-size:10px;
	}
	.blue{
		color: #024bff;font-weight:bold;font-size:13px;
	}
	.pdf_resultado{
		font-family: Verdana, Geneva, sans-serif;font-size:large;font-weight:bold;border:medium solid #777777;width:385px;text-indent: 2px;
	}
	.pdf_contenido{
		width:100%;margin: 0 auto;height:780px;
	}
	.f0s18{
		font-family:"Lucida Console", Monaco, monospace;font-size:13px;line-height: 12px;
	}
	.saltopagina{
		page-break-after:always;
	}
	.body{
		font-family:helvetica;
	}
</style>
<?php
	$ind=0;
	while($r=mysql_fetch_array($result)){
		if($ind>0) echo '<br class="saltopagina" /><br class="saltopagina" />';
		$ind++;
?>
<div style="margin:0 auto; width:800px; height:1000px; font-family:helvetica;">
    <table width="100%" cellspacing="0px" cellpadding="0px"><tr height="10px"><td rowspan="5" align="center" width="140px"><img src="../images/logo/logo_solo.png" height="90"></td><td class="pdf_titulo blue">LABORATORIO CLINICO MEDEX, C.A.</td></tr><tr height="10px"><td class="pdf_titulo">Avenida Las Delicias con Calle Comercio, </td></tr><tr><td class="pdf_titulo">Maracay. Edo. Aragua. Venezuela. </td></tr><tr><td class="pdf_titulo">Telefono: +1 800 123 4567 FAX: +1 504 889 9898 </td></tr><tr><td class="pdf_titulo">E-mail: mail@medex.com</td></tr></table>
    
    <table width="100%" cellspacing="0px" cellpadding="0px" style="font-size:12px;">
        <tr>
           	<td align="center" valign="middle" width="50" style="border:solid thin; border-right:none;">
           		<span style="color:#F00;">No.</span><br>
                <?php echo $r['IdPaciente'];?>
           	</td>
            <td align="center" valign="middle" style="border:solid thin; border-right:none;">
           		<span style="color:#F00;">PACIENTE</span><br>
                <?php echo $r['Nombre'];?>
           	</td>
            <td align="center" valign="middle" width="60" style="border:solid thin; border-right:none;">
           		<span style="color:#F00;">EDAD</span><br>
                <?php echo $r['Edad'].' '.($r['MesAno']==2 ? 'Años' : ($r['MesAno']==0 ? 'Meses' : 'Días'));?>
           	</td>
            <td align="center" valign="middle" width="70" style="border:solid thin; border-right:none;">
           		<span style="color:#F00;">C.I.</span><br>
                <?php echo $r['CI'];?>
           	</td>
            <td align="center" valign="middle" width="75" style="border:solid thin; border-right:none;">
           		<span style="color:#F00;">FECHA</span><br>
                <?php echo $r['Fecha'];?>
           	</td>
            <td align="center" valign="middle" width="80" style="border:solid thin;">
           		<span style="color:#F00;">HORA</span><br>
                <?php echo $r['Hora'];?>                
           	</td>
        </tr>
    </table>
    <table width="100%" cellspacing="0px" cellpadding="0px">
        <tr>
           	<td align="center" valign="middle" style="font-size:10px; border:solid thin; border-right:none; border-top:none;">
                Remitido: <?php echo $r['Servicio'];?>
           	</td>
            <td align="center" valign="middle" style="font-size:10px; border:solid thin; border-top:none;">
                Reportado: <?php echo $r['Reportado'];?>
           	</td>
        </tr>
    </table>
    <table width="100%" cellspacing="0px" cellpadding="0px">
        <tr>
           	<td align="left" valign="middle" width="450px">
                Referido por: <?php echo utf8_decode($r['Dr']);?>
           	</td>
            <td align="right" valign="middle">
                <span style="font-weight:bold;">VALOR DE REFERENCIA</span>
           	</td>
        </tr>
    </table>
	<table width="100%" cellspacing="0px" cellpadding="0px">
        <tr style="vertical-align:text-top;">
        	<td class="pdf_contenido" align="center">
             <?php 
				$rtf = new rtf(  str_replace($especiales_caracteres,$especiales_caracteres_c,$r['Resultado']));
				$rtf->output("html");
				$rtf->parse();
				$rtf_r='';
				if( count( $rtf->err) == 0) // no errors detected
					$rtf_r=$rtf->out;
				print_r($rtf_r);		
			?>
            </td>
        </tr>
    </table>
    <table width="100%" cellspacing="3px">
    	<tr>
        	<td style=" font-family: Verdana,Geneva,sans-serif; font-size: 11px; height: 75px; padding-top: 60px; width:300px; float:left;">
                Lic. <?php echo $r['Bioanalista'].' '.$r['NoColegio'];?>
            </td>
            <td style="border-bottom: thin solid; height: 65px; width: 120px; padding-top: 20px; float:left;">
            	<?php if(!is_null($r['Imagen']) && strlen($r['Imagen'])>2){?>
                    <img height="60px" src="../images/firma/<?php echo $r['Imagen'];?>">
                <?php }else echo '&nbsp;';?>
            </td>
            <td align="right" style="font-family: Verdana,Geneva,sans-serif; font-size: 11px; height: 75px; padding-top: 60px; width: 200px; float:right;">
            	Reportado: <?php echo date('d/m/Y h:i:s a');?>
            </td>
        </tr>
    </table>
</div>
<?php
}
?>
</body></html>
<?php
	$html = ob_get_contents();
	ob_end_clean();
	
	$printPDF=true;
	//$printPDF=false;
	
	if(!$printPDF){
		//phpinfo();
		print_r($html); 
	}else{
		require_once("class/dompdf/dompdf_config.inc.php");
		@ini_set("memory_limit", "64M");
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		unset($html);
		//$dompdf->set_paper("letter", $_POST["orientation"]);
		$dompdf->render();
	
		$dompdf->stream("resultados_medex.pdf");
		//$pdf = $dompdf->output();
		
		//file_put_contents("saved_pdf.pdf", $pdf);
		unset($dompdf);
		exit(0);
	}
?>