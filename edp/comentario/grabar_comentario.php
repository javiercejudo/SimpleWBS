<?php

include ("../include/sesion.php");

//Eliminamos Cache del Navegador
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Pragma: no-cache");
   
	if (check_user() && !esMiembroEquipo($usuarioid)) {
		$id_paquete = trim($_POST['id_paquete']);
		$comentario = validar_entrada($_POST['comentario']);
		$fecha_alta = date('Y-m-d H:i:s');
		$id_usuario = $_SESSION['usuarioid'];
		
		if (empty($comentario)) {
			$errores[] = "El comentario no puede estar vac&iacute;o";
		}
		
		if (!is_numeric($id_paquete) || !existePaquete($id_paquete)) {
			$errores[] = "No jugu&eacute;is conmigo";
		}
		
		if(count($errores)==0) {
			$exito = mysql_query("INSERT INTO conversacion (id_paquete, id_usuario, contenido, fecha)
					VALUES ('$id_paquete','$id_usuario','$comentario','$fecha_alta')");
			if(!$exito){
				die('Error al introducir un paquete: ' . mysql_error());
			} else{
				$exito = mysql_query("INSERT INTO cambio (fecha_cambio, descripcion, autor_cambio, id_paquete, tipo_cambio)
					VALUES ('$fecha_alta','Nuevo comentario en el paquete \"".getNombrePaquete($id_paquete)."\"','$id_usuario','$id_paquete','4')");
				if (!$exito) {
					die('No se puede comunicar el cambios al resto de los usuarios.');
				}
				echo "<script type='text/javascript'>location.href='../descripcion.php?id_paquete=".$id_paquete."&ccr=1#comentarios';</script>";
			}
		} else {
			echo "<script type='text/javascript'>location.href='../descripcion.php?id_paquete=".$id_paquete."&ccr=2';</script>";
		}
	} else {
		header ("Location: index.php?error=3");
	}

?>
