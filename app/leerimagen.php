<?php
	include_once "../conexion.php";
	$id = $_GET["id"];

	$sql = "SELECT img.cadena FROM cliente c JOIN imagendpi img ON img.id = c.f_imagendpi WHERE c.id = '".$id."';";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
	$Imagen = '';
	foreach ($registros as $registro) {
		$Imagen = $registro["cadena"];
	}

	echo base64_decode($Imagen);
 ?>