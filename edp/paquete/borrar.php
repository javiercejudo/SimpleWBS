<?php

include ("../include/sesion.php");

//Eliminamos Cache del Navegador
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Pragma: no-cache");
	
	function borrado_recursivo($id) {
		$hijos=mysql_query("SELECT * FROM paquete WHERE id_padre='$id'");
		while($row=mysql_fetch_array($hijos)) {
		  borrado_recursivo($row['id']);
		}
		mysql_query("DELETE FROM conversacion WHERE id_paquete='$id'");
		mysql_query("DELETE FROM paquete WHERE id='$id'");
		return true;
	}
   
	if (check_user() && !esMiembroEquipo($usuarioid)) {
		$id = trim($_POST['id']);
		$fecha_alta = date('Y-m-d H:i:s');
				
		if (!is_numeric($id) || !existePaquete($id)) {
			$errores[] = "El paquete que intenta borrar no existe ".$id;
		} else {
			$nombre_paquete = getNombrePaquete($id);
		}
		
		if(count($errores)==0) {
			$exito = borrado_recursivo($id);
			if(!$exito){
				die('Error al borrar el paquete.');
			} else{
				$exito = mysql_query("INSERT INTO cambio (fecha_cambio, descripcion, autor_cambio,id_paquete,tipo_cambio)
					VALUES ('$fecha_alta','Eliminaci&oacute;n del paquete \"".$nombre_paquete."\" y de todos sus hijos y comentarios','$usuarioid','$id','3')");
				if (!$exito) {
					die('No se puede comunicar el cambios al resto de los usuarios.');
				}
				echo "<script type='text/javascript'>window.location.href='../edp.php?pbo=1'</script>";
			}
		} else {
			echo "<script type='text/javascript'>window.opener.location.href='../edp.php?pbo=2';window.close()</script>";
		}
	} else {
		header ("Location: ../index.php?error=3");
	}

?>
