<?php
//AGREGANDO EL NUMERO DE GUIA Y FOTOGRAFIA DEL ENVIO
if (session_status() == PHP_SESSION_NONE) {
session_start();//inicio de sesion
}
	include '../conexion.php';
    include "config.php"; //ZONA HORARIA GUATEMALA

    $Modo = $_POST["Modo"];
    if($Modo == 1){
        //$ImgComprobante = base64_encode(file_get_contents($_FILES['Comprobante']['tmp_name']));
        $ImgComprobante = $_SESSION['IMAGEN_ENVIOGUIA'];
        unset($_SESSION['IMAGEN_ENVIOGUIA']);
    }else if($Modo == 2){
        $ImgComprobante = NULL;
    }
    $Numero = $_POST["Numero"];
    $Transaccion = $_POST["Transaccion"];
    $Fecha = date("Y-m-d h:i:s"); //FECHA DE REGISTRO DEL ENVIO

    $sentencia = $base_de_datos->prepare("CALL NewEnvioAJump(?,?,?,?,?);");
    $resultado = $sentencia->execute([$Numero, $ImgComprobante, $Transaccion, $Modo, $Fecha]);

	if($resultado == true){
		//SE AGREGO CORRECTAMENTE AL CLIENTE
		header('Location: ../Ventas/DetalleVenta.php?Transaccion=' . $Transaccion); //Agregamos el producto
	}else{
		echo "ocurrio un error";
	}
 ?>