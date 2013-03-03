<?php
include('conexion.php');
conectar();

$Nombre = $_GET['nombre'];
$CI = $_GET['cedula'];
$IdExamen = $_GET['IdExamen'];
$TotalCosto = $_GET['TotalCosto'];

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

<div style="margin:0 auto; width:800px; height:1000px; font-family:helvetica;">
    <table width="100%" cellspacing="0px" cellpadding="0px"><tr height="10px"><td rowspan="5" align="center" width="140px"><img src="../images/logo/logo.png" height="90"></td><td class="pdf_titulo blue">LABORATORIO CLINICO MEDEX, C.A.</td></tr><tr height="10px"><td class="pdf_titulo">Avenida Las Delicias con Calle Comercio, </td></tr><tr><td class="pdf_titulo">Maracay. Edo. Aragua. Venezuela. </td></tr><tr><td class="pdf_titulo">Telefono: +1 800 123 4567 FAX: +1 504 889 9898 </td></tr><tr><td class="pdf_titulo">E-mail: mail@medex.com</td></tr></table>
    
    <table width="100%" cellspacing="0px" cellpadding="0px" style="font-size:12px;">
        <tr>
            <td align="center" valign="middle" style="border:solid thin; border-right:none;">
           		<span style="color:#F00;">PACIENTE</span><br>
                <?php echo $Nombre;?>
           	</td>
            <td align="center" valign="middle" width="120" style="border:solid thin; border-right:none;">
           		<span style="color:#F00;">C.I.</span><br>
                <?php echo $CI;?>
           	</td>
            <td align="center" valign="middle" width="75" style="border:solid thin; border-right:none;">
           		<span style="color:#F00;">FECHA</span><br>
                <?php echo date('d/m/Y');?>
           	</td>
            <td align="center" valign="middle" width="80" style="border:solid thin;">
           		<span style="color:#F00;">HORA</span><br>
                <?php echo date('h:i:s a');?>                
           	</td>
        </tr>
    </table>
    <br /><br />
    <table width="100%" cellpadding="0" cellspacing="0" style="border-bottom: 2px dashed #000;">
    	<tr>
        	<td align="center"  style="font-size:18px; font-weight:bold;">
            	PRESUPUESTO - Costo de examenes solicitados
            </td>
        </tr>
    </table>
	<table width="95%" class="table table-striped table-hover pdf_contenido" style="font-size:15px;">
        <thead>
            <tr>
            	<th width="150">Grupo</th>
                <th>Examen</th>
                <th width="100">BsF</th>
            </tr>
        </thead>
        <tbody>
            <?php
				$query="SELECT g.Descripcion as Grupo, e.IdExamen,
				e.Descripcion as Examen, e.Costo 
				FROM grupo g 
				INNER JOIN examen e ON (g.CdGrupo = e.CdGrupo)
				WHERE e.IdExamen IN ($IdExamen)
				ORDER BY g.CdGrupo, e.Descripcion ASC";
				$result=mysql_query($query) or die($query.mysql_error());
				
				while($r=mysql_fetch_array($result)){?>
					<tr>
                        <td><?php echo htmlspecialchars(utf8_encode($r['Grupo']));?></td>
                        <td><?php echo htmlspecialchars(utf8_encode($r['Examen']));?></td>
                        <td style="text-align: right;"><?php echo number_format($r['Costo'],0,',','.');?> BsF</td>
                    </tr>
			<?php }
			?>
            <tr class="totalPrice" style="font-size:18px; font-weight:bold;">
                <td>&nbsp;</td>
                <td style="text-align: right;">Total:</td>
                <td style="text-align: right;"><span><?php echo $TotalCosto;?> </span>Bsf</td>
            </tr>
        </tbody>
    </table>
    <table width="100%" cellspacing="3px">
    	<tr>
        	<td style=" font-family: Verdana,Geneva,sans-serif; font-size: 11px; height: 75px; padding-top: 60px; width:300px; float:left;">
                Presupuesto Web - Portal del Laboratorio Medex C.A.
            </td>
            <td align="right" style="font-family: Verdana,Geneva,sans-serif; font-size: 11px; height: 75px; padding-top: 60px; width: 200px; float:right;">
            	Reportado: <?php echo date('d/m/Y h:i:s a');?>
            </td>
        </tr>
    </table>
</div>
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
	
		$dompdf->stream("presupuesto_medex.pdf");
		//$pdf = $dompdf->output();
		
		//file_put_contents("saved_pdf.pdf", $pdf);
		unset($dompdf);
		exit(0);
	}
?>