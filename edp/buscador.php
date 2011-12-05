<?php
	include ("include/sesion.php");
	//Eliminamos Cache del Navegador
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Pragma: no-cache");
	
	$q = replace_accents($_GET['q']);
	
	function replace_accents($str) {
		$str = UTF8_encode($str);
		$str = htmlentities($str, ENT_COMPAT, "UTF-8");
		$str = preg_replace('/&([a-zA-ZñÑ])(uml|acute|grave|circ|tilde);/','$1',$str);
		return html_entity_decode($str);
	}
	
	function b2 ($string) {
		$pos=stripos(replace_accents($string),$GLOBALS['q']);
		if($pos===false) return $string;
		$antes=substr($string,0,$pos);
		$marcado=substr($string,$pos,strlen($GLOBALS['q']));
		$despues=substr($string,$pos+strlen($GLOBALS['q']));
		$despues=b2($despues);
		if (strlen($marcado)>0) return $antes."<span class='res_busqueda''>".$marcado."</span>".$despues;
		else return $antes.$marcado.$despues;
	}
	
	if (check_user()) {
		echo header_normal("Buscador");
		include("menu.php");
		echo "<div id='contenedor'>";
		if(empty($q))
			echo "<h2>Buscador</h2>";
		else
			echo "<h2>Buscando \"".$q."\"</h2>";
		$resP = getBusquedaPaquetes($q);
		$numP = mysql_num_rows($resP);
		echo "<div style='float:left;width:45%;margin-right:5%;'>";
		echo "<h3>Paquetes";
		if ($numP==1) echo " (1 resultado)";
		elseif ($numP>1) echo " (".$numP." resultados)";
		echo "</h3>";
		if($numP>0) {
			while ($aux = mysql_fetch_array($resP)) {
				echo "<div class='resultados'>";
				echo "<span class='t_buscador'><a href='descripcion.php?id_paquete=".$aux['id']."'>".b2($aux['codigo'])." ".b2($aux['nombre'])."</a></span><br />";
				if(!empty($aux['descripcion']))
					echo b2($aux['descripcion'])."<br />";
				echo "<span class='f_buscador'>".b2(getNombreCompletoUsuario($aux['responsable']))."</span>";
				echo "</div><br />";
			}
		} else echo "<p>No se encontr&oacute; ning&uacute;n paquete :(</p>";
		echo "</div>";
		$resC = getBusquedaComentarios($q);
		$numC = mysql_num_rows($resC);
		echo "<div style='float:left;width:50%;'>";
		echo "<h3>Comentarios";
		if ($numC==1) echo " (1 resultado)";
		elseif ($numC>1) echo " (".$numC." resultados)";
		echo "</h3>";
		if(mysql_num_rows($resC)>0) {
			while ($aux = mysql_fetch_array($resC)) {
				echo "<div class='resultados'><span class='t_buscador'><a href='descripcion.php?id_paquete=".getPaqueteDesdeComentario($aux['id'])."'>".b2($aux['contenido'])."</a></span><br />";
				echo "<span class='f_buscador'>".b2(getNombreCompletoUsuario($aux['id_usuario']))."&nbsp;&nbsp;&nbsp;".substr($aux['fecha'],0,10)."&nbsp;&nbsp;&nbsp;".getCodigoPaquete(getPaqueteDesdeComentario($aux['id']))." ".getNombrePaquete(getPaqueteDesdeComentario($aux['id']))."</span>";
				echo "</div><br />";
			}
		} else echo "<p>No se encontr&oacute; ning&uacute;n comentario :(</p>";
		echo "</div>";
		echo "</div></body></html>";
	} else {
		header ("Location: index.php?error=3");
	}
?>
