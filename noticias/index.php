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
                                <h2 class="title">
                                    Noticias &amp; Eventos
                                </h2>
                            </div>
                        </div>
                        <div class="rt-mainbody"> 
                        	<ul id="newsContent" class="list-news"></ul>
                            <div id="newsLoading" align="center">
                            	<img src="../resources/images/loading.gif">
                            </div>
                       	</div>
                    </div>
                </div>                
        	</div>
        </div>
        
        <div class="clear"></div>
        
        <!-- Footer -->
    	<?php templateFooter('../resources/');?>
        <script src="../resources/js/jquery.news.js?<?php echo filemtime(dirname(__FILE__).'/../resources/js/jquery.news.js'); ?>" type="text/javascript"></script>
  	</div>
</body></html>
<script>
	$(function() {
		var pag = 0;
		$.news('#newsContent');
		$.news.getNews(pag,'#newsLoading');
		
		$(window).scroll(function()
		{
			if($(window).scrollTop() == $(document).height() - $(window).height())
			{
				if($('#LastNews').length == 0){
					$('div#newsLoading').show();
					pag=pag+1;
					$.news.getNews(pag,'#newsLoading');
				}
			}
		});
	});
</script>