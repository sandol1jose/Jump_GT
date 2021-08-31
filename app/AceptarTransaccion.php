<?php
	include '../Sesiones/sesTransaccion.php';
	include_once "../conexion.php";

	//Recaptcha es valido
	$Codigo = $_POST["Codigo"];
	$EstadoTransaccion = 3; //Aceptado por comprador
	$PrecioProducto = $_POST["Precio"];

	SesionTransaccion($Codigo, $PrecioProducto, $EstadoTransaccion);

	$sql = "UPDATE transaccion SET f_estado = '".$EstadoTransaccion."' WHERE id = '".$Codigo."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	if($sentencia){
		//echo "Cambio realizado";
		header('Location: ../Comprador/pagar.php'); //envia a la cuenta
	}else{
		//echo "Ocurrio un error";
	}
?>