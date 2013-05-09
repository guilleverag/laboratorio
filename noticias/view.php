<?php include_once('../resources/template/template.php');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Laboratorio Clínico Medex</title>

    <?php templateHeaderInclude('../resources/');?>
</head>

<body>
	<div class="wrapper">
		<!-- Header menu -->
        <?php templateHeader(false, false, false, true);?>
		        
        <!-- Main -->
        <div id="rt-main" class="container">
        	<div class="row-fluid">
            	<div class="span12">
                	<div class="rt-block">
                    	<div class="itemHeader">
                            <div class="module-title">
                                <div class="span9">
                                    <h2 class="title">
                                        Noticias &amp; Eventos
                                    </h2>
                                </div>
                                <div class="span3 refback">
                                	<a href="index.php" class="moduleItemReadMore">
                                        Volver
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="rt-mainbody span12"> 
                        	<ul id="newsContent" class="list-news view-news">
                            	<div id="newsLoading" align="center">
                                    <img src="../resources/images/loading.gif">
                                </div>
                            </ul>
                            <div class="clr"></div>
                       	</div>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
        	</div>
        </div>
        <div class="clr"></div>
        <div class="clear"></div>
        <br clear="all">
        <!-- Footer -->
    	<?php templateFooter('../resources/');?>
        <script src="../resources/js/jquery.news.js?<?php echo filemtime(dirname(__FILE__).'/../resources/js/jquery.news.js'); ?>" type="text/javascript"></script>
  	</div>
</body></html>
<script>
	$(function() {
		$.news('#newsContent');
		$.news.getNewsInfo(<?php echo $_GET['id'];?>);
	});
</script>