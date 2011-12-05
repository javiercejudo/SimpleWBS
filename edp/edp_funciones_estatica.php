<?php	

	function colorearPaquete($nivel,$a_alta,$a_cambio,$f_alta,$f_cambio) {
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
				$ord_aux = $ord.($i+1).".";
				echo $ord_aux." ".$row['nombre'];
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
