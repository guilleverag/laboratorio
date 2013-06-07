<?php
include('conexion.php');
conectar();

if(isset($_POST['idPaciente'])){
	$idPaciente=$_POST['idPaciente'];//13090;
	$comprobante=$_POST['comprobante'];//0;
	$fecha=explode('/',$_POST['fecha']);//'18-9-10';
	$dia = $fecha[0];
	$mes = $fecha[1];
	$ano = $fecha[2];
	$fecha=date('Y-m-d',mktime(0,0,0,$mes,$dia,$ano));
	
	$query="SELECT * FROM web 
	WHERE IdPaciente=$idPaciente 
	AND NoComprobante=$comprobante 
	AND Fecha='$fecha' 
	limit 1";
	
	$variables = 'idPaciente='.$idPaciente.'&comprobante='.$comprobante.'&fecha='.$_POST['fecha'];
}elseif(isset($_POST['CdEmpresa'])){
	$CdEmpresa=$_POST['CdEmpresa'];//13090;
	$contrasena=$_POST['contrasena'];//0;
	$combo = $_POST['combo'];
	$filtro = $_POST['filtro'];
	
	$fechaD=explode('/',$_POST['fechaD']);//'18/9/10';
	$dia = $fechaD[0];
	$mes = $fechaD[1];
	$ano = $fechaD[2];
	$fechaD=date('Y-m-d',mktime(0,0,0,$mes,$dia,$ano));
	$fechaH=explode('/',$_POST['fechaH']);//'18/9/10';
	$dia = $fechaH[0];
	$mes = $fechaH[1];
	$ano = $fechaH[2];
	$fechaH=date('Y-m-d',mktime(0,0,0,$mes,$dia,$ano));
	
	$query="SELECT * FROM empresa e 
	INNER JOIN web w ON (e.CdEmpresa=w.CdEmpresa) 
	WHERE e.CdEmpresa=$CdEmpresa 
	AND e.Contrasena='$contrasena' 
	AND w.fecha>='$fechaD' AND w.fecha<='$fechaH'";
	
	if($combo!='T'){
		switch($combo){
			case 'A':
				$query.=" AND Cuenta='$filtro'";
			break;
			
			case 'H':
				$query.=" AND Historia='$filtro'";
			break;
			
			case 'C':
				$query.=" AND Clave='$filtro'";
			break;
			
			case 'N':
				$query.=" AND Nombre LIKE '%$filtro%'";
			break;
			
			case 'CI':
				$query.=" AND replace(CI,'.','')='$filtro'";
			break;
		}
	}
	
	$query.=" GROUP BY w.IdPaciente ORDER BY w.Fecha DESC,w.Nombre ASC";
	
	$variables = 'CdEmpresa='.$CdEmpresa.'&contrasena='.$contrasena.'&combo='.$combo.'&filtro='.$filtro.'&fechaD='.$_POST['fechaD'].'&fechaH='.$_POST['fechaH'];
}
$result=mysql_query($query) or die($query.mysql_error());

$variables.='&back='.$_POST['back'];

switch($_POST['type']){
	case 'login':
		if(mysql_num_rows($result)>0)
			echo json_encode(array('success'=>true, 'url' => "resultados.php?$variables"));
		else 
			echo json_encode(array('success'=>false));		
	break;
	default:
		$data='<table id="tablesorter" class="table table-striped table-hover">
			<thead>
				<tr>
					'.(isset($_POST['CdEmpresa']) ? '<th>Impreso</th>' : '').'
					<th>Fecha</th>
					<th># Paciente</th>
					<th>Nombre</th>
					<th># Historia</th>
					<th># Admisi&oacute;n</th>
					<th>Clave</th>
				</tr>
			</thead>
			<tbody>';
		
		while($r=mysql_fetch_array($result,MYSQL_ASSOC)){ 
			$data.='
			<tr onclick="javascript:resultadosPDF(this,'.$r['IdPaciente'].',\''.$r['Fecha'].'\','.(isset($_POST['CdEmpresa']) ? 1 : 0).')">
				'.(isset($_POST['CdEmpresa']) ? '<td>'.($r['seen']==1 ? '<i class="icon-ok" style="margin-left:10px;"></i>' : '').'</td>' : '').'
				<td>'.$r['Fecha'].'</td>
				<td>'.$r['IdPaciente'].'</td>
				<td>'.$r['Nombre'].'</td>
				<td>'.$r['Historia'].'</td>
				<td>'.$r['Cuenta'].'</td>
				<td>'.$r['Clave'].'</td>
			</tr>';
		}
		
		$data.='</tbody>
		</table>';
		echo $data;
	break;
}

?>