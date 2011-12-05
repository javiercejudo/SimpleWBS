<?php
	include ("include/sesion.php");
	//Eliminamos Cache del Navegador
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Pragma: no-cache");
	
	if (check_user()) {
		$responsable = $_GET['responsable'];
		$paquete = $_GET['paquete'];
		$tipo = $_GET['tipo'];
		
		echo header_normal("Diario de cambios");
		include("menu.php");
		echo "<div id='contenedor'>";
		echo "<h2>Diario de cambios";
		if (existePaquete($paquete))
			echo " del paquete \"".getNombrePaquete($paquete)."\"";
		elseif(!empty($paquete))
			echo " de un paquete eliminado";
		echo "</h2>";
		
		echo "<form name='filtro_cambios' action='cambios.php' method='get'>";
		echo "<input type='hidden' value='$paquete' name='paquete' />";
		echo "Realizados por <select name='responsable' onchange='submit()'>";
		echo "<option value=''>todos</option>";
		$lista_usuarios = getUsuarios();
		while ($row = mysql_fetch_array($lista_usuarios)) {
			echo "<option value='".$row['id']."'";
			if($row['id'] == $responsable)
				echo " selected";
			echo ">".getNombreCompletoUsuario($row['id'])."</option>";
		}
		echo "</select>";
		
		echo " de tipo: <select name='tipo' onchange='submit()'>";
		echo "<option value=''>cualquiera</option>";
		echo "<option value='1'"; if($tipo == 1) echo " selected"; echo ">creaci&oacute;n de paquete</option>";
		echo "<option value='2'"; if($tipo == 2) echo " selected"; echo ">modificaci&oacute;n de paquete</option>";
		echo "<option value='3'"; if($tipo == 3) echo " selected"; echo ">eliminaci&oacute;n de paquete</option>";
		echo "<option value='4'"; if($tipo == 4) echo " selected"; echo ">nuevo comentario</option>";
		echo "<option value='5'"; if($tipo == 5) echo " selected"; echo ">eliminaci&oacute;n de comentario</option>";
		echo "</select>";
		//echo " <a href='cambios.php'>Ver todos los cambios</a>";
		echo "</form>";
		
		$cambios = getCambios($responsable,$paquete,$tipo);
		if(mysql_num_rows($cambios)>0) {
			echo "<p>Se pueden ordenar los datos pinchando sobre la cabecera de cada columna. As&iacute;, es posible ordenar por fecha inversamente y agrupar por autor o tipo de cambio.</p>";
			echo "<table cellpadding='5' cellspacing='0' width='100%' class='sortable'>";
			echo "<thead class='th_b'>";
			echo "<tr style='cursor:pointer;'>";
			echo "<th>Fecha</th>";
			echo "<th>Autor</th>";
			echo "<th>Descripci&oacute;n</th>";
			echo "<th class='sorttable_nosort'>Ver</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			$autor_anterior=0;
			while ($aux = mysql_fetch_array($cambios)) {
				echo "<tr class='seleccionable'><td class='tsep centrado'>".$aux['fecha_cambio']."</td>";
				//if ($aux['autor_cambio']!=$autor_anterior)
					echo "<td class='tsep centrado' sorttable_customkey='".getNombreCompletoUsuario($aux['autor_cambio'])."'>".getNombreCompletoUsuario($aux['autor_cambio'])."</td>";
				//else
				//	echo "<td class='tsep centrado' sorttable_customkey='".getNombreCompletoUsuario($aux['autor_cambio'])."'><span title='".getNombreCompletoUsuario($aux['autor_cambio'])."'>&uarr;</span></td>";
				echo "<td class='tsep'>".$aux['descripcion']."  </td>";
				echo "<td class='tsep centrado'><a href='descripcion.php?id_paquete=".$aux['id_paquete']."'>Paquete</a>";
				echo "<br /><a href='cambios.php?paquete=".$aux['id_paquete']."'>Cambios</a></td></tr>";
				$autor_anterior = $aux['autor_cambio'];
			}
			echo "</tbody>";
			echo "</table>";
		} else echo "<p>No se encontr&oacute; ning&uacute;n cambio.</p>";
		echo "</div></body></html>";
	} else {
		header ("Location: index.php?error=3");
	}
?>
