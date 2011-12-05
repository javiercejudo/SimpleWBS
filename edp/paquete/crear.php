<?php
	include ("../include/sesion.php");
	
	//Eliminamos Cache del Navegador
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
	
	if (check_user() && !esMiembroEquipo($usuarioid)) {
		$form = header_normal2("Creaci&oacute;n de paquete");
		$form .= "<script type='text/javascript' src='paquete.js'></script>";
		$form .= "<div id='contenedor'>";
		$form .= "<h2 class='ccorporativo'>Crear paquete</h2>";
		$form .= "<form name='crear' action='grabar.php' method='post' onsubmit='return validate_form(this)'>";
		$form .= "<fieldset class='sin_marco'>";
		$form .= "<table border='0'>";
		
		$form .= "<tr><td class='etiqueta_formulario'>Nombre</td><td>";
		$form .= "<input type='text' name='nombre' id='nombre' maxlength='255' autofocus='autofocus' tabindex='1' /> <em>(su c&oacute;digo se genera autom&aacute;ticamente)</em>";
		$form .= "<input type='hidden' name='id_padre' value='".$_GET['id_padre']."' tabindex='0' />";
		$form .= "</td></tr><tr><td>&nbsp;</td><td>&iquest;Se trata de un paquete de trabajo? <span class='pulsador respuesta' onclick='document.getElementById(\"paquete_de_trabajo\").style.display=\"\"'>S&iacute;</span> <span class='pulsador respuesta' onclick='document.getElementById(\"paquete_de_trabajo\").style.display=\"none\"'>No</span>";
		$form .= "</td></tr></table>";
		
		$form .= "<table border='0' style='display:none;' id='paquete_de_trabajo'><tr><td class='etiqueta_formulario'>Descripci&oacute;n</td><td>";
		$form .= "<textarea name='descripcion' id='descripcion' rows='10' tabindex='2'></textarea>";
		$form .= "</td></tr>";
		
		$form .= "<tr><td class='etiqueta_formulario'>&nbsp</td><td>";
		$form .= "<select tabindex='3' name='responsable'>";
		$form .= "<option value='0'>Responsable</option>";
		
		$lista_usuarios = getUsuarios();
		
		while ($row = mysql_fetch_array($lista_usuarios)) {
			$form .= "<option value='".$row['id']."'>".getNombreCompletoUsuario($row['id'])."</option>";
		}
		
		$form .= "</select>";
		$form .= "</td></tr>";
		
		$form .= "<tr><td class='etiqueta_formulario'>Inicio</td><td>";
		$form .= "<input type='date' name='inicio' id='inicio' tabindex='4'> yyyy-mm-dd";
		$form .= "</td></tr>";
		
		$form .= "<tr><td class='etiqueta_formulario'>Fin</td><td>";
		$form .= "<input type='date' name='fin' id='fin' tabindex='5'> yyyy-mm-dd";
		$form .= "</td></tr>";
		
		$form .= "<tr><td class='etiqueta_formulario'>Duraci&oacute;n</td><td>";
		$form .= "<input type='number' step='0.5' min='0' max='999' name='duracion' id='duracion' tabindex='6'> horas";
		$form .= "</td></tr>";
		
		$form .= "<tr><td class='etiqueta_formulario'>Entregable</td><td>";
		$form .= "<input type='text' maxlength='255' name='entregable' id='entregable' tabindex='7'>";
		$form .= "</td></tr>";
		
		$form .= "<tr><td class='etiqueta_formulario'>Vencimiento</td><td>";
		$form .= "<input type='date' name='vencimiento' id='vencimiento' tabindex='8'> yyyy-mm-dd";
		$form .= "</td></tr>";
		
		$form .= "<tr><td class='etiqueta_formulario'>Hito</td><td>";
		$form .= "<input type='text' maxlength='255' name='hito' id='hito' tabindex='9'>";
		$form .= "</td></tr>";
		
		$form .= "<tr><td class='etiqueta_formulario'>Coste</td><td>";
		$form .= "<input type='number' step='0.01' name='coste' id='coste' tabindex='10'>";
		$form .= "</td></tr></table>";
		
		$form .= "<br /><div class='centrado'><input type='submit' class='ancho' value='Crear' /> <input type='submit' class='ancho' name='seguir' value='Crear y seguir' />";
		$form .= " <input type='button' class='ancho' value='Cancelar' onclick='window.close()' />";
		$form .= "</div>";
		$form .= "</fieldset>";
		$form .= "</form>";
		$form .= "</div></body></html>";
		echo $form;
	} else {
		header ("Location: ../index.php?error=3");
	}
	
?>
