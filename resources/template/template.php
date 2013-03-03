<?php 
function templateHeaderInclude($root='resources/'){ ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo $root;?>css/grid-12.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $root;?>lib/bootstrap/css/bootstrap.min.css" type="text/css">
    
    <link rel="stylesheet" href="<?php echo $root;?>css/reset.css?<?php echo filemtime(dirname(__FILE__).'/../css/reset.css'); ?>" type="text/css">
    
    <link rel="stylesheet" href="<?php echo $root;?>css/nivo-slider.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $root;?>css/default.css?<?php echo filemtime(dirname(__FILE__).'/../css/default.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo $root;?>css/template.min.css?<?php echo filemtime(dirname(__FILE__).'/../css/template.css'); ?>" type="text/css">
<?php }

function templateHeader($inicio=true, $lab=false, $exam=false, $noti=false, $contacto=false){?>
	<div id="rt-top" class="container">
        <div class="row-fluid">
            <!-- Logo -->
            <div class="span4">
                <div class="rt-block">
                    <a href="http://lab.ve2fsoft.com" id="rt-logo"></a>
                </div>
            </div>
            
            <!-- Menu -->
            <div class="span8">
                <div class="navbar">
                    <div class="navbar-inner">
                    	<ul class="nav">
                        	<li <?php echo $inicio ? 'class="active"' : '';?>><a href="http://lab.ve2fsoft.com">Inicio</a></li>
                            <li class="dropdown <?php echo $lab ? 'active' : '';?>" onmouseover="dropdownOpen(this);" onmouseout="dropdownClose(this);">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    Laboratorio
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                	<li><a href="http://lab.ve2fsoft.com/laboratorio">Organizaci&oacute;n</a></li>
                                    <li><a href="http://lab.ve2fsoft.com/laboratorio/objetivos.php">Misi&oacute;n y Visi&oacute;n</a></li>
                                    <li><a href="http://lab.ve2fsoft.com/laboratorio/proyectos.php">Nuevos Proyectos</a></li>
                                    <li><a href="http://lab.ve2fsoft.com/laboratorio/personal.php">Nuestro Personal</a></li>
                                </ul>
                            </li>
                            <li class="dropdown <?php echo $exam ? 'active' : '';?>" onmouseover="dropdownOpen(this);" onmouseout="dropdownClose(this);">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    Ex&aacute;menes
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="http://lab.ve2fsoft.com/examenes/resultado/">Resultados Pacientes</a></li>
                                    <li><a href="http://lab.ve2fsoft.com/examenes/resultado/doctores.php">Resultados Doctores</a></li>
                                    <li><a href="http://lab.ve2fsoft.com/examenes/resultado/clientes.php">Resultados Clientes</a></li>
                                    <li><a href="http://lab.ve2fsoft.com/examenes/presupuesto/">Presupuesto</a></li>
                                    <li><a href="http://lab.ve2fsoft.com/examenes/indicaciones/">Indicaciones</a></li>
                                </ul>
                            </li>
                            <li <?php echo $noti ? 'class="active"' : '';?>><a href="http://lab.ve2fsoft.com/noticias">Noticias</a></li>
                            <li class="dropdown <?php echo $contacto ? 'active' : '';?>" onmouseover="dropdownOpen(this);" onmouseout="dropdownClose(this);">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    Contacto
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="http://lab.ve2fsoft.com/contacto">Cont&aacute;ctenos</a></li>
                                    <li><a href="http://lab.ve2fsoft.com/contacto/curriculo.php">Env&iacute;a tu Curr&iacute;culo</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
<?php }

function templateFooter($root='resources/'){?>
	<div class="footer-container">
        <div id="rt-copyright">
            <div class="container">
                <div class="span12">
                    <div class="clear"></div>
                    <div class="rt-block">
                    	<p class="copyright">
                    		<span class="sitename">Medex </span>
                            ©
                            <span class="date"> 2013</span>
                            <span class="footerText"></span>
                              |  
                            <a href="/joomla_40677/index.php/privacy-policy">Privacy Policy</a>
                            
                            <span class="tel">1.800.123.45.67</span>
                        </p>
                        
                    </div>
                    <div class="clear"></div>
                    <div class="rt-block totop" style="display: block;">
                    	<a id="gantry-totop" href="#" style="outline: medium none;">Scroll to Top</a>
                    </div>
                </div>
            	<div class="clear"></div>
            </div>
        </div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
    <!--<script src="<?php echo $root;?>js/jquery.nivo.slider.js" type="text/javascript"></script>-->
    <script src="<?php echo $root;?>js/mutate.events.js" type="text/javascript"></script>
    <script src="<?php echo $root;?>js/mutate.min.js" type="text/javascript"></script>
    <script src="<?php echo $root;?>lib/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script>
		$(function(){$(".wrapper").mutate("height",function(){$(".footer-container").css("position","relative");var wh=$(window).height(),wrh=parseInt($(".wrapper").height());if(wrh==wh){$(".footer-container").css({position:"absolute",bottom:"0px"})}});$(".footer-container").css("position","relative");var wh=$(window).height(),wrh=parseInt($(".wrapper").height());if(wrh==wh){$(".footer-container").css({position:"absolute",bottom:"0px"})}$(".rt-block.totop").css("display","none");$(window).scroll(function(){scrollTop=$(window).scrollTop();if(scrollTop==0){$(".rt-block.totop").hide()}else{$(".rt-block.totop").show()}})});function dropdownOpen(dd){$(dd).addClass("open")}function dropdownClose(dd){$(dd).removeClass("open")};
		/*Google Analytics*/var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-38257200-1']);_gaq.push(['_setDomainName', 've2fsoft.com']);_gaq.push(['_trackPageview']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();
	</script>
<?php } ?>