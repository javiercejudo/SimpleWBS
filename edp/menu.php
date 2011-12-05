<?php
if (check_user()) {
	echo "<div id='menu'><strong style='font-variant:small-caps;'><a href='edp.php'>UR Project</a></strong>";
	echo " | Nivel:";
	echo " <a href='edp.php?nivel=0'>1</a><a href='edp.php?nivel=0&ajustar'>*</a>";
	echo " <a href='edp.php?nivel=1'>2</a><a href='edp.php?nivel=1&ajustar'>*</a>";
	echo " <a href='edp.php?nivel=2'>3</a><a href='edp.php?nivel=2&ajustar'>*</a>";
	echo " <a href='edp.php?nivel=3'>4</a><a href='edp.php?nivel=3&ajustar'>*</a>";
	echo " <a href='edp.php?nivel=4'>5</a><a href='edp.php?nivel=4&ajustar'>*</a>";
	echo " <a href='edp.php?nivel=100'>Todos</a><a href='edp.php?nivel=100&ajustar'>*</a>";
	//echo " <a target='_blank' href='edp_estatica.php?nivel=100'>Descargar</a>";
	//echo "<a target='_blank' href='edp_estatica.php?nivel=100&ajustar'>*</a>";
	echo " | <a href='diccionario.php'>Diccionario</a>";
	//echo "<a href='diccionario.php?extras'>*</a>";
	echo " | <a href='cambios.php'>Cambios</a>";
	echo " | ";
	echo "<form name='buscador' action='buscador.php' method='get' style='display:inline;'>";
	echo "<input type='text' placeholder='Buscar...' name='q' value='".$_GET['q']."' />";
	echo "</form>";
	echo " | <a href='logout.php'>Salir</a> (".trim(getNombreCompletoUsuario($usuarioid)).")</div>";
} else {
	header ("Location: index.php?error=3");
}
?>
