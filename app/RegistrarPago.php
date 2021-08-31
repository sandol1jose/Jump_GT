<?php
session_start();//inicio de sesion
	include '../conexion.php';
	include "config.php"; //ZONA HORARIA GUATEMALA
	
	$arrayTransaccion = $_SESSION['Transaccion'];
	$arrayFactura = $_SESSION['Factura'];
	
	//Detalles del deposito
	$Boleta = $_POST["Boleta"];
	$Total = $_POST["Total"];
	$Fecha = $_POST["Fecha"];
	$Hora = $_POST["Hora"];
	$FechaDeposito = $_POST["Fecha"] . " " . $_POST["Hora"]; //Fecha escrita en la boleta de pago
	$FechaRegistro = date("Y-m-d h:i:s"); //Fecha de cuando se esta guardando el pago
	$Banco = $_POST["banco"];
	$IDCompra = $arrayTransaccion["ID"];
	$tipopago = $_POST["tipopago"];

	//Datos de factura
	$PrecioProducto = $arrayFactura["PrecioProducto"];
	$Comision = $arrayFactura["Comision"];
	$Envioajump = $arrayFactura["Envioajump"];
	$Envioacomprador = $arrayFactura["Envioacomprador"];
	$IVA = $arrayFactura["IVA"];
	$Redondeo = $arrayFactura["Redondeo"];

	$sentencia = $base_de_datos->prepare("CALL GrabarPago(?,?,?,?,?,?,?,?,?,?,?,?);");
	$resultado = $sentencia->execute([$Total, $Boleta, $FechaDeposito, $FechaRegistro, $Banco, $IDCompra, $tipopago, $Comision, $Envioajump, $Envioacomprador, $IVA, $PrecioProducto]);
		
	if($resultado == true){
		//SE AGREGO CORRECTAMENTE AL CLIENTE
		//echo "Pago agregado correctamente";
		header('Location: ../Comprador/PagoCompletado.php');
	}else{
		echo "ocurrio un error";
	}
?>
