<?php
session_start();//inicio de sesion
include '../../conexion.php';
include "../../app/config.php"; //ZONA HORARIA GUATEMALA

if(isset($_POST["monto"])){

$monto = $_POST["monto"];
$fecha = date("Y-m-d h:i:s");
$razon = $_POST["razon"];
$usuarioOperador = $_SESSION["Operador"]["usuario"];
$transaccion = $_POST["transaccion"];

$sentencia = $base_de_datos->prepare("CALL DevolverPago(?,?,?,?,?);");
$resultado = $sentencia->execute([$monto, $fecha, $razon, $usuarioOperador, $transaccion]);
if($resultado == true){
    //exito
    echo "Se agrego correctamente";
    //header('Location: ../GenerarComprobante.php?Transaccion=' . $Transaccion);
}else{
    //error
    echo "Ocurrio un error";
}
/*
echo "monto: " . $monto . "<br>";
echo "fecha: " . $fecha . "<br>";
echo "razon: " . $razon . "<br>";
echo "usuarioOperador: " . $usuarioOperador . "<br>";
echo "transaccion: " . $transaccion . "<br>";*/
}else{
    echo "Ocurrio un error";
}
?>