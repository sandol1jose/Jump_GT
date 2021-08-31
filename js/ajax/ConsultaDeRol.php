<?php
	include_once "../../conexion.php";
	$idcliente = $_POST["idcliente"];
    $idtransaccion = $_POST["idtransaccion"];

	$sql = "SELECT t.f_comprador, t.f_vendedor FROM transaccion t WHERE t.id = '".$idtransaccion."';";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
	foreach ($registros as $registro) {
		$IDComprador = $registro["f_comprador"];
        $IDVendedor = $registro["f_vendedor"];
        if($IDVendedor == $idcliente){
            //Es Vendedor
            echo '1';
        }else if($IDComprador == $idcliente){
            //Es Comprador
            echo '2';
        }
	}
?>