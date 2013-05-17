<?php 
include('../properties_conexion.php');
include('../properties_getgridcamptit.php');
conectar();
$_SERVERXIMA="http://www.reifax.com/";
$realtor=$_POST['userweb']=="true" ? true:false;	
$realtorid=$_POST['realtorid'];

$query='SELECT search_filter_county
		FROM xima.xima_system_var
		WHERE userid='.$_COOKIE['datos_usr']['USERID'];
$result=mysql_query($query) or die($query.mysql_error());
$r=mysql_fetch_array($result);
$county=$r['search_filter_county'];
$db_data=conectarPorIdCounty($r['search_filter_county']);

function url_exists($url)
{
	$url_info = parse_url($url);
	
	if (! isset($url_info['host']))
		return false;
	
	$port = (isset($url_info['post'])?$url_info['port']:80);
	
	if (! $hwnd = @fsockopen($url_info['host'], $port, $errno, $errstr)) 
		return false;
	
	$uri = @$url_info['path'] . '?' . @$url_info['query'];
	
	$http = "HEAD $uri HTTP/1.1\r\n";
	$http .= "Host: {$url_info['host']}\r\n";
	$http .= "Connection: close\r\n\r\n";
	
	@fwrite($hwnd, $http);
	
	$response = fgets($hwnd);
	$response_match = "/^HTTP\/1\.1 ([0-9]+) (.*)$/";
	
	fclose($hwnd);
	
	if (preg_match($response_match, $response, $matches)) {
		//print_r($matches);
		if ($matches[1] == 404)
			return false;
		else if ($matches[1] == 200)
			return true;
		else
			return false;
		 
	} else {
		return false;
	}
}

$loged=false;
$block=false;
$realtorweb=false;
$permission=array();

if(isset($_COOKIE['datos_usr']['USERID'])){
	//Variable Inicial
	$loged=true;
	$query='update xima.xima_system_var 
	SET block_county="N",block_commercial="N",block_realtorweb="N",block_platinum_invest="Y" 
	WHERE userid='.$_COOKIE['datos_usr']['USERID'];
	mysql_query($query) or die($query.mysql_error());
	
	$query='select * from xima.permission WHERE userid='.$_COOKIE['datos_usr']['USERID'];
	$result=mysql_query($query) or die($query.mysql_error());
	$permission=mysql_fetch_array($result);
	
	//Block by Webs
	if($_COOKIE['datos_usr']['idstatus']==8 || $_COOKIE['datos_usr']['idstatus']==9 || $realtor){
		$realtorweb=true;
		$block=true;
		if($r[0]==0){ $loged=false; } 
	}
	
	$cookie_block_realtorweb = $realtorweb===true ? 'Y':'N';
	$query='update xima.xima_system_var 
	set block_realtorweb="'.$cookie_block_realtorweb.'" 
	WHERE userid='.$_COOKIE['datos_usr']['USERID'];
	mysql_query($query) or die($query.mysql_error());
	
	if ($realtor){ $loged=false; }
	
	//Variable for ordering
	$query='select sv.orderby 
	from xima.xima_system_var sv 
	WHERE sv.userid='.$_COOKIE['datos_usr']['USERID'];
	$result=mysql_query($query) or die($query.mysql_error());
	$r=mysql_fetch_array($result);
	
	$orderby=$r['orderby'];
	
	//User County Block
	$cookie_block_county='N';
	if($_COOKIE['datos_usr']['idusertype']!=1 && $_COOKIE['datos_usr']['idusertype']!=4 && $_COOKIE['datos_usr']['idusertype']!=7){
		$query='SELECT * FROM xima.usercounty WHERE idcounty='.$county.' AND userid='.$_COOKIE['datos_usr']['USERID'].' AND idproducto in (1,2,3)';
		$result = mysql_query($query) or die($query.mysql_error());
		if(mysql_num_rows($result)==0){
			$query='SELECT * FROM xima.usercounty WHERE idcounty='.$county.' AND userid='.$_COOKIE['datos_usr']['USERID'].' AND idproducto in (6,7,8)';
			$result = mysql_query($query) or die($query.mysql_error());
			if(mysql_num_rows($result)==0){
				$block=true;
				$cookie_block_county = $block===true ? 'Y':'N';				
				$query='update xima.xima_system_var set 
				block_county="'.$cookie_block_county.'" 
				WHERE userid='.$_COOKIE['datos_usr']['USERID'];
				mysql_query($query) or die($query.mysql_error());
			}
		}
	}
}

//User Professional Block 
if($loged && ($permission['professional']==1 || $permission['professional_esp']==1)){
	$query='update xima.xima_system_var 
	set block_platinum_invest="N" 
	WHERE userid='.$_COOKIE['datos_usr']['USERID'];
	mysql_query($query) or die($query.mysql_error());
}

if($block && $mostrarSoloPropertyFound)
	$mostrarSoloPropertyFound=true;
else{
	if($loged && $num_rows_all>0)
		$mostrarSoloPropertyFound=false;
}		
?>
<div align="center"  class="fondo_realtor_result">

<?php 
	//echo 'loged: '.$loged.' - block: '.$block.' - Realtorweb: '.$realtorweb.' - Commercial: '.$commercial;
	if($block){ 
		if($cookie_block_county=='Y'){
			echo '<div style="font-size:12px; margin-top: 5px; color:#F00;">The information is limited as the county is not active in your account.<br>To add it go to your settings option.</div>';
		}elseif(!$realtorweb)
			echo '<div style="font-size:12px; margin-top: 5px; color:#F00;">The information is limited as the county is not active in your account.<br>To add it go to your settings option.</div>';
	}

	if(isset($_POST['groupbylevel'])){
		echo '<div style="font-size:14px; font-weight:bold; margin-top: 5px; color:#8AB420;">Result of \''.$_POST['groupselect'].'\'.</div>';
	}

$ArSqlCT=array('idtc','campos','tabla','titulos','type','size','Desc','numformatted','decimals','align','px_size');//Search
$ArDfsCT=array('idtc','name','tabla','title','type','size','desc','numformatted','decimal','align','px_size');//Search
$ArIDCT = getArray('FS','result',true);
$fields = getCamptit($ArSqlCT, $ArDfsCT, $ArIDCT);
$fields = str_replace(  "'",'"', $fields);
$fields = json_decode($fields);
$ids=array("mapResultAdv","tabsAdv","gridRAdv","selected_dataR","AllCheckR","limitR","arrLatLong","storeR","smR","gridR","pagingR","toolbarMapResultAdv","ResultTemplate");
if(isset($_POST['groupbylevel'])) $ids=array("mapResultAdvFG","tabsAdvFG","gridRAdvFG","selected_dataRFG","AllCheckRFG","limitRFG","arrLatLongFG","storeRFG","smRFG","gridRFG","pagingRFG","toolbarMapResultAdvFG","ResultTemplateFG");
?>
    <div style="width:100%;">
    	<div id="<?php echo $ids[0];?>" style="display:none;width:100%;height:320;border: medium solid #b8dae3;position:relative;margin-bottom:5px;"></div>
        <input type="hidden" name="result_mapa_search_latlongAdv" id="result_mapa_search_latlongAdv" value="-1" />
        <div id="<?php echo $ids[1];?>" style="clear:both; margin-top:5px;" ></div>
    </div>
</div>
<script>
	num_rows_all=<?php echo $num_rows_all>25000 ? 'false':'true';?>;
	<?php if($permission['professional']==1 || $permission['professional_esp']==1){?>
	Ext.getCmp('mailing_campaings_result_advance').show();
	<?php }?> 
	
	function gridgetcasita(value, metaData, record, rowIndex){
		var aux=value.split('_');
		return "<div style='position:relative;text-align:center;font:bold 14px;cursor:pointer;float:left;'><img style='position:absolute;top:-1px;left:-2px;z-index:100' src='http://www.reifax.com/img/houses/"+lsImgCss[aux[1]].img+"'/><div style='position:relative;top:2px;left:3px;z-index:200;text-decoration:none!important'>"+aux[0]+"</div></div>" 
	}
	
	function gridgetsold(value, metaData, record, rowIndex){
		var sold = record.get('status').split('_')[1].split('-')[2];
		if(sold=='S') return value+' SOLD';
		return  value;
	}
	
	function showdiffvaluewin(lsqft,larea,beds,bath,zip){
		var html='';
		if(lsqft.length>0 && lsqft>0) html+='<tr><td>GArea:</td><td><font color=#1D5AFE>' + lsqft+ '</font></td></tr>';
		if(larea.length>0 && larea>0) html+='<tr><td>LArea:</td><td><font color=#1D5AFE>' + larea+ '</font></td></tr>';
		if(beds.length>0 && beds>0) html+='<tr><td>Be:</td><td><font color=#1D5AFE>' + beds+ '</font></td></tr>';
		if(bath.length>0 && bath>0) html+='<tr><td>Ba:</td><td><font color=#1D5AFE>' + bath+ '</font></td></tr>';
		if(zip.length>0 && zip>0) html+='<tr><td>Zip:</td><td><font color=#1D5AFE>' + zip+ '</font></td></tr>';

		return '<table>'+html+'</table>'; 
	}
	
	function griddifflarea(value, metaData, record, rowIndex){
		if(record.get('diff_larea').length>0 && record.get('diff_larea')>0)
			return '<a href="javascript:void();" ext:qtitle="Public Record Value" ext:qtip="'+showdiffvaluewin(record.get('diff_lsqft'),record.get('diff_larea'),record.get('diff_beds'),record.get('diff_bath'),record.get('diff_zip'))+'">'+value+'</a>';
		else
			return value;
	}
	
	function griddifflsqft(value, metaData, record, rowIndex){
		if(record.get('diff_lsqft').length>0 && record.get('diff_lsqft')>0)
			return '<a href="javascript:void();" ext:qtitle="Public Record Value" ext:qtip="'+showdiffvaluewin(record.get('diff_lsqft'),record.get('diff_larea'),record.get('diff_beds'),record.get('diff_bath'),record.get('diff_zip'))+'">'+value+'</a>';
		else
			return value;
	}
	
	function griddiffbeds(value, metaData, record, rowIndex){
		if(record.get('diff_beds').length>0 && record.get('diff_beds')>0)
			return '<a href="javascript:void();" ext:qtitle="Public Record Value" ext:qtip="'+showdiffvaluewin(record.get('diff_lsqft'),record.get('diff_larea'),record.get('diff_beds'),record.get('diff_bath'),record.get('diff_zip'))+'">'+value+'</a>';
		else
			return value;
	}
	
	function griddiffbath(value, metaData, record, rowIndex){
		if(record.get('diff_bath').length>0 && record.get('diff_bath')>0)
			return '<a href="javascript:void();" ext:qtitle="Public Record Value" ext:qtip="'+showdiffvaluewin(record.get('diff_lsqft'),record.get('diff_larea'),record.get('diff_beds'),record.get('diff_bath'),record.get('diff_zip'))+'">'+value+'</a>';
		else
			return value;
	}
	
	function griddiffzip(value, metaData, record, rowIndex){
		if(record.get('diff_zip').length>0 && record.get('diff_zip')>0)
			return '<a href="javascript:void();" ext:qtitle="Public Record Value" ext:qtip="'+showdiffvaluewin(record.get('diff_lsqft'),record.get('diff_larea'),record.get('diff_beds'),record.get('diff_bath'),record.get('diff_zip'))+'">'+value+'</a>';
		else
			return value;
	}
	
	function gridgetfollowup(value, metaData, record, rowIndex){
		var aux="";
		var title="";
		if(value!='0'){
			if(value=='S'){
				aux='check-blue.gif';
				title="Property added to selling follow up";
			}else if(value=='F' || value=='FM' || value=='B' || value=='BM'){
				aux='drop-yes.gif';
				title="Property added to buying follow up";
			}else if(value=='LF' || value=='LFM' || value=='LB' || value=='LBM' || value=='LS'){
				aux='check-red.png';
				title="Property block in follow up";
			}else{
				return "";
			}
			return "<div><img src='http://www.reifax.com/img/"+aux+"' title='"+title+"'/></div>";
		}else{
			return "";
		}
		
	}
	
	<?php echo $ids[3];?> = new Array();
	<?php echo $ids[4];?>=false;
	var <?php echo $ids[5];?>=50;
	<?php echo $ids[6];?>= new Array();
	
	var <?php echo $ids[7];?> = new Ext.data.Store({
		url: 'coresearch.php?resultType=advance&systemsearch=<?php echo $_POST['systemsearch']; if(isset($_POST['groupbylevel'])){ echo '&groupbylevel='.$_POST['groupbylevel'];} ?>',
		reader: new Ext.data.JsonReader(),
		baseParams: {'ResultTemplate': <?php echo $ids[12];?> <?php if(isset($_POST['groupbylevel'])) echo ', \'groupselect\': \''.$_POST['groupselect'].'\'';?>},
		remoteSort: true,
		listeners: {
			'beforeload': function(store,obj){
				obj.params.ResultTemplate=<?php echo $ids[12];?>;
			},
			'load': function(store,data,obj){
				loading_win.show();
				<?php echo $ids[0];?>.borrarTodoMap();
			
				for(k in data){
					if(Ext.isNumber(parseInt(k))){
						var id = data[k].get('status').split('_');
						var ind = id[0];
						var status = id[1].split('-')[0];
						var pendes = id[1].split('-')[1];
						var sold = id[1].split('-')[2];
						getCasita(status,pendes,sold); 
						
						<?php echo $ids[0];?>.addPushpinInfobox(
							ind, 
							data[k].get('pin_xlat'),
							data[k].get('pin_xlong'),
							'<?php echo $_SERVERXIMA.'img/houses/';?>'+lsImgCss[indImgCss].img,
							data[k].get('pin_address'),
							data[k].get('pin_lsqft'),
							data[k].get('pin_larea'),
							data[k].get('pin_bed')+' / '+data[k].get('pin_bath'),
							data[k].get('pin_saleprice'),
							lsImgCss[indImgCss].explain,
							'createOverview(\''+data[k].get('county')+'\',\''+data[k].get('pid')+'\',\''+status+'\','+user_web+',false);',
							'Click here for Overview'
						);
						
						<?php echo $ids[6];?>.push(new Microsoft.Maps.Location(data[k].get('pin_xlat'),data[k].get('pin_xlong')));
					}
				}
				
				if(data.length>0)
					<?php echo $ids[0];?>.map.setView({
						bounds: Microsoft.Maps.LocationRect.fromLocations(<?php echo $ids[6];?>)
					});
				
				if (<?php echo $ids[4];?>){
					Ext.get(<?php echo $ids[9];?>.getView().getHeaderCell(0)).first().addClass('x-grid3-hd-checker-on');
					<?php echo $ids[4];?>=true;
					<?php echo $ids[9];?>.getSelectionModel().selectAll();
					<?php echo $ids[3];?>=new Array();
				}else{
					<?php echo $ids[4];?>=false;
					var sel = [];
					if(<?php echo $ids[3];?>.length > 0){
						for(val in <?php echo $ids[3];?>){
							var ind = <?php echo $ids[9];?>.getStore().find('pid',<?php echo $ids[3];?>[val]);
							if(ind!=-1){
								sel.push(ind);
							}
						}
						if (sel.length > 0)
							<?php echo $ids[9];?>.getSelectionModel().selectRows(sel);
					}
				}
				/*var alto = parseInt(data.length*22)+70;
				<?php echo $ids[9];?>.setHeight(alto);*/
				loading_win.hide();
			}
		}
	});
	
	var <?php echo $ids[8];?> = new Ext.grid.CheckboxSelectionModel({
		checkOnly: true, 
		width:25,
		listeners: {
			"rowselect": function(selectionModel,index,record){
				if(<?php echo $ids[3];?>.indexOf(record.get('pid'))==-1)
					<?php echo $ids[3];?>.push(record.get('pid'));
				
				if(Ext.fly(<?php echo $ids[9];?>.getView().getHeaderCell(0)).first().hasClass('x-grid3-hd-checker-on'))
					<?php echo $ids[4];?>=true;
			},
			"rowdeselect": function(selectionModel,index,record){
				<?php echo $ids[3];?> = <?php echo $ids[3];?>.remove(record.get('pid'));
				<?php echo $ids[4];?>=false;				
			}
		}
	});
	
	var <?php echo $ids[9];?> = new Ext.grid.EditorGridPanel({//Ext.grid.GridPanel({
		id: '<?php echo $ids[2];?>',
		renderTo: '<?php echo $ids[1];?>',
		width: 'auto',
		height: system_height-200,
		store: <?php echo $ids[7];?>,
		border: false,
		clicksToEdit:1,
		//stripeRows: true,
		columns: [],
		//viewConfig: {forceFit: true},
		enableColLock: false,
		//loadMask: true,
		sm: <?php echo $ids[8];?>,
		listeners: {
			"mouseover": function(e) {
				var row;
				if((row = this.getView().findRowIndex(e.getTarget())) !== false){
					var record = this.store.getAt(row);
					var ind = record.get('status').split('_')[0];
					var pin = <?php echo $ids[0];?>.getPushpin(ind);
					if(pin !== false) pinMouseOver(pin);
				}
			},
			"mouseout": function(e) {
				var row;
				if((row = this.getView().findRowIndex(e.getTarget())) !== false){
					var record = this.store.getAt(row);
					var ind = record.get('status').split('_')[0];
					var pin = <?php echo $ids[0];?>.getPushpin(ind);
					if(pin !== false) infopinMouseOut(pin.getInfobox());
				}
			},
			"rowdblclick": function(grid, row, e) {
				var record = this.store.getAt(row);
				var pid = record.get('pid');
				var status = record.get('status').split('_')[1].split('-')[0];
				createOverview(record.get('county'),pid,status,user_web,false);
			}
		},
		tbar: new Ext.PagingToolbar({
			id: '<?php echo $ids[10];?>',
            pageSize: <?php echo $ids[5];?>,
            store: <?php echo $ids[7];?>,
            displayInfo: true,
			displayMsg: 'Total: {2} Properties',
			emptyMsg: "No properties to display",
			items: ['Show:',
			new Ext.Button({
				tooltip: 'Click to show 50 properties per page.',
				text: 50,
				handler: function(){
					<?php echo $ids[5];?>=50;
					Ext.getCmp('<?php echo $ids[10];?>').pageSize = <?php echo $ids[5];?>;
					Ext.getCmp('<?php echo $ids[10];?>').doLoad(0);
				},
				enableToggle: true,
				pressed: true,
				toggleGroup: 'show_res_group'
			}),'-',new Ext.Button({
				tooltip: 'Click to show 80 properties per page.',
				text: 80,
				handler: function(){
					<?php echo $ids[5];?>=80;
					Ext.getCmp('<?php echo $ids[10];?>').pageSize = <?php echo $ids[5];?>;
					Ext.getCmp('<?php echo $ids[10];?>').doLoad(0);
				},
				enableToggle: true,
				toggleGroup: 'show_res_group'
			}),'-',new Ext.Button({
				tooltip: 'Click to show 100 properties per page.',
				text: 100,
				handler: function(){
					<?php echo $ids[5];?>=100;
					Ext.getCmp('<?php echo $ids[10];?>').pageSize = <?php echo $ids[5];?>;
					Ext.getCmp('<?php echo $ids[10];?>').doLoad(0);
				},
				enableToggle: true,
				toggleGroup: 'show_res_group'
			})
			]
        })	
	});
	
	<?php echo $ids[7];?>.on('metachange', function(){
		if(typeof(<?php echo $ids[7];?>.reader.jsonData.columns) === 'object') {
			var columns = [];
			//columns.push(new Ext.grid.RowNumberer());
			columns.push(<?php echo $ids[8];?>);
			Ext.each(<?php echo $ids[7];?>.reader.jsonData.columns, function(column){
				columns.push(column);
			});

			<?php echo $ids[9];?>.getColumnModel().setConfig(columns);

			
		}
	});
		
	if(document.getElementById('<?php echo $ids[11];?>')){
		var but = Ext.getCmp('<?php echo $ids[11];?>');
		if(but.pressed){
			document.getElementById('<?php echo $ids[0];?>').style.display='';
		}
	}
	
	if(<?php echo $ids[0];?> == null) <?php echo $ids[0];?> = new XimaMap('<?php echo $ids[0];?>','result_mapa_search_latlongAdv','result_control_mapa_divAdv','result_panAdv','result_drawAdv','result_polyAdv','result_clearAdv','result_maxminAdv','result_circleAdv');
	<?php echo $ids[0];?>._IniMAP();
					
		
	<?php echo $ids[7];?>.load();
</script>