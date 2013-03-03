<?php
	include('mysql_var.php');
	
	function conectar(){
		global $server,$user,$pass;
		$conexion = mysql_connect($server, $user, $pass) or die("Could not connect: " . mysql_error());

		mysql_select_db('vefsoftc_lab');
	}
?>