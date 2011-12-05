<?php
	include ("include/sesion.php");
	
	//Eliminamos Cache del Navegador
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Pragma: no-cache");
	
	if (check_user()) {
		echo header_normal("Diccionario de la EDP");
		include("menu.php");
		$paquetes = getPaquetes();
		echo "<div id='contenedor'>";
		echo "<h2>Diccionario de la EDP</h2>";
		while ($d_p = mysql_fetch_array($paquetes)) {
			$id_paquete = $d_p['id'];
			if(numHijos($d_p['id'])==0) {
				echo "<h3><a class='no_color' href='descripcion.php?id_paquete=".$id_paquete."'>".$d_p['codigo']." ".getNombrePaquete($id_paquete)."</a>";
				echo "</h3>";
				
				if (isset($_GET['extras'])) {
					echo "<a href='cambios.php?paquete=".$id_paquete."'>Ver historial de cambios de este paquete</a>";
				}
						
				if (!empty($d_p['descripcion']))
					echo "<blockquote><em>".nl2br($d_p['descripcion'])."</em></blockquote>";
				else
					echo "<blockquote><em>No existe una descripci&oacute;n para este paquete.</em></blockquote>";
				if (!empty($d_p['responsable']))
					echo "<p>Responsable: <strong>".getNombreCompletoUsuario($d_p['responsable'])."</strong></p>";
				if ($d_p['fecha_inicio']>0)
					echo "<p>Fecha de inicio (yyyy-mm-dd): <strong>".substr($d_p['fecha_inicio'],0,10)."</strong></p>";
				if ($d_p['fecha_fin']>0)
					echo "<p>Fecha de fin (yyyy-mm-dd): <strong>".substr($d_p['fecha_fin'],0,10)."</strong></p>";
				if ($d_p['duracion']>0)
					echo "<p>Duraci&oacute;n: <strong>".$d_p['duracion']."</strong> horas</p>";
				if (!empty($d_p['entregable']))
					echo "<p>Entregable: <strong>".$d_p['entregable']."</strong></p>";
				if ($d_p['fecha_entregable']>0)
					echo "<p>Fecha de entrega (yyyy-mm-dd): <strong>".substr($d_p['fecha_entregable'],0,10)."</strong></p>";
				if (!empty($d_p['hito']))
					echo "<p>Hito: <strong>".$d_p['hito']."</strong></p>";
				if ($d_p['coste']>0)
					echo "<p>Coste: <strong>".$d_p['coste']."</strong> &euro;</p>";
				if (isset($_GET['extras'])) {
					echo "<div class='notificacion'>";
					echo "<h4><a name='comentarios'>Conversaciones:</a></h4>";
					$conversaciones = getConversaciones($id_paquete);
					if(mysql_num_rows($conversaciones)>0) {
						echo "<ol>";
						while ($conversacion = mysql_fetch_array($conversaciones)) {
							echo "<li><div class='comentario'>".$conversacion['contenido']."<br /><em>".getNombreCompletoUsuario($conversacion['id_usuario'])." en fecha ".$conversacion['fecha']."</em>&nbsp;";
							if(!esMiembroEquipo($usuarioid) && $conversacion['id_usuario']==$usuarioid) {
								echo "<form style='display: inline' name='borrar' action='comentario/borrar.php' method='post' onsubmit='return borrar_comentario()'>";
								echo "<input type='hidden' name='id' value='".$conversacion['id']."'>";
								echo "<input type='submit' value='Borrar'>";
								echo "</form>";
							}
							echo "</div></li>";
						}
						echo "</ol>";
					} else {
						echo "<p>No se encontraron conversaciones asociadas.</p>";
					}
					if (!esMiembroEquipo($usuarioid)) {
						echo "<form name='crear' action='comentario/grabar_comentario.php' method='post' onsubmit='return validate_form(this)'>";
						echo "<fieldset class='sin_marco'>";
						echo "<p>Nuevo comentario:</p>";
						echo "<input type='hidden' name='id_paquete' value='".$id_paquete."' tabindex='0' />";
						echo "<textarea name='comentario' rows='5'></textarea><br />";
						echo "<input type='submit' class='ancho' value='Comentar' /> <input type='reset' class='ancho' value='Limpiar' />";
						echo "</form>";
					}
					echo "</div>";
				}
				else echo "<hr />";
			}
		}
		echo "</div></body></html>";
	} else {
		header ("Location: index.php?error=3");
	}
?>
