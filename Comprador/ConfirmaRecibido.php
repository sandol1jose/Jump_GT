<?php
    //COMPRADOR CONFIRMA DE RECIBIDO EL PRODUCTO
session_start();
    include '../conexion.php';

    $Transaccion = $_GET["Transaccion"];

    $sql = "UPDATE transaccion t SET t.f_estado = 12 WHERE t.id = '".$Transaccion."';";
    $sentencia = $base_de_datos->prepare($sql);
    $sentencia->execute(); 
    if($sentencia == true){
        //SE AGREGO CORRECTAMENTE
        $_SESSION["Alerta"] = "RecibidoOk";
        header('Location: ../Compras/DetalleCompra.php?Transaccion=' . $Transaccion); 
    }else{
        echo "ocurrio un error";
    }
?>