<?php
	// Inicializa de la sesi&oacute;n.
	session_name('grupo1_itig');
	$_SESSION['usuarioid']=0;
	setcookie("usuarioid",0,time()-60*60*24*14);//hace dos semanaas
	
	// Si est&aacute; usando session_name("algo"), &iexcl;no lo olvide ahora!
	session_start();
	// Destruye todas las variables de la sesi&oacute;n
	session_unset();
	// Finalmente, destruye la sesi&oacute;n
	session_destroy();
?>
