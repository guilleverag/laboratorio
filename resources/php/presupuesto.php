<?php
	include('conexion.php');
	include('class/php_fast_cache.php');
	phpFastCache::$storage = "auto";
	conectar();
	
	$type = $_POST['type'];
	switch($type){
		case 'getGrupo':
			$data = phpFastCache::get("presupuesto_getGrupo");
			
			if($data == NULL){
				$query = 'SELECT CdGrupo, Descripcion as Grupo
				FROM grupo 
				ORDER BY CdGrupo ASC';
				
				$result = mysql_query($query);
				$data='<div class="accordion" id="collapseGrupo">';
						
				while($r=mysql_fetch_assoc($result)){
					$data.='
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseGrupo" href="#collapseGrupo'.$r['CdGrupo'].'">
								<i id="imgGrupo'.$r['CdGrupo'].'" class="icon-chevron-right icon-white pull-right"></i>
								'.utf8_encode($r['Grupo']).'
							</a>
						</div>
						<div id="collapseGrupo'.$r['CdGrupo'].'" class="accordion-body collapse">
							<div class="accordion-inner">
								<div id="resultLoading" align="center">
									<img src="http://lab.ve2fsoft.com/resources/images/loading.gif">
								</div>
							</div>
						</div>
					</div>';
				}
				
				$data.='</div>';
				phpFastCache::set("presupuesto_getGrupo",$data,180);
			}
		break;
		
		case 'getExam':	
			$CdGrupo = $_POST['CdGrupo'];
			$data = phpFastCache::get("presupuesto_getExam_$CdGrupo");
			
			if($data == NULL){	
				$query = 'SELECT g.Descripcion as Grupo, e.IdExamen,
				e.Descripcion as Examen, e.Costo 
				FROM grupo g 
				INNER JOIN examen e ON (g.CdGrupo = e.CdGrupo)
				WHERE g.CdGrupo = '.$CdGrupo.' 
				ORDER BY g.CdGrupo, e.Descripcion ASC';
				
				$result = mysql_query($query) or die($query.mysql_error());
				$data='<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th colspan="2">Examen</th>
								<th style="width:50px;">BsF</th>
							</tr>
						</thead>
						<tbody>';
						
				while($r=mysql_fetch_assoc($result)){
					$data.='
					<tr>
						<td><input type="checkbox" id="'.$r['IdExamen'].'" value="'.$r['IdExamen'].'^'.htmlspecialchars(utf8_encode($r['Examen'])).'^'.$r['Costo'].'"></td>
						<td>'.htmlspecialchars(utf8_encode($r['Examen'])).'</td>
						<td style="text-align: right;">'.number_format($r['Costo'],0,',','.').' BsF</td>
					</tr>';
				}
				
				$data.='</tbody>
				</table>';
				
				phpFastCache::set("presupuesto_getExam_$CdGrupo",$data,180);
			}
		break;
		
		case 'getOnlyExam':
			$CdGrupo = $_POST['CdGrupo'];
			$data = phpFastCache::get("presupuesto_getOnlyExam_$CdGrupo");
			
			if($data == NULL){	
				$query = 'SELECT g.Descripcion as Grupo, e.IdExamen,
				e.Descripcion as Examen, e.Costo 
				FROM grupo g 
				INNER JOIN examen e ON (g.CdGrupo = e.CdGrupo)
				WHERE g.CdGrupo = '.$CdGrupo.' 
				ORDER BY g.CdGrupo, e.Descripcion ASC';
				
				$result = mysql_query($query) or die($query.mysql_error());
				$data='<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>Examen</th>
							</tr>
						</thead>
						<tbody>';
						
				while($r=mysql_fetch_assoc($result)){
					$data.='
					<tr>
						<td>'.htmlspecialchars(utf8_encode($r['Examen'])).'</td>
					</tr>';
				}
				
				$data.='</tbody>
				</table>';
				
				$data = phpFastCache::set("presupuesto_getOnlyExam_$CdGrupo", $data, 180);
			}
		break;
	}
	
	echo $data;
?>