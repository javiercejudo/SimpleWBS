<?php

include ("../include/sesion.php");

//Eliminamos Cache del Navegador
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Pragma: no-cache");
   
	if (check_user() && !esMiembroEquipo($usuarioid)) {
		$id = trim($_POST['id']);
		$fecha_alta = date('Y-m-d H:i:s');
				
		if (!is_numeric($id)) {
			$errores[] = "El comentario que intenta borrar no existe ".$id;
		} else {
			$nombre_paquete = getNombrePaquete(getPaqueteDesdeComentario($id));
			$id_paquete = getPaqueteDesdeComentario($id);
		}
		
		if(count($errores)==0 && !esMiembroEquipo($usuarioid)) {
			//soy plenamente consciente de que esto no elimina los hijos
			//pero no apareceran en la edp :) challenge accepted!
			$exito = mysql_query("DELETE FROM conversacion WHERE id=$id AND id_usuario=$usuarioid");
			if(!$exito){
				die('Error al borrar el paquete: ' . mysql_error());
			} else{
				$exito = mysql_query("INSERT INTO cambio (fecha_cambio, descripcion, autor_cambio, id_paquete,tipo_cambio)
					VALUES ('$fecha_alta','Eliminaci&oacute;n de un comentario del paquete \"".$nombre_paquete."\"','$usuarioid','$id_paquete','5')");
				if (!$exito) {
					die('No se puede comunicar el cambios al resto de los usuarios: ' . mysql_error());
				}
				echo "<script type='text/javascript'>window.location.href='../descripcion.php?id_paquete=".$id_paquete."&cbo=1#comentarios'</script>";
			}
		} else {
			echo "<script type='text/javascript'>location.href='../descripcion.php?id_paquete=".$id_paquete."&cbo=2';</script>";
		}
	} else {
		header ("Location: ../index.php?error=3");
	}

?>
