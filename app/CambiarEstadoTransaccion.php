<?php 

	$Transaccion = $_POST['Transaccion'];
	$EstadoNuevo = $_POST['EstadoNuevo'];

	include_once "../conexion.php";

	$sql = "UPDATE transaccion SET f_estado = '".$EstadoNuevo."' WHERE id = '".$Transaccion."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute();
	if($sentencia){
		//Si se puedo realizar el cambio
		header('Location: ../index.php');
	}else{
		//No se puedo realizar el cambio
		echo "Ocurrio un error con el cambio de estado";
	}

?>