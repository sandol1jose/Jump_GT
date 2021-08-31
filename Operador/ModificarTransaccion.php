<?php

	$Transaccion = $_POST['Transaccion'];
	$EstadoNuevo = $_POST['EstadoNuevo'];
	/*
	if($Estado != 6){
		$Estado = $Estado + 1;//Siguiente estado
		if($Estado == 6){//Pero que no sea el estado 6 = Pago no correcto
			$Estado = $Estado + 1;
		}
	}*/

	include_once "../conexion.php";

	$sql = "UPDATE transaccion SET f_estado = '".$EstadoNuevo."' WHERE id = '".$Transaccion."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute();
	if($sentencia){
		//Si se puedo realizar el cambio
		echo "1";
		//header('Location: Transacciones.php');
	}else{
		//No se puedo realizar el cambio
		echo "0";
	}

?>