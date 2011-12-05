<?php

//include("logout_proceso.php");	
include("include/sesion.php");

if(check_user())
	header ("Location: edp.php");

$form = header_normal("Bienvenido a la Aplicaci&oacute;n de la EDP");
$form .= "<body>";
if($_GET['error']==1)
	$form .= "<div id='msj2'>El usuario no existe</span></span></div>";
elseif($_GET['error']==2) 
	$form .= "<div id='msj2'>La contrase&ntilde;a no es correcta</div>";
elseif($_GET['error']==3) 
	$form .= "<div id='msj2'>no tiene permiso para ver la p&aacute;gina que buscaba</div>";
	//$form .= "<div id='msj2'>Hola ".getNombreUsuario($usuarioid).", la p&aacute;gina se encuentra fuera de servicio por mantenimiento</div>";

$form .= "<form name='login' id='login' action='login.php' method='post'>";
$form .= "<fieldset id='fieldset_login'>";
//$form .= "<legend class='crojo'>Login</legend>";
$form .= "<p><a href='index.php'><img src='imagenes/logo2.png' alt='logo' width='369' height='223' /></a></p>";
$form .= "<p><input type='text' name='usuario' id='usuario' tabindex='1' placeholder='Usuario' value='".$_GET['alias']."' /></p>";
$form .= "<p><input type='password' name='clave' id='clave' tabindex='2'  placeholder='Contrase&ntilde;a' /></p>";


$form .= "<p><input type='submit' class='ancho' name='submit' value='Entrar' tabindex='4' />";
$form .= "<input type='checkbox' name='recordarme' id='recordarme' tabindex='3' />";
$form .= "<label for='recordarme'><small>recordarme</small></label></p>";
$form .= "</fieldset>";
$form .= "</form>";
$form .= "</body>";
$form .= "</html>";
echo $form;

mysql_close;
?>
