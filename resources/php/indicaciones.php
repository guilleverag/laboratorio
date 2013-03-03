<?php
	include('conexion.php');
	conectar();
	
	$type = $_POST['type'];
	switch($type){
		case 'getIndicaciones':
			$query = 'SELECT *
			FROM indicaciones 
			ORDER BY idindicaciones ASC';
			
			$result = mysql_query($query);
			$data='<div class="accordion" id="collapseGrupo">';
					
			while($r=mysql_fetch_assoc($result)){
				$data.='
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseGrupo" href="#collapseGrupo'.$r['idindicaciones'].'" title="'.utf8_encode($r['descripcion']).'">
							<i id="imgGrupo'.$r['idindicaciones'].'" class="icon-chevron-right icon-white pull-right"></i>
							'.utf8_encode($r['titulo']).': <span style="font-size:14px; font-weight: normal;">'.utf8_encode($r['descripcion']).'</span>
						</a>
					</div>
					<div id="collapseGrupo'.$r['idindicaciones'].'" class="accordion-body collapse">
						<div class="accordion-inner fulTabla">
							<div id="resultLoading" align="center">
                            	<img src="../../resources/images/loading.gif">
                            </div>
						</div>
					</div>
				</div>';
			}
			
			$data.='</div>';
		break;
		
		case 'getPasos':	
			$idindicaciones = $_POST['idindicaciones'];
			$query = 'SELECT p.paso, p.descripcion  
			FROM indicaciones i 
			INNER JOIN pasos p ON (i.idindicaciones = p.idindicaciones)
			WHERE i.idindicaciones = '.$idindicaciones.' 
			ORDER BY p.paso ASC';
			
			$result = mysql_query($query) or die($query.mysql_error());
			$data='<table class="table table-striped table-hover">
					<tbody>';
					
			while($r=mysql_fetch_assoc($result)){
				$data.='
				<tr>
					<td>'.$r['paso'].' - '.utf8_encode($r['descripcion']).'</td>
				</tr>';
			}
			
			$data.='</tbody>
			</table>';
		break;
		
	}
	
	echo $data;
?>