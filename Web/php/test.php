<?php
	require("ConsultasMySQL.php");
	
	$respuesta = verificarExcepcion('4612578407');
	
	if (!empty($respuesta))
		echo $respuesta;
	else
		echo "No es excepcion";
?>