<?php  
	if(!isset($_COOKIE['datos_usr']['USERID'])){
		echo '<script> document.location=\'http://www.realtytask.com\';</script>';
	}
	include('properties_conexion.php');
	conectar();
	include("templates/properties_template.php");
	
	$query='SELECT x.*,t.name usertype, p.agent profilename, p.urlimage profileimage, p.email profileemail 
			FROM ximausrs x 
			INNER JOIN followagent p ON (x.userid = p.userid and p.profile=1)
      		INNER JOIN followagent_type t ON (t.idtype = p.agenttype)
			WHERE x.userid='.$_COOKIE['datos_usr']['USERID'];
	$result = mysql_query($query) or die($query.mysql_error());
	$userProf = mysql_fetch_array($result,MYSQL_ASSOC);
	
	/*consultation own task created*/
	$query2='select count(*)  as cant
			from follow_task t
			inner join follow_groupname g on t.idgname=g.idgname
			inner join follow_subcategory s on t.idscat=s.idscat
			inner join follow_category c on s.idcat=c.idcat
			inner join follow_task_status st on t.idstat=st.idstat
			where t.userid='.$_COOKIE['datos_usr']['USERID'];
	$result2 = mysql_query($query2) or die($query2.mysql_error());
	$cant_own = mysql_fetch_array($result2);
	
	/*consultation assigned created*/
	$query3='select count(*) as cant
			 from follow_task t
			 inner join follow_groupname g on t.idgname=g.idgname
			 inner join follow_subcategory s on t.idscat=s.idscat
			 inner join follow_category c on s.idcat=c.idcat
			 inner join follow_task_status st on t.idstat=st.idstat
			 inner join follow_task_assigned ta on t.idftask=ta.idftask
			 inner join followagent a on ta.agentid=a.agentid
			 inner join ximausrs x ON (t.userid=x.userid)
			 where a.user_system='.$_COOKIE['datos_usr']['USERID'];
	$result3 = mysql_query($query3) or die($query3.mysql_error());
	$cant_assig = mysql_fetch_array($result3);
	
?>
<html>
<head>
	<script type="text/javascript" >
    var itemsmenutree=<?php include('resources/php/print_item_menu.php') ?> ;
	
	//var tabs='';//TAB MAIN CONTENT
    </script>

	<?php tagHeadHeader();?>
	<script type="text/javascript" src="includes/properties_generator.js?<?php echo filemtime(dirname(__FILE__).'/includes/properties_generator.js'); ?>"></script>
	<script type="text/javascript" src="includes/properties_myaccount.js?<?php echo filemtime(dirname(__FILE__).'/includes/properties_myaccount.js'); ?>"></script>
	<script type="text/javascript" src="includes/properties_draw.js?<?php echo filemtime(dirname(__FILE__).'/includes/properties_draw.js'); ?>"></script>
	<script type="text/javascript" src="includes/properties_overview.js?<?php echo filemtime(dirname(__FILE__).'/includes/properties_overview.js'); ?>"></script>
	<link href="includes/css/draw.css?<?php echo filemtime(dirname(__FILE__).'/includes/css/draw.css'); ?>" rel="stylesheet" type="text/css" /> 
	<link href="includes/css/global.css?<?php echo filemtime(dirname(__FILE__).'/includes/css/global.css'); ?>" rel="stylesheet" type="text/css" /> 
	
</head>
<body>
    <div class="frame">
        <div class="headerrt"> 
            <div style="margin: 1px 0 0 250px; float:left;">
            	<img id="imageprofilemain" height="48" width="48" src="
				<?php echo strlen($userProf['profileimage'])>0 ? 'http://www.realtytask.com/'.$userProf['profileimage'].'?nocache?'.rand(10000000, 100000000) : 'http://www.realtytask.com/contacts_tabs/img/default.jpg'.'?nocache?'.rand(10000000, 100000000);?>">                
            </div>
            <div style="margin: 5px; float:left;">
                <span  id="imageprofilename" style="font-size: 14px; font-weight:bold;">
                <?php echo (strlen($userProf['profilename'])==0)?$userProf['NAME'].' '.$userProf['SURNAME'].' ('.$userProf['USERID'].')':$userProf['profilename'].' ('.$userProf['USERID'].')'; ?>
                </span><br>
                <?php echo $userProf['usertype'];?>
            </div>
		<div style="float:right; margin: 7px 10px 0;">
             <a style="padding: 9px;" title="Facebook" target="_blank" href="http://www.facebook.com/RealtyTask" class="overviewBotonCss3 icon-facebook" id="buttonRefreshDashboard"></a>
                <a style="padding: 9px;" title="Twitter" target="_blank" href="http://twitter.com/realtytask" class="overviewBotonCss3 icon-twitter" id="buttonRefreshDashboard"></a>
                <a style="padding: 9px;" title="Live Chat" target="_blank" href="http://messenger.providesupport.com/messenger/ximausa.html" class="overviewBotonCss3 icon-live-chat" id="buttonRefreshDashboard"></a>
                <a style="padding: 9px;" title="Tickets" href="http://www.realtytask.com/settings/tickets.php" class="overviewBotonCss3 icon-ticket" id="buttonRefreshDashboard"></a>
                <a style="padding: 9px;" title="Log Out" href="http://www.realtytask.com/resources/php/properties_releaseSess.php" class="overviewBotonCss3 icon-logout" id="buttonRefreshDashboard"></a>
            </div>            
        </div>
        <div id="contentmainrt"></div>
    </div>

<?php googleanalytics(); ?>
<style>
	.x-layout-collapsed {
		width: 14px !important;
	}
	.x-tool-expand-east {
		margin: 3px 0px;
	}
	.x-tool-expand-west {
		margin: 3px -1px;
	}
</style>

<script>
var user_loged=true;
<?php 	
	
	echo "var user_name_menu='".$_COOKIE['datos_usr']['NAME'].' '.$_COOKIE['datos_usr']['SURNAME']."';";
	echo "var useridlogin='".$_COOKIE['datos_usr']['USERID']."';";
	
	//$sql='SELECT * FROM realtytask.usr_cobros as c right join usr_productobase as p on c.idproductobase=p.idproductobase where c.userid='.$_COOKIE['datos_usr']['USERID'].' or c.userid is null';  
	$sql='SELECT * FROM usr_productobase';
	$res=mysql_query($sql) or die($sql.mysql_error());
	while($data=mysql_fetch_assoc($res)){
		echo "var addon".$data['idproducto']."="; echo $_COOKIE['addon'][$data['idproducto']]==1?'true':'false'; echo ";";
	}
	echo "systemwhat=1;";
?>

Ext.QuickTips.init();
var tabs=tabs2=tabs3=viewport=null;
var user_block=false;
var system_width		= document.body.offsetWidth;
var system_height		= document.body.clientHeight - 60;
var tablevel_height 	= 35;
var grid_height		= 30;

if(system_width < 1260) system_width = 1280;
system_width = system_width - 290;

var system_width_panel =system_width -20;

//console.log(system_width,system_height);

Ext.onReady(function(){

    var tree = new Ext.tree.TreePanel({
        useArrows: true,
        autoScroll: true,
        animate: true,
        enableDD: true,
        containerScroll: true,
        border: false,
		lines : true,
		rootVisible: false,
		loader: new Ext.tree.TreeLoader(),
		root: new Ext.tree.AsyncTreeNode({
            nodeType: 'async',
            text: 'Realty Task',
            draggable: false,
            id: 'treemain',
			iconCls:"i-treemain",
            expanded: true,
            children: itemsmenutree
		})
    });
	
	//creacion de panel contactos tipo chat
	var east = {
		xtype:"panel",
		region:"east",
		width:250,
		split:true,
		floating: true,
		collapsible:true,
		id:'eastmenu',
		header: true,
		minSize: 250,
		maxSize: 250,
		margins: "0 0 3 3",
		cmargins:'0 0 0 0',
		autoScroll:true,
		animCollapse:true,
		animate: true,
		collapsed: true,
		title	:	"Contacts",
		autoLoad: {
			url: "mysetting_tabs/myfollowup_tabs/contact.chat.php", 
			scripts: true,
			timeout	: 10800
		}
	};
	
	if(system_width > 1250){
		system_width = system_width - 300;
		system_width_panel =system_width -20;
		east = {
			xtype:"panel",
			region:"east",
			width:280,
			height: 'auto',
			floating: true,
			id:'eastmenu',
			header: true,
			minSize: 280,
			maxSize: 280,
			margins: "0 0 3 3",
			cmargins:'0 0 0 0',
			animate: true,
			title	:	"Contacts",
			autoLoad: {
				url: "mysetting_tabs/myfollowup_tabs/contact.chat.php", 
				params: {height: true},
				scripts: true,
				timeout	: 10800
			}
		};
	}
	
	//cracion de el primer tab
	var home= new Ext.Panel({
		iconCls: 'i-treemain',
		id: 'id-treemain',
		title	: "Dashboard",
		autoLoad: {
			url: "mysetting_tabs/myfollowup_tabs/dashboard.php",
			params: {width: system_width}, 
			scripts: true,
			timeout	: 10800
		}		
	});
	
	//ponemos el tab en una barra para ponerlo en algun lado
	tabs= new Ext.TabPanel({
		id: 'tabs',
		border:false,
		plugins: new Ext.ux.TabCloseMenu(),
		activeTab:0,
		enableTabScroll	:  true, //hacemos que sean recorridas
		defaults:{ autoScroll:true },
		height	:	system_height,
		items:[home],
		listeners: {
			'tabchange': function(tabpanel,tab){
				if(tab){
					if(tab.id!='id-tfollisting'){
						if(document.getElementById('comparable_mymapL_control_mapa_div'))
							document.getElementById('comparable_mymapL_control_mapa_div').style.display='none';
						if(document.getElementById('comparableact_mymapL_control_mapa_div'))
							document.getElementById('comparableact_mymapL_control_mapa_div').style.display='none';
					}else{
						if(document.getElementById('tabs-compL')){
							var tbListing=Ext.getCmp('tabsFollowSellingId');
							if(tbListing.getActiveTab().id=='comparables-ptL'){
								var compsT=Ext.getCmp('tabs-compL');
								if(compsT.getActiveTab().id=='comparables-compL'){
									document.getElementById('comparable_mymapL_control_mapa_div').style.display='';
									if(document.getElementById('comparableact_mymapL_control_mapa_div'))
										document.getElementById('comparableact_mymapL_control_mapa_div').style.display='none';
								}else if(compsT.getActiveTab().id=='actives-compL'){
									document.getElementById('comparableact_mymapL_control_mapa_div').style.display='';
									document.getElementById('comparable_mymapL_control_mapa_div').style.display='none';
								}
							}
						}
					}
					
					if(tab.id!='id-tfoloffering'){
						if(document.getElementById('comparable_mymapB_control_mapa_div'))
							document.getElementById('comparable_mymapB_control_mapa_div').style.display='none';
						if(document.getElementById('comparableact_mymapB_control_mapa_div'))
							document.getElementById('comparableact_mymapB_control_mapa_div').style.display='none';
					}else{
						if(document.getElementById('tabs-compB')){
							var tbOffering=Ext.getCmp('tabsFollowId');
							if(tbOffering.getActiveTab().id=='comparables-ptB'){
								var compsT=Ext.getCmp('tabs-compB');
								if(compsT.getActiveTab().id=='comparables-compB'){
									document.getElementById('comparable_mymapB_control_mapa_div').style.display='';
									if(document.getElementById('comparableact_mymapB_control_mapa_div'))
										document.getElementById('comparableact_mymapB_control_mapa_div').style.display='none';
								}else if(compsT.getActiveTab().id=='actives-compB'){
									document.getElementById('comparableact_mymapB_control_mapa_div').style.display='';
									document.getElementById('comparable_mymapB_control_mapa_div').style.display='none';
								}
							}
						}
					}
					
					if(tab.id!='id-tprolist'){
						if(document.getElementById('comparable_mymapP_control_mapa_div'))
							document.getElementById('comparable_mymapP_control_mapa_div').style.display='none';
						if(document.getElementById('comparableact_mymapP_control_mapa_div'))
							document.getElementById('comparableact_mymapP_control_mapa_div').style.display='none';
					}else{
						if(document.getElementById('tabs-compP')){
							var tbPt=Ext.getCmp('tabs-pt');
							if(tbPt.getActiveTab().id=='comparables-ptP'){
								var compsT=Ext.getCmp('tabs-compP');
								if(compsT.getActiveTab().id=='comparables-compP'){
									document.getElementById('comparable_mymapP_control_mapa_div').style.display='';
									if(document.getElementById('comparableact_mymapP_control_mapa_div'))
										document.getElementById('comparableact_mymapP_control_mapa_div').style.display='none';
								}else if(compsT.getActiveTab().id=='actives-compP'){
									document.getElementById('comparableact_mymapP_control_mapa_div').style.display='';
									document.getElementById('comparable_mymapP_control_mapa_div').style.display='none';
								}
							}
						}
					}
				}
			}
		}
	});
		
	tree.on('click',function(node){ 
		if(node.id=='treemain') 
		{
			var tab = tabs.findById('id-treemain'); 
			tabs.activate(tab); 
		}
		else addTabToMainTab(node); 
	},this); 
	
	function addTabToMainTab(node){  
		if(node.attributes.openlink){
			var tab = tabs.findById("id-"+node.id); 
			if(!tab){ 
				tab = new Ext.Panel({  
					id: "id-"+node.id,
					iconCls: node.attributes.iconCls,
					closable: true, 
					title: node.attributes.text,    //node.attributes.t2+': '+
					autoLoad: {
						url: node.attributes.loadlink, 
						scripts: true,
						timeout	: 10800
					}
					//html: 'This is the content for the tab number '+node.id      
				});
				tabs.add(tab);
				tabs.doLayout();
			}
			tabs.activate(tab); 
		}
	}
		
	var center = {
		xtype	:	"panel",
		region	:	"center",
		layout  :   "fit",
		border	:	false,
		margins	:	{bottom:2,right:2},
		items	:	[{
			xtype	:	"panel",
			//region	:	"center",
			items:[tabs]
		}]
	};

	var west = {
		xtype:"panel",
		region:"west",
		width:240,
		split:true,
		collapsible:true,
		//collapseMode : 'mini',
		id:'westmenu',
		header: true,
		minSize: 240,
		maxSize: 240,
		margins: "0 0 3 3",
		cmargins:'0 0 0 0',
		autoScroll:true,
		animCollapse:true,
		animate: true,
		//title	:	"West region",
		items	:   [tree]
	};

	var main = new Ext.Panel({
		renderTo	: 	"contentmainrt",
		layout		:	"border",
		height		:	system_height,
		items		:	[center,west,east]
	});

});//end onReady
</script>
<style>
.x-tree-elbow-line, .x-tree-elbow, .x-tree-elbow-end {
	width: 12px;
}
</style>	
</body>
</html>

