<?php
session_start();
include_once "../../conexion.php";
    $Numeroguia = $_POST["Numeroguia"];
	$Imagen = $_SESSION['IMAGEN_ENVIOGUIA'];
	unset($_SESSION["IMAGEN_ENVIOGUIA"]); //Borramos la sesion
    $Fecha = $_POST["Fecha"];
    $IDdevolucionproducto = $_POST["IDdevolucionproducto"];

	$sentencia = $base_de_datos->prepare("CALL UpdateDevolProducto(?,?,?,?);");
	$resultado = $sentencia->execute([$Numeroguia, $Imagen, $Fecha, $IDdevolucionproducto]);
	if($sentencia){
		//echo "Cambio realizado";
		header('Location: ../Transacciones.php'); //envia a la cuenta
	}else{
		echo "Ocurrio un error";
	}
?>