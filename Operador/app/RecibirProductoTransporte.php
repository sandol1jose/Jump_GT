<?php
session_start();//inicio de sesion
include '../../conexion.php';
include "../../app/config.php"; //ZONA HORARIA GUATEMALA
	if(!isset($_SESSION["Operador"])){
		header('Location: index.php'); //envia a la página de inicio.
	}

    $usuarioOperador = $_SESSION["Operador"]["usuario"];
    $fecha = date("Y-m-d h:i:s");
    $Transaccion = $_POST["transaccion"];
	$CobroPorEnvio = NULL;
	if(isset($_POST["CobroPorEnvio"])) $CobroPorEnvio = $_POST["CobroPorEnvio"];
    
    $sentencia = $base_de_datos->prepare("CALL RecibirProducto(?,?,?,?);");
	$resultado = $sentencia->execute([$usuarioOperador, $fecha, $Transaccion, $CobroPorEnvio]);
    if($resultado == true){
		//exito
		header('Location: ../GenerarComprobante.php?Transaccion=' . $Transaccion);
	}else{
		//error
		echo "Ocurrio un error";
	}
?>