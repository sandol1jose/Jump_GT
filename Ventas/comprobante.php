<?php
session_start();//inicio de sesion
	if(!isset($_SESSION["Cliente"])){
		header('Location: ../Registro/index.php'); //envia a la página de inicio.
	}

	$Transaccion = $_GET["Transaccion"];

	include_once "../conexion.php";

	$sql = "SELECT p.id, p.monto, p.boleta, p.fechadeposito fecha, b.nombrebanco 
	FROM pago p 
	JOIN cuentajump cj ON cj.id = p.f_cuentajump 
	JOIN banco b ON cj.f_banco = b.id 
	WHERE f_transaccion = '".$Transaccion."' AND f_tipopago = 3";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
	foreach ($registros as $registro) {
		$idPago = $registro["id"];
		$monto = $registro["monto"];
		$boleta = $registro["boleta"];
		$fecha = $registro["fecha"];
		$nombrebanco = $registro["nombrebanco"];
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Comprobante</title>
</head>
<body>
	<h1>Comprobante</h1>
	ID del pago: <?php echo $idPago ?> <br>
	Fecha: <?php echo $fecha ?> <br>
	Monto: Q. <?php echo $monto ?> <br>
	Boleta: <?php echo $boleta ?> <br>
	Banco: <?php echo $nombrebanco ?> <br>
</body>
</html>