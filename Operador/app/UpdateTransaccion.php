<?php
include_once "../../conexion.php";

$MontoEsperado = $_POST["MontoEsperado"];
$Transaccion = $_POST["Transaccion"];

$sql = "SELECT SUM(p.montorevisado) SumatoriaMontoRevisado FROM pago p 
WHERE p.f_transaccion = '".$Transaccion."' AND (p.f_tipopago = 1 OR p.f_tipopago = 4);";
$sentencia = $base_de_datos->prepare($sql);
$sentencia->execute();
$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
foreach($registros as $reg){
    $Sumatoria = $reg["SumatoriaMontoRevisado"];
    $Estado = 0;
    if($MontoEsperado <= $Sumatoria){
        $Estado = 5; //TRANSACCION - PAGO CORRECTO
    }else{
        $Estado = 6; //TRANSACCION - PAGO NO CORRECTO
    }

    $sql = "UPDATE transaccion SET f_estado = '".$Estado."' WHERE id = '".$Transaccion."'";
    $sentencia = $base_de_datos->prepare($sql);
    $sentencia->execute();
    if($sentencia){
        //se actualizo correctamente
        echo "1";
    }else{
        //ocurrio un error
        echo "0";
    }
}
?>