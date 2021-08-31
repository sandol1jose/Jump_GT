<?php
session_start();//inicio de sesion
	include '../conexion.php';
	include "config.php"; //ZONA HORARIA GUATEMALA
	
	//Detalles del deposito
    $Monto = $_POST["Monto"];
	$Boleta = $_POST["Boleta"];
	$FechaDeposito = $_POST["FechaDeposito"];
	//$FechaDeposito = $_POST["Fecha"] . " " . $_POST["Hora"]; //Fecha escrita en la boleta de pago
	$FechaRegistro = date("Y-m-d h:i:s"); //Fecha de cuando se esta guardando el pago
	$cuentajump = $_POST["cuentajump"];
    $Transaccion = $_POST['Transaccion'];
	$tipopago = $_POST["tipopago"];

	$sentencia = $base_de_datos->prepare("CALL PagoDevolucion(?,?,?,?,?,?,?);");
	$resultado = $sentencia->execute([$Monto, $Boleta, $FechaDeposito, $FechaRegistro, $cuentajump, $Transaccion, $tipopago]);
		
	if($resultado == true){
		//SE AGREGO CORRECTAMENTE AL CLIENTE
		//echo "Pago agregado correctamente";
        $_SESSION["Alerta"] = "PagoAgregado";
		header('Location: ../Cuenta/index.php');
	}else{
		echo "ocurrio un error";
	}
?>