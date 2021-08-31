<?php 

	include_once "../conexion.php";
	$idproducto = $_GET["idproducto"];

	$sql = "SELECT cadena FROM imagenproducto WHERE f_producto = " .$idproducto. " LIMIT 1;";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute();
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
	foreach ($registros as $registro) {
		$cadena = $registro["cadena"];
	}

	echo base64_decode($cadena);
 ?>