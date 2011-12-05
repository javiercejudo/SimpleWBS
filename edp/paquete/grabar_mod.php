<?php

include ("../include/sesion.php");

//Eliminamos Cache del Navegador
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Pragma: no-cache");
   
	if (check_user() && !esMiembroEquipo($usuarioid)) {
		$id = trim($_POST['id']);
		$nombre = validar_entrada($_POST['nombre']);
		$descripcion = validar_entrada($_POST['descripcion']);
		$responsable = $_POST['responsable'];
		$fecha_inicio = $_POST['inicio'];
		$fecha_fin = $_POST['fin'];
		$duracion = trim($_POST['duracion']);
		$hito = validar_entrada($_POST['hito']);
		$entregable = validar_entrada($_POST['entregable']);
		$fecha_entregable = $_POST['vencimiento'];
		$coste = $_POST['coste'];
		$fecha_cambio = date('Y-m-d H:i:s');
		$autor = $_SESSION['usuarioid'];
		
		if (empty($nombre)) {
			$errores[] = "El nombre no puede estar vac&iacute;o";
		}
		
		$f_aux = explode("-",$fecha_inicio);
		if ($fecha_inicio != '') {
			if (!checkdate($f_aux[1],$f_aux[2],$f_aux[0])) {
				$errores[] = "Fecha de inicio no v&aacute;lida";
			} else {
				$fecha_inicio .= " 00:00:00";
			}
		}
				
		$f_aux = explode("-",$fecha_fin);
		if ($fecha_fin != '') {
			if (!checkdate($f_aux[1],$f_aux[2],$f_aux[0])) {
				$errores[] = "Fecha de fin no v&aacute;lida";
			} else {
				$fecha_fin .= " 00:00:00";
			}
		}
		
		$f_aux = explode("-",$vencimiento);
		if ($vencimiento != '') {
			if (!checkdate($f_aux[1],$f_aux[2],$f_aux[0])) {
				$errores[] = "Fecha de fin no v&aacute;lida";
			} else {
				$vencimiento .= " 00:00:00";
			}
		}
				
		if (!is_numeric($duracion) && $duracion!='') {
			$errores[] = "Duraci&oacute;n no v&aacute;lida.";
		}
		
		if (!is_numeric($coste) && $coste!='') {
			$errores[] = "Coste no v&aacute;lido.";
		}
		
		if (!is_numeric($id)) {
			$errores[] = "No jugu&eacute;is conmigo";
		}
		
		if(count($errores)==0) {
			$exito = mysql_query("UPDATE paquete 
									SET nombre='$nombre', 
										descripcion='$descripcion', 
										responsable='$responsable', 
										fecha_inicio='$fecha_inicio', 
										fecha_fin='$fecha_fin', 
										duracion='$duracion', 
										entregable='$entregable', 
										fecha_entregable='$fecha_entregable', 
										hito='$hito', 
										coste='$coste', 
										fecha_cambio='$fecha_cambio', 
										autor_cambio='$usuarioid'
									WHERE id=$id");
			if(!$exito){
				die('Error al modificar el paquete: ' . mysql_error());
			} else{
				$exito = mysql_query("INSERT INTO cambio (fecha_cambio, descripcion, autor_cambio, id_paquete, tipo_cambio)
					VALUES ('$fecha_cambio','Modificaci&oacute;n del paquete \"".$nombre."\"','$usuarioid','$id','2')");
				if (!$exito) {
					die('No se puede comunicar el cambios al resto de los usuarios.');
				}
				echo "<script type='text/javascript'>window.opener.location.href='../descripcion.php?id_paquete=$id&pmo=1';window.close()</script>";
			}
		} else {
			echo "<script type='text/javascript'>window.opener.location.href='../descripcion.php?id_paquete=$id&pmo=2';window.close()</script>";
		}
	} else {
		header ("Location: ../index.php?error=3");
	}

?>
