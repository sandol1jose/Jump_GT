<?php 

	$Codigo = $_POST['Codigo'];

	include_once "../conexion.php";

	$sql = "SELECT f_estado FROM transaccion WHERE id = '".$Codigo."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute();
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
	$contar = count($registros);
	foreach ($registros as $registro) {
		$Estado = $registro["f_estado"];
		if($Estado == '5'){
			echo "1";
		}else{
			echo "0";
		}
	}

 ?>