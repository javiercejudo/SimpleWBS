<?php
	include ("include/sesion.php");
	//Eliminamos Cache del Navegador
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Pragma: no-cache");
	
	if (check_user()) {
		include ("edp_funciones_estatica.php");
		echo header_normal("Vista de la EDP");
		?>
		<style>
		body {
			border: 0;
			padding: 0;
			margin: 0;
			font-size: 90%;
			font-family: 'Ubuntu';
			overflow-y:scroll;
			-o-text-shadow:2px 1px 1px #eeeeee;
			-moz-text-shadow:2px 1px 1px #eeeeee;
			-webkit-text-shadow:2px 1px 1px #eeeeee;
			text-shadow:2px 1px 1px #eeeeee;
		}

		a img {
			border:0;
		}

		fieldset {
			-o-border-radius: 120px;
			-moz-border-radius: 120px;
			-webkit-border-radius: 120px;
			border-radius: 120px;
			border-color: #00B5FF;
			border: 0;
		}

		fieldset.sin_marco {
			border: 0;
		}

		input[type="text"], input[type="search"], input[type="date"], 
		input[type="number"], input[type="password"], textarea {
			border: 1px solid #00B5FF;/*00B5FF*/
			outline: none;
			background-color: white;
			padding: 3px 10px;
			-o-border-radius: 5px;
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;
			border-radius: 5px;
			margin: 0px;
		}

		input[type="text"]:focus, input[type="search"]:focus, input[type="date"]:focus, 
		input[type="number"]:focus, input[type="password"]:focus, textarea:focus {
			-moz-box-shadow: 0 0 3px #00B5FF;
			-o-box-shadow: 0 0 3px #00B5FF;
			-webkit-box-shadow: 0 0 3px #00B5FF;
			box-shadow: 0 0 3px #00B5FF;
		}

		textarea {
			width:400px;
		}

		a {
			color: #0086C4;
			text-decoration: none;
		}

		#fieldset_login{
			width: 400px;
			margin: 0 auto;
			/*background-color: #F5F5FF;*/
			padding: 30px;
			text-align: center;
			/*-moz-box-shadow: 0 0 20px #00B5FF;
			-o-box-shadow: 0 0 20px #00B5FF;
			-webkit-box-shadow: 0 0 20px #00B5FF;
			box-shadow: 0 0 20px #00B5FF;*/
		}

		#usuario, #clave {
			-moz-border-radius: 17px;
			-o-border-radius: 17px;
			-webkit-border-radius: 17px;
			border-radius: 17px;
			width: 220px;
			height: 24px;
			font-size: 120%;
			padding: 5px 15px;
		}

		#contenedor {
			margin:0 5px;
		}

		#menu {
			padding:5px 10px;
			border-bottom:1px solid #888;
			border-right:1px solid #888;
			border-left:1px solid #888;
			margin: 0px auto 10px auto;
			text-align: center;
			width: 90%;
			-o-border-bottom-left-radius: 20px;
			-webkit-border-bottom-left-radius: 20px;
			-moz-border-radius-bottomleft: 20px;
			border-bottom-left-radius: 20px;
			-o-border-bottom-right-radius: 20px;
			-webkit-border-bottom-right-radius: 20px;
			-moz-border-radius-bottomright: 20px;
			border-bottom-right-radius: 20px;
			-webkit-box-shadow: #888888 0px 3px 5px;
			-moz-box-shadow: #888888 0px 3px 5px;
			-o-box-shadow: #888888 0px 3px 5px;
			box-shadow: #888888 0px 3px 5px;
		}

		input.ancho {
			padding: 5px 12px;
		}

		.etiqueta_formulario {
			text-align: right;
			width: 100px;
		}

		.crojo {
			color: Red;
		}

		.ccorporativo {
			color: #0086C4;
		}

		.centrado {
			text-align: center;
		}

		.pulsador {
			cursor: pointer;
		}

		.oculto {
			display:none;
		}

		.respuesta {
			border: 1px solid grey;
			padding: 2px 5px;
			-o-border-radius: 5px;
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;
			border-radius: 5px;
		}

		.respuesta:hover {
			background-color: #00B5FF;
			color: White;
		}

		.subtitle_edp_lista {
			list-style: none outside none;
			display:none;
			margin-left:20px;
		}

		.subtitle_edp {
			padding: 5px 8px 15px;
			margin: 5px;
			border:1px solid grey;
			width: 200px;
			/*height: 50px;*/
			-o-border-radius: 20px;
			-moz-border-radius: 20px;
			-webkit-border-radius: 20px;
			border-radius: 20px;
			-webkit-box-shadow: #888888 3px 3px 5px;
			-moz-box-shadow: #888888 3px 3px 5px;
			-o-box-shadow: #888888 3px 3px 5px;
			box-shadow: #888888 3px 3px 5px;
		}

		.titulo_edp {
			border: 0px solid black;
			margin: 10px;
			padding: 10px;
		}

		.th_b th{
			border: 1px solid grey;
			-o-border-radius:20px;
			-webkit-border-radius:20px;
			-moz-border-radius:20px;
			border-radius: 20px;
		}

		.th_n{
			border-width: 0;
			background-color: white;
		}

		.tsep{
			 border-bottom: 1px dotted #cccccc;
		}

		.seleccionable:hover{
			background-color: #D9F2FC;
		}

		.no_color {
			color: Black;
		}

		.notificacion {
			clear: both;
			padding: 0 5px;
			background-color: #f5f5ff;
			border-top: 1px dashed black;
			border-bottom: 1px dashed black;
		}

		.opciones {
			text-align: right;
		}

		.comentario {
			margin-bottom: 10px;
		}

		#msj, #msj2, #msj3 {
			clear: both;
			display:none;
			position: fixed;
			height:40px;
			line-height:40px;
			width: 100%;
			font-weight: bold;
			text-align: center;
			padding: 2px;
			margin: 0 auto;
			background-color: #FFF1A8;
			-webkit-box-shadow: #888888 1px 1px 1px;
			-moz-box-shadow: #888888 1px 1px 1px;
			-o-box-shadow: #888888 1px 1px 1px;
			box-shadow: #888888 0px 1px 2px;
			opacity: 0.95;
			z-index:50;
		}

		#msj2 {
			background-color: #953033;
			color: White;
			-o-text-shadow:2px 1px 1px #333333;
			-moz-text-shadow:2px 1px 1px #333333;
			-webkit-text-shadow:2px 1px 1px #333333;
			text-shadow:2px 1px 1px #333333;
		}

		#msj3 {
			background-color: #4B9146;
			color: White;
			-o-text-shadow:2px 1px 1px #333333;
			-moz-text-shadow:2px 1px 1px #333333;
			-webkit-text-shadow:2px 1px 1px #333333;
			text-shadow:2px 1px 1px #333333;
		}

		.res_busqueda {
			font-weight: bold;
			font-size: 100%;
			background-color: yellow;
			color: black;
			-o-border-radius: 5px;
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;
			border-radius: 5px;
			-o-box-shadow: 3px 3px 4px #888;
			-moz-box-shadow: 3px 3px 4px #888;
			-webkit-box-shadow: 3px 3px 4px #888;
			box-shadow: 3px 3px 4px #888;
			padding: 0px 2px;
		}

		.resultados {
			margin-left: 20px;
		}

		.t_buscador {
			font-size:120%;
		}

		.f_buscador {
			color: grey;
		}
		</style>
		<?php	
		echo "<div id='contenedor'>";
		echo "<h2>Aplicaci&oacute;n de la EDP";
		echo "<small><a href='#' onclick='this.style.display=\"none\";window.print();'> (imprimir)</a></small>";
		echo "</h2>";
		
		if(mysql_num_rows($cambios_recientes)>0) {
			echo "<div class='notificacion'><h3>Cambios recientes (los elementos en gris han sido modificados y los blancos son nuevos):</h3>";
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
				echo "<h3>".$ord." ".$row['nombre'];
				if(numHijos($row['id'])>0) {
					if($nivel_visible<1)
						echo " <span class='pulsador' onclick='if(this.parentNode.nextSibling.style.display==\"none\") {this.parentNode.nextSibling.style.display=\"block\";this.innerHTML=\"&#9660;\";} else {this.parentNode.nextSibling.style.display=\"none\";this.innerHTML=\"&#9658;\";}'>&#9658;</span>";
					else
						echo " <span class='pulsador' onclick='if(this.parentNode.nextSibling.style.display==\"none\") {this.parentNode.nextSibling.style.display=\"block\";this.innerHTML=\"&#9660;\";} else {this.parentNode.nextSibling.style.display=\"none\";this.innerHTML=\"&#9658;\";}'>&#9660;</span>";
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
		echo "</div>";
		echo "</body></html>";
	} else {
		header ("Location: index.php?error=3");
	}
?>
