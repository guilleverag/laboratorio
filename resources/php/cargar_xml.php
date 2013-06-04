<?php

include('conexion.php');
conectar();

//Eliminación de registros viejos.
$query='DELETE FROM  `web` 
WHERE `FechaEnviado` < DATE( DATE_SUB( NOW( ) , INTERVAL 30 DAY ) )';
mysql_query($query);


$dir=getcwd()."/../../FTP";

$caracteres = 	array('"',' ','\\n\\r','\\','\\\\b','\\\\b 0');
$convert = 		array('\'','&nbsp;','<br>','\\\\','\\\\b ','\\\\b0 ');

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if($file!="." && $file!=".." && substr($file,0,7)!='Empresa'){
				$xml = simplexml_load_file($dir.'/'.$file);
				
				$idPaciente=-1;
				foreach($xml->Web as $web){
					
					if($idPaciente!=intval($web->IdPaciente)){
						$query='DELETE FROM web WHERE IdPaciente='.$web->IdPaciente;
						mysql_query($query);
						$idPaciente=intval($web->IdPaciente);
					}
					
					$query='INSERT INTO web VALUES ('.$web->IdPaciente.','.$web->Pagina.',"'.$web->Fecha.'","'.$web->Hora.'","'.$web->Nombre.'","'.$web->CI.'",'.$web->Edad.',"'.$web->MesAno.'","'.$web->Dr.'",'.$web->CdEmpresa.',"'.$web->Atendido.'","'.$web->Cliente.'","'.$web->Imagen.'","'.$web->Bioanalista.'","'.$web->NoColegio.'","'.str_replace($caracteres,$convert,$web->Resultado).'","'.$web->NoComprobante.'","'.$web->Reportado.'",'.$web->Cuenta.','.$web->Historia.',"'.$web->Clave.'","'.substr($file,0,4).'-'.substr($file,4,2).'-'.substr($file,6,2).'","'.$web->Servicio.'")';
					mysql_query($query);
				}
				unlink($dir.'/'.$file);
			}
        }
        closedir($dh);
    }else{
		echo "no abrio el dir";
	}
}else{
	@mkdir($dir);
}
?>