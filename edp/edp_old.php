<?php
	include ("include/sesion.php");
	
	//Eliminamos Cache del Navegador
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
	
	if (check_user()) {
		$edp = header_normal("Vista de la EDP");
		$edp .= "<h1 class='ccorporativo centrado' style='margin-top:100px;'>";
		$edp .= "<a href='javascript:;' onclick='open(\"paquete/crear.php?id_padre=0\",\"\",\"width=700,height=550\")'>A&ntilde;adir paquete +";
		$edp .= "</h1>";
		echo $edp;
	} else {
		header ("Location: index.php?error=3");
	}
	
?>
