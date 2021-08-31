<?php
include_once "../../conexion.php";

$IDPago = $_POST["IDPago"];
$MontoVerificado = $_POST["MontoVerificado"];
$Estado = $_POST["Estado"];

$sql = "UPDATE pago p SET p.montorevisado = '".$MontoVerificado."', p.f_tipoestado = '".$Estado."'
WHERE p.id = '".$IDPago."';";
$sentencia = $base_de_datos->prepare($sql);
$sentencia->execute();
if($sentencia){
//se actualizo correctamente
echo "1";
}else{
//ocurrio un error
echo "0";
}
?>