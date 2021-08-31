<?php include "../app/app_registro.php"; ?>
<?php include_once '../Templates/Cabecera.php'; ?>


<?php 

	include_once "../conexion.php";

	$Transaccion = $_GET["Transaccion"];

	$sql = "SELECT p.monto, cb.numerodecuenta, b.nombrebanco 
	FROM pago p
	JOIN transaccion t ON p.f_transaccion = t.id 
	JOIN cliente c ON c.id = t.f_comprador
	JOIN cuentajump cuenta ON p.f_cuentajump = cuenta.id 
	JOIN banco b ON b.id = cuenta.f_banco
	JOIN cuentabancaria cb ON cb.f_cliente = c.id 
	WHERE p.f_transaccion ='".$Transaccion."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

	foreach ($registros as $registro) {
		$monto = $registro["monto"];
		$cuentabancaria = $registro["numerodecuenta"];
		$nombrebanco = $registro["nombrebanco"];
	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Reembolso al comprador</title>
	<link rel="stylesheet" type="text/css" href="css/AgregarPago.css">

</head>
<body>
	<center>
	<h2>Reembolso al comprador</h2>
	<p>Por favor ingresa los datos del deposito al f_compradorador</p>
	<form method="POST" action="RegistrarReembolso.php">
		<h5>Debe reembolsar la cantidad de Q. <?php echo $monto ?> </h5>
		<h6>Cuenta No. <?php echo $cuentabancaria ?> de <?php echo $nombrebanco ?> </h6>

		<table class="table table-dark TablaPago">
			<tr>
				<td>Numero de boleta de pago:</td>
				<td><input type="text" name="Boleta" id="Boleta" required></td>
			</tr>

			<tr>
				<td>Monto:</td>
				<td><input type="text" name="Monto" id="Monto" required></td>
			</tr>

			<tr>
				<td>Banco:</td>
				<td>		
					<a id="SelectBanco">
					<?php BuscarBancos(); ?>
					</a>	
				</td>
			</tr>
		</table>


		<input hidden type="text" name="tipopago" value="2"> <!-- 2 = Devolucion de JUMP al comprador -->
		<input hidden type="text" name="Transaccion" value="<?php echo $_GET['Transaccion'] ?>">

		<input class="btn btn-secondary" type="submit" name="" value="Enviar">
	</form>
	</center>
</body> 
</html>