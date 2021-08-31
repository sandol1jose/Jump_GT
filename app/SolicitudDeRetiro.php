<?php
//AGREGANDO UNA NUEVA DIRECCION
session_start();
	include '../conexion.php';
    include "config.php"; //ZONA HORARIA GUATEMALA

    if(!isset($_POST["IDCuentaBancaria"]) || !isset($_POST["monto"]) || !isset($_POST["IDEstadoCuentaBancaria"])){
        echo "Llena todos los campos";
        exit();
    }

    $monto = $_POST["monto"];
    $fechaSolicitud = date("Y-m-d h:i:s");
    $IDEstCuenta = $_POST["IDEstadoCuentaBancaria"];
    $IDCuentaBancaria = $_POST["IDCuentaBancaria"];
    $saldo = $_POST["saldo"];

if($saldo >= $monto && $saldo != 0){
    $sentencia = $base_de_datos->prepare("CALL NuevoRetiro(?,?,?,?);");
    $resultado = $sentencia->execute([$monto, $fechaSolicitud, $IDEstCuenta, $IDCuentaBancaria]);

    if($resultado == true){
        //SE AGREGO CORRECTAMENTE
        $_SESSION["Alerta"] = "RetiroSolicitado";
        header('Location: ../Cuenta/index.php');
    }else{
        echo "ocurrio un error";
    }

}else{
//No tiene fondos suficientes
$_SESSION["Alerta"] = "FondosInsuficientes";
header('Location: ../Cuenta/index.php');
}
?>