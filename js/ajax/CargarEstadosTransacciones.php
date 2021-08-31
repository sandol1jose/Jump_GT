<?php
if (session_status() == PHP_SESSION_NONE) {
session_start();//inicio de sesion
}
    /*Cargamos los estados actuales de las transacciones
    Servira para comparar con firebese cuando cambie de estado y no me notifique de todas las transacciones
    si no solo de la que cambio*/
    include_once "../../conexion.php";
    $IdClie = $_POST["IDCliente"];
    
    $sql2 = "SELECT t.id, t.f_estado FROM transaccion t
    WHERE t.f_comprador = '".$IdClie."' OR t.f_vendedor = '".$IdClie."';";
    $sentencia2 = $base_de_datos->prepare($sql2);
    $sentencia2->execute();
    $registros2 = $sentencia2->fetchAll(PDO::FETCH_ASSOC);
    $contar2 = count($registros2);
    if($contar2 > 0){
        foreach($registros2 as $reg){
            $IDtrans = $reg['id'];
            $estado = $reg['f_estado'];
            $_SESSION['ESTADO_TRANSACCIONES'][$IDtrans] = $estado;
        }
        echo json_encode($_SESSION['ESTADO_TRANSACCIONES']);
    }else{
        echo '0'; //Error
    }
?>