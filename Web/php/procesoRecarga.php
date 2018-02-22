<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.css">
<script type="text/javascript" src="../js/jquery.min.js"></script>
	<title>Document</title>
</head>
<body>
	
</body>
</html>
<?php
	require ("recargaATC.php");
	require "claseSesion.php";

$sesion = new Sesion();
if ($sesion->estadoLogin()==true) {
$datosUsuario=$sesion->datosUsuario();
  $usuarioID=$datosUsuario[0];
  $empresaID=$datosUsuario[1];
  $permisoID=$datosUsuario[2];
	
	//Recibe los datos para trabajar correctamente
	$inicial = $_POST["digitos"];
	$numero = $_POST["numero"];
	
	//Checa si el numero existe en la base de datos (la validacion se hace con y sin cliente)
	if ($permisoID == 2)
	{
		$bandera = consultarNumero($numero, $usuarioID);
	}
	else
	{
		$valor = consultarNumeroCliente($numero);
	}
	
	if(empty($bandera) && $permisoID == 2)
	{
		echo "<script language=\"JavaScript\">swal('Error...','¡Estimado cliente, el número $numero no existe en la base de datos!','error');";
		echo "document.getElementById('digitos').value = '';";
		echo "document.getElementById('numero').value = '';</script>";		
		exit;
	}
	else
	{
		if ($permisoID == 2)
			$idCliente = $usuarioID;
		else
			$idCliente = $valor;
	}
	if (empty($valor) && $permisoID == 1) {
		echo "<script language=\"JavaScript\">swal('Error...','¡Estimado cliente, el número $numero no existe en la base de datos!','error');";
		echo "document.getElementById('digitos').value = '';";
		echo "document.getElementById('numero').value = '';</script>";
		exit;
	}
	
	//Checa si el cliente está activo
	$cliente = sacarClienteInactivo($idCliente);
	if(!empty($cliente))
	{
		echo "<script language=\"JavaScript\">swal('Error...','¡Estimado cliente, el cliente $cliente está inactivo!','error');";
		echo "document.getElementById('digitos').value = '';";
		echo "document.getElementById('numero').value = '';</script>";
		exit;
	}
	
	//Checa si ya se le hizo recarga al numero con anterioridad
	$existente = checarActivo($numero);
	
	if ($existente)
	{
		echo "<script language=\"JavaScript\">swal('Error...','¡Estimado cliente, el número $numero ya fue activado!','error');";
		echo "document.getElementById('digitos').value = '';";
		echo "document.getElementById('numero').value = '';</script>";
		exit;
	}
	
	//Saca la compañia y el monto a recargar
	$monto = sacarMonto($numero);
	$compania = sacarCompania($numero);
	
	//Si la compañia es distinta a TELCEL compara que la fecha no haya pasado los 29 dias
	if ($compania != "TELCEL")
	{
		//Saca la fecha en la cual se registró el chip
		$fechaInicial = sacarFecha($numero);
		
		$fechaFinal = date("Y-m-d");
		
		//Saca los días transcurridos
		$dias = dias_transcurridos($fechaInicial, $fechaFinal);
		if ($dias > 29)
		{
			switch($compania)
			{
				case "MOVISTAR":
					$monto = 40;
					break;
					
				case "AT&T": case "UNEFON":
					$monto = 50;
					break;
					
				default:
					$monto = 30;
			}
			
		}
	}
	
	//Saca el id del producto de la compañia de recarga
	$idProducto = sacarIdProducto($compania, $monto);
	
	//id de prueba (QUITAR DESPUES DE PROBAR)
	//$idProducto = 100;
	
	//Saca el ultimo folio de la transaccion(si no existe genera el primero)
	$claveCliente = sacarClaveCliente($idCliente);
	$folio = sacarFolio();
	
	if (empty($folio))
		$folio = primerFolio($claveCliente);
	else
	{
		$folio = folioNuevo($folio, $claveCliente);
	}
	
	//Realiza la recarga
	$resultado = recargarSaldo($numero, $idProducto, $folio);
	
	if ($resultado[0] != "0")
	{
		//Checa si no se trata de una excepcion
		$idExcepcion = verificarExcepcion($numero);
		
		if (empty($idExcepcion))
		{
			$idNumero = sacarIDNumero($numero);
			insertarActivado($idNumero, $resultado[0], $folio, $monto);
		}
		else
		{
			insertarExcepcionHistorial($monto, $idExcepcion);
			$folio = "EXCEP/00".$idExcepcion."/".$monto;
		}
		
		echo "<script language=\"JavaScript\">swal('Proceso exitoso.','¡Recarga al numero $numero hecha de manera correcta. Guarde su folio $folio para cualquier aclaración.!','success');";
		echo "document.getElementById('digitos').value = '';";
		echo "document.getElementById('numero').value = '';</script>";
	}
	else
	{
		echo "<script language=\"JavaScript\">swal('Error...','¡Estimado cliente, $resultado[1]. Error al activar $numero\!','error');";
		echo "document.getElementById('digitos').value = '';";
		echo "document.getElementById('numero').value = '';</script>";
	}
	} else {
    header("location:index");
}
?>