<?php
	include ("include/sesion.php");
	//Eliminamos Cache del Navegador
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Pragma: no-cache");
	
	if (check_user()) {
		include ("edp_funciones.php");
		echo header_normal("Vista de la EDP");		
		//-----------Mensjaes de confiramcion/error
		if ($_GET['pcr']==1) 
			echo "<div id='msj3'>Nuevo paquete creado con &eacute;xito</div>";
		elseif ($_GET['nex']==2) 
			echo "<div id='msj2'>El paquete que busca ya no existe</div>";
		elseif ($_GET['pcr']==2) 
			echo "<div id='msj2'>Se produjo un error al intentar crear el paquete</div>";
		elseif ($_GET['pmo']==1) 
			echo "<div id='msj3'>Paquete modificado con &eacute;xito</div>";
		elseif ($_GET['pmo']==2) 
			echo "<div id='msj2'>Se produjo un error al intentar modificar el paquete</div>";
		elseif ($_GET['pbo']==1) 
			echo "<div id='msj'>Paquete borrado con &eacute;xito</div>";
		elseif ($_GET['pbo']==2) 
			echo "<div id='msj2'>Se produjo un error al borrar el paquete</div>";
		elseif ($_GET['mle']==1) {
			//actualizamos campo ultima visita
			$exito = mysql_query("UPDATE usuario 
								  SET ultima_visita='".date('Y-m-d H:i:s')."' 
								  WHERE id=".$_SESSION['usuarioid']);
			if(!$exito)
				echo "<div id='msj'>Se produjo un error al marcar los cambios como le&iacute;dos</div>";
			else
				echo "<div id='msj3'>Todos los cambios se marcaron como le&iacute;dos</div>";
			?> <script>setTimeout("location.href='edp.php'",2600)</script> <?php
		}
		//-----------FIN Mensjaes de confiramcion/error
		//--------------------------------------------NOTIFICACIONES
		//ultima visita
		$ultima_visita = getUltimaVisitaUsuario($_SESSION['usuarioid']);
		//recogemos las modificaciones desde la ultima visita
		$cambios_recientes = mysql_query("SELECT * FROM cambio WHERE fecha_cambio>='$ultima_visita' AND autor_cambio<>".$_SESSION['usuarioid']." ORDER BY fecha_cambio");
		if(!$cambios_recientes){
			die('No se pudieron recoger los cambios desde su &uacute;ltima visita: ' . mysql_error());
		}
		//--------------------------------------------FIN NOTIFICACIONES
		include("menu.php");
		echo "<div id='contenedor'>";
		echo "<h2>Aplicaci&oacute;n de la EDP";
		if(!esMiembroEquipo($usuarioid))
			echo " <small><a href='javascript:;' onclick='open(\"paquete/crear.php?id_padre=0\",\"\",\"width=700,height=600\")'><img src='imagenes/plus.png' width='16' height='16' alt='Nuevo hijo' title='Nueva fase'/></a></small>";
		echo "</h2>";
		
		if(mysql_num_rows($cambios_recientes)>0) {
			echo "<div class='notificacion'><h3>Cambios recientes (los elementos en <span style='color:grey;'>gris</span> han sido modificados y los <span style='color:blue;'>azules</span> son nuevos):</h3>";
			echo "<a href='edp.php?mle=1'>Marcar como le&iacute;dos</a><ul>";
			while ($aux = mysql_fetch_array($cambios_recientes)) {
				echo "<li>[".$aux['fecha_cambio']."] ".getNombreCompletoUsuario($aux['autor_cambio']).": ".$aux['descripcion']." <a href='descripcion.php?id_paquete=".$aux['id_paquete']."'>+ info</a></li>";
			}
			echo "</ul></div>";
		}
		$wps = getPaquetesSuperiores();
		$num_wps = numHijos(0);
		if($num_wps>0){
			$i=0;
			$nivel_visible=100;
			if (isset($_GET['nivel']) && is_numeric($_GET['nivel'])) {
				$nivel_visible = $_GET['nivel'];
			}
			echo "<div style='position:absolute;";
			if(!isset($_GET['ajustar']))
				echo "width:".(425*$num_wps)."px;";
			echo "'>";
			while ($row = mysql_fetch_array($wps)) {
				echo "<div style='float:left;margin:0 50px 0 0;width:375px;'>";
				$ord = ($i+1).".";
				actualizar_codigo($row['id'],$ord);
				echo "<h3 style='color:".colorearPaquete(0,$row['autor_alta'],$row['autor_cambio'],$row['fecha_alta'],$row['fecha_cambio']).";' href='descripcion.php?id_paquete=".$row['id']."'	>".$ord." <a class='no_color' style='color:".colorearPaquete(0,$row['autor_alta'],$row['autor_cambio'],$row['fecha_alta'],$row['fecha_cambio']).";' href='descripcion.php?id_paquete=".$row['id']."'>".$row['nombre']."</a>";
				if(numHijos($row['id'])>0) {
					if($nivel_visible<1)
						echo " <span class='pulsador' onclick='if(this.parentNode.nextSibling.style.display==\"none\") {this.parentNode.nextSibling.style.display=\"block\";this.innerHTML=\"&#9660;\";} else {this.parentNode.nextSibling.style.display=\"none\";this.innerHTML=\"&#9658;\";}'>&#9658;</span>";
					else
						echo " <span class='pulsador' onclick='if(this.parentNode.nextSibling.style.display==\"none\") {this.parentNode.nextSibling.style.display=\"block\";this.innerHTML=\"&#9660;\";} else {this.parentNode.nextSibling.style.display=\"none\";this.innerHTML=\"&#9658;\";}'>&#9660;</span>";
				}
				if(!esMiembroEquipo($usuarioid)) {
					echo " <a href='javascript:;' onclick='open(\"paquete/crear.php?id_padre=".$row['id']."\",\"\",\"width=700,height=600\")'><img src='imagenes/plus.png' width='16' height='16' alt='Nuevo hijo' title='Nuevo hijo'/></a>";
					echo " <a href='javascript:;' onclick='open(\"paquete/modificar.php?id=".$row['id']."\",\"\",\"width=700,height=600\")'><img src='imagenes/edit.gif' width='16' height='16' alt='Nuevo hijo' title='Modificar'/></a>&nbsp;";
					echo " <form style='display: inline' name='borrar' action='paquete/borrar.php' method='post' onsubmit='return borrar_paquete()'>";
					echo "<input type='hidden' name='id' value='".$row['id']."' />";
					echo "<input type='submit' value='Borrar' src='imagenes/borrar.gif'>";
					//echo "<a href='javascript:;' onclick='submit()'><img src='imagenes/borrar.gif' width='16' height='16' title='Borrar paquete y todos sus hijos' /></a>";
					echo "</form>";
				}
				echo "</h3>";
				escribirHijos($row,$ord,0,$nivel_visible);
				echo "</div>";
				$i++;
			}
			echo "</div>";
		} else {
			echo "<p>No se encontr&oacute; ning&uacute;n paquete de trabajo.";
			if(!esMiembroEquipo($usuarioid))
				 echo " <a href='javascript:;' onclick='open(\"paquete/crear.php?id_padre=0\",\"\",\"width=700,height=600\")'>&iexcl;Comience la EDP ahora!</a>";
			echo "</p>";
		}
		echo "</div></body></html>";
	} else {
		header ("Location: index.php?error=3");
	}
?>
