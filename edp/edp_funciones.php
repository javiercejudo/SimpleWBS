<?php	

	function colorearPaquete($nivel,$a_alta,$a_cambio,$f_alta,$f_cambio) {
		$f_ult = getUltimaVisitaUsuario($_SESSION['usuarioid']);
		if ($f_ult<$f_alta && $_SESSION['usuarioid']!=$a_alta && $nivel>0)
			return "#BED1EB;background-image: -moz-linear-gradient(top, #BED1EB, #A2BDE2); background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0, #BED1EB),color-stop(1, #A2BDE2))";
		elseif ($f_ult<$f_cambio && $_SESSION['usuarioid']!=$a_cambio && $nivel>0)
			return "#DDDDDD;background-image: -moz-linear-gradient(top, #DDDDDD, #E5E5E5); background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0, #DDDDDD),color-stop(1, #E5E5E5))";	
		elseif ($f_ult<$f_alta && $_SESSION['usuarioid']!=$a_alta && $nivel==0)
			return "#383BC0";		
		elseif ($f_ult<$f_cambio && $_SESSION['usuarioid']!=$a_cambio && $nivel==0)
			return "#757575";		
		switch($nivel){
			case 0:
				return "Black";
				break;
			case 1:
				return "#E5F0D4;background-image: -moz-linear-gradient(top, #E5F0D4, #D9E9BF); background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0, #E5F0D4),color-stop(1, #D9E9BF))";
				break;
			case 2:
				return "#EDF5BC;background-image: -moz-linear-gradient(top, #EDF5BC, #E9F3AB); background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0, #EDF5BC),color-stop(1, #E9F3AB))";
				break;
			case 3:
				return "#FCFBC0;background-image: -moz-linear-gradient(top, #FCFBC0, #FCFAAE); background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0, #FCFBC0),color-stop(1, #FCFAAE))";
				break;
			case 4:
				return "#F4D7D7;background-image: -moz-linear-gradient(top, #F4D7D7, #F6CBCB); background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0, #F4D7D7),color-stop(1, #F6CBCB))";
				break;
			case 5:
				return "#DDCDC7;background-image: -moz-linear-gradient(top, #DDCDC7, #D3C4BF); background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0, #DDCDC7),color-stop(1, #D3C4BF))";
				break;
			default:
				return "White";
		}
	}
	
	function escribirHijos($wp,$ord,$nivel,$nivel_visible) {
		$nivel++;
		$hijos = getHijos($wp['id']);
		$num_hijos = numHijos($wp['id']);
		if($num_hijos>0) {
			if($nivel>$nivel_visible)
				echo "<div class='subtitle_edp_lista' style='display:none;'>";
			else
				echo "<div class='subtitle_edp_lista' style='display:block;'>";
			$i=0;
			while ($row = mysql_fetch_array($hijos)) {
				echo "<div class='subtitle_edp' style='background-color:".colorearPaquete($nivel,$row['autor_alta'],$row['autor_cambio'],$row['fecha_alta'],$row['fecha_cambio']).";'>";
				echo "<div onmouseover='document.getElementById(\"paquete_".$row['id']."\").style.visibility=\"visible\"' onmouseout='document.getElementById(\"paquete_".$row['id']."\").style.visibility=\"hidden\"'>";
				if(!esMiembroEquipo($GLOBALS['usuarioid'])) {
					echo " <div class='opciones' style='visibility:hidden;' id='paquete_".$row['id']."'>";
					if ($nivel<5)
						echo "<a href='javascript:;' onclick='open(\"paquete/crear.php?id_padre=".$row['id']."\",\"\",\"width=700,height=600\")'><img src='imagenes/plus.png' width='16' height='16' alt='Nuevo hijo' title='Nuevo hijo'/></a>&nbsp;";
					echo "<a href='javascript:;' onclick='open(\"paquete/modificar.php?id=".$row['id']."\",\"\",\"width=700,height=600\")'><img src='imagenes/edit.gif' width='16' height='16' alt='Modificar' title='Modificar'/></a>&nbsp;";
					echo "<form style='display: inline' name='borrar' action='paquete/borrar.php' method='post' onsubmit='return borrar_paquete()'>";
					echo "<input type='hidden' name='id' value='".$row['id']."' />";
					echo "<input type='submit' value='Borrar' src='imagenes/borrar.gif'>";
					echo "</form>";
					echo "</div>";
				}
				$ord_aux = $ord.($i+1).".";
				echo $ord_aux." <a class='no_color' href='descripcion.php?id_paquete=".$row['id']."'>".$row['nombre']."</a>";
				actualizar_codigo($row['id'],$ord_aux);
				if(numHijos($row['id'])>0) {
					if($nivel<$nivel_visible)
						echo "&nbsp;<span class='pulsador' onclick='if(this.parentNode.nextSibling.style.display==\"none\") {this.parentNode.nextSibling.style.display=\"block\";this.innerHTML=\"&#9660;\";} else {this.parentNode.nextSibling.style.display=\"none\";this.innerHTML=\"&#9658;\";}'>&#9660;</span>";
					else
						echo "&nbsp;<span class='pulsador' onclick='if(this.parentNode.nextSibling.style.display==\"none\") {this.parentNode.nextSibling.style.display=\"block\";this.innerHTML=\"&#9660;\";} else {this.parentNode.nextSibling.style.display=\"none\";this.innerHTML=\"&#9658;\";}'>&#9658;</span>";
				}
				echo "</div>";
				escribirHijos($row,$ord.($i+1).".",$nivel,$nivel_visible);
				echo "</div>";
				$i++;
			}
			echo "</div>";
		}
	}
?>
