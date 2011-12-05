<?php
	//iniciamos sesion
	session_name('grupo1_itig');
	session_start();
	
	//conectamos con la base de datos
	$con = mysql_connect("localhost","user","pass"); 
	if (!$con) {
	  //Si no se pudo establecer una conexion, mostramos el error
	  die('Could not connect: ' . mysql_error());
	}
	
	//seleccionamos nuestra base de datos usando la conexion
	mysql_select_db("edp", $con);
	
	$cambios_recientes = '';
	
	//Recogemos variables de Sesion	
	if (isset($_COOKIE['usuarioid'])) {
		//Si existe cookie, reservamos una variable para el id
		$usuarioid=$_COOKIE['usuarioid'];
		$_SESSION['usuarioid']=$_COOKIE['usuarioid'];
	} else {
		//Si no existe cookie, comprobamos variables de sesion	
		if (isset($_SESSION['usuarioid'])) {
			//Si existe, reservamos una variable para el id
			$usuarioid=$_SESSION['usuarioid'];
		} else {
			//Si no, asignamos un id 0 que identificara 
			//a usuarios no registrados
			$_SESSION['usuarioid']=0;
		}
	}
	
	//funcion para comprobar la identidad del usuario
	function check_user () {
		//si el id es distinto de cero y la variable de sesion 
		//esta definida...
		//if(getNombreCompletoUsuario($_SESSION['usuarioid'])!=="Javier Cejudo")
		//	return false;
		if(isset($_SESSION['usuarioid']) && $_SESSION['usuarioid'] > 0) {
			//...devolvemos true
			return true;
		} else {
			//... y si no, false
			return false;
		}
	}
	
	//validacion de entradas
	function validar_entrada ($string) {
		return trim($string);
	}
	
	//funcion para mostrar el header html automaticamente
	//recogemos el titulo que debe mostrarse en la pagina html
	function header_normal($title) {
		$header = '<!DOCTYPE html>';
		$header .= '<html>';
		$header .= '<head>';
		$header .= '<link href="http://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" type="text/css">';
		//$header .= '<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">';
		$header .= '<title>'.$title.'</title>';
		$header .= '<link rel="stylesheet" type="text/css" href="estilos/estilos.css" />';
		$header .= '<link rel="shortcut icon" href="imagenes/favicon.ico">';
		$header .= '<script src="include/jquery.js" type="text/javascript"></script>';
		$header .= '<script src="include/script.js" type="text/javascript"></script>';
		$header .= '<script src="include/sorttable.js" type="text/javascript"></script>';
		$header .= '</head><body>';
		return $header;
	}
	
	function header_normal2($title) {
		$header = '<!DOCTYPE html>';
		$header .= '<html>';
		$header .= '<head>';
		$header .= '<link href="http://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" type="text/css">';
		//$header .= '<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">';
		$header .= '<title>'.$title.'</title>';
		$header .= '<link rel="stylesheet" type="text/css" href="../estilos/estilos.css" />';
		$header .= '<link rel="shortcut icon" href="../imagenes/favicon.ico">';
		$header .= '<script src="../include/jquery.js" type="text/javascript"></script>';
		$header .= '<script src="../include/script.js" type="text/javascript"></script>';
		$header .= '<script src="../include/sorttable.js" type="text/javascript"></script>';
		$header .= '</head><body>';
		return $header;
	}
	
	function getUsuarios () {
		$exito = mysql_query("SELECT id as id FROM usuario");
		if(!$exito){
			die('No se pudo cargar la lista de usuarios: ' . mysql_error());
		}
		return $exito;
	}
	
	function getNombrePaquete ($id) {
		$exito = mysql_query("SELECT nombre as nombre FROM paquete WHERE id=$id");
		if(!$exito){
			die('No se pudo recuperar el nombre del paquete: ' . mysql_error());
		}
		$row = mysql_fetch_array($exito);
		return $row['nombre'];
	}
	
	function getCodigoPaquete ($id) {
		$exito = mysql_query("SELECT codigo as codigo FROM paquete WHERE id=$id");
		if(!$exito){
			die('No se pudo recuperar el nombre del paquete: ' . mysql_error());
		}
		$row = mysql_fetch_array($exito);
		return $row['codigo'];
	}
	
	function getPaqueteDesdeComentario ($id) {
		$exito = mysql_query("SELECT pa.id as resultado FROM paquete pa join conversacion co on pa.id=co.id_paquete WHERE co.id=$id");
		if(!$exito){
			die('No se pudo recuperar el id del paquete: ' . mysql_error());
		}
		$row = mysql_fetch_array($exito);
		return $row['resultado'];
	}
	
	function existePaquete ($id) {
		$exito = mysql_query("SELECT id FROM paquete WHERE id='$id'");
		if(!$exito){
			die('No se pudo comprobar del paquete: ' . mysql_error());
		}
		$cantidad = mysql_num_rows($exito);
		if ($cantidad == 0)
			return false;
		else
			return true;
	}
	
	function actualizar_codigo ($id,$codigo) {
		$exito = mysql_query("UPDATE paquete 
							  SET codigo='$codigo' 
							  WHERE id=$id");
		if(!$exito)
			die('No se pudo actualizar el c&oacute;digo del paquete: ' . mysql_error());
	}
	
	function getPaquetes () {
		$exito = mysql_query("SELECT * FROM paquete ORDER BY codigo");
		if(!$exito){
			die('No se pudo cargar el paquete: ' . mysql_error());
		}
		return $exito;
	}	
	
	function getPaquete ($id) {
		$exito = mysql_query("SELECT * FROM paquete WHERE id=$id");
		if(!$exito){
			die('No se pudo cargar el paquete: ' . mysql_error());
		}
		return mysql_fetch_array($exito);
	}	
	
	function getPaquetesSuperiores() {
		$res = mysql_query("select * from paquete where id_padre=0 order by fecha_inicio, id");
		return $res;
	}
	
	function getWpNombre($wp) {
		return $wp['nombre'];
	}
	
	function getHijos ($id) {
		$res = mysql_query("select * from paquete where id_padre=$id order by id");
		return $res;
	}
	
	function numHijos ($id) {
		$res = mysql_query("select count(id) as num from paquete where id_padre=$id");
		$row = mysql_fetch_array($res);
		return $row['num'];
	}
	
	function getUltimaVisitaUsuario ($id) {
		$exito = mysql_query("SELECT ultima_visita as ultima_visita FROM usuario WHERE id=$id");
		if(!$exito){
			die('No se pudo recuperar el nombre del usuario: ' . mysql_error());
		}
		$row = mysql_fetch_array($exito);
		return $row['ultima_visita'];
	}
	
	function getNombreUsuario ($id) {
		$exito = mysql_query("SELECT nombre as nombre FROM usuario WHERE id=$id");
		if(!$exito){
			die('No se pudo recuperar el nombre del usuario: ' . mysql_error());
		}
		$row = mysql_fetch_array($exito);
		return $row['nombre'];
	}
	
	function getApellidosUsuario ($id) {
		$exito = mysql_query("SELECT apellidos as apellidos FROM usuario WHERE id=$id");
		if(!$exito){
			die('No se pudieron recuperar los apellidos del usuario: ' . mysql_error());
		}
		$row = mysql_fetch_array($exito);
		return $row['apellidos'];
	}
	
	function getCambios($responsable,$paquete,$tipo) {
		$query = "SELECT * FROM cambio WHERE 1=1";
		if(!empty($responsable))
			$query .= " AND autor_cambio=$responsable";
		if(!empty($paquete))
			$query .= " AND id_paquete=$paquete";
		if(!empty($tipo))
			$query .= " AND tipo_cambio=$tipo";		
		$query .= " ORDER BY fecha_cambio desc";
		$exito = mysql_query($query);
		if(!$exito){
			die('No se pudo recuperar el historial de cambios: ' . mysql_error());
		}
		return $exito;
	}
	
	function getBusquedaPaquetes($q) {
		$exito = mysql_query("SELECT pa.*, us.nombre as nomResp, us.apellidos 
								FROM paquete pa left join usuario us on pa.responsable=us.id 
								WHERE pa.nombre like '%$q%' OR pa.codigo like '$q%'
								OR CONCAT(us.nombre,' ',apellidos) like '%$q%'
								OR pa.descripcion like '%$q%' ORDER BY pa.codigo");
		if(!$exito){
			die('No se pudo recuperar el resultado de la b&uacute;squeda: ' . mysql_error());
		}
		return $exito;
	}
	
	function getBusquedaComentarios($q) {
		$exito = mysql_query("SELECT co.*, us.nombre, us.apellidos FROM conversacion co join usuario us on co.id_usuario=us.id
								WHERE contenido like '%$q%'
								OR CONCAT(nombre,' ',apellidos) like '%$q%'
								ORDER BY id desc");
		if(!$exito){
			die('No se pudo recuperar el resultado de la b&uacute;squeda: ' . mysql_error());
		}
		return $exito;
	}
	
	function getConversaciones($id) {
		$exito = mysql_query("SELECT * FROM conversacion WHERE id_paquete=$id ORDER BY fecha");
		if(!$exito){
			die('No se pudo recuperar el historial de conversaciones: ' . mysql_error());
		}
		return $exito;
	}
	
	function esMiembroEquipo ($id) {
		$exito = mysql_query("SELECT id_tipo as tipo FROM usuario WHERE id=$id");
		if(!$exito){
			die('No se pudo verificar el tipo de usuario: ' . mysql_error());
		}
		$row = mysql_fetch_array($exito);
		if ($row['tipo']==3) return true;
		else return false;
	}
	
	function getNombreCompletoUsuario ($id) {
		return getNombreUsuario($id)." ".getApellidosUsuario($id);
	}
?>
