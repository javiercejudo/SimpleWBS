<?php
	
	// Inicializa de la sesion.
	session_name('grupo1_itig');
	// Si esta usando session_name("algo"), ¡no lo olvide ahora!
	session_start();
	// Destruye todas las variables de la sesion
	session_unset();
	// Finalmente, destruye la sesion
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
	
	//Recojo Variables con el Metodo POST
	$usuario=$_POST['usuario'];
	$clave=md5($_POST['clave']);
	$ref=$_POST['ref'];
	
	$datos_usuarios = mysql_query("SELECT id,alias,clave FROM usuario ORDER BY id asc");
	if (!$datos_usuarios) {
		die('No se pudo acceder a la tabla de usuarios: ' . mysql_error());
	}
	$esta=0;
	while ($row = mysql_fetch_array($datos_usuarios)){
		if ($row['alias']==$usuario){
			$esta=1;
			if ($row['clave']==$clave){
				$_SESSION['usuarioid']=$row['id'];
				if (isset($_POST['recordarme'])) {
					setcookie("usuarioid",$row['id'],time()+60*60*24*14);//dos semanas
				}
				if($ref!='')
					header ("Location: ".$ref);
				else
					header ("Location: edp.php");
			} else {
				header ("Location: index.php?error=2&alias=".$usuario);
			}
		}
	}
	if ($esta==0){
		header ("Location: index.php?error=1");
	}
?>
