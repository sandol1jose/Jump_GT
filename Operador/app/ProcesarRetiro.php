<?php
include "../../conexion.php";
include "../../app/config.php"; //ZONA HORARIA GUATEMALA

$boleta = $_POST["boleta"];
$fechaDeposito = $_POST["fechaDeposito"];
$IDRetiro = $_POST["IDRetiro"];
$IDEstadodecuenta = $_POST["IDEstadodecuenta"];
$MontoRetiro = $_POST["MontoRetiro"];

$sentencia = $base_de_datos->prepare("CALL ProcesarRetiro(?,?,?,?,?);");
$resultado = $sentencia->execute([$boleta, $fechaDeposito, $IDRetiro, $IDEstadodecuenta, $MontoRetiro]);
if($resultado == true){
    //exito
    //echo "Se agrego correctamente";
    header('Location: ../SolicitudRetiros.php');
}else{
    //error
    echo "Ocurrio un error";
}
    
/*
echo "boleta: " . $boleta . "<br>";
echo "fechaDeposito: " . $fechaDeposito . "<br>";
echo "IDRetiro: " . $IDRetiro . "<br>";
echo "IDEstadodecuenta: " . $IDEstadodecuenta . "<br>";
echo "MontoRetiro: " . $MontoRetiro . "<br>";*/

?>