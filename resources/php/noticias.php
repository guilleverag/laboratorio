<?php
	include('conexion.php');
	
	$type = $_POST['type'];
	
	$nombreMes = array('ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC');
	
	switch($type){
		case 'getLastNews':
			$query = 'SELECT *, day(fecha) as dia, MONTH(fecha) as mes FROM noticias ORDER BY fecha DESC LIMIT 2';
		break;
		
		case 'getNews':
			$pag = isset($_POST['pagina']) ? $_POST['pagina'] : 0;
			$limit = 10;
			
			$inicio = ($pag * $limit);
			$query = 'SELECT *, day(fecha) as dia, MONTH(fecha) as mes FROM noticias ORDER BY fecha DESC LIMIT '.$inicio.', '.$limit;
		break;
		
		case 'getNewInfo':
			$idnoticia = $_POST['idnoticia'];
			$query = 'SELECT *, day(fecha) as dia, MONTH(fecha) as mes FROM noticias WHERE idnoticias='.$idnoticia;
		break;
	}
	
	conectar();
	$result = mysql_query($query);
	$news='';
	if(mysql_num_rows($result)>0){
		while($r=mysql_fetch_assoc($result)){
			$news.=
			"<li>
				<time datetime=\"".$r['fecha']."\"><strong>".$r['dia']."</strong>".$nombreMes[($r['mes']-1)]."</time>
				<div>";
			
			if(strlen($r['urlImg'])>0)
				$news.="<img src=\"".$r['urlImg']."\">";
				
			$news.="<a href=\"http://lab.ve2fsoft.com/noticias/view.php?id=".$r['idnoticias']."\" class=\"lead\">".$r['titulo']."</a><br>
					".$r['descripcion']."
				</div>
			</li>";
		}
	}else{
		$news.='<p id="LastNews">No hay noticias por los momentos.</p>';	
	}
	echo $news;
?>