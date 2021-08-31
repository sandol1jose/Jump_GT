<?php
session_start();
	include_once "../conexion.php";
	include "../app/app_registro.php";

	$Transaccion = $_GET["Transaccion"];

	$sql = "SELECT ROUND((pro.precio -((df.comision + df.envioacomprador + df.envioajump + df.IVA)/2)), 2)  Total, 
	cb.numerodecuenta, b.nombrebanco, df.precioproducto 
	FROM detallefactura df
	JOIN transaccion t ON df.f_transaccion = t.id
	JOIN cliente c ON c.id = t.f_vendedor
	JOIN producto pro ON pro.f_transaccion = t.id 
	JOIN cuentabancaria cb ON cb.f_cliente = c.id 
	JOIN banco b ON cb.f_banco = b.id
	WHERE df.f_transaccion = '".$Transaccion."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

	foreach ($registros as $registro) {
		$Total = $registro["Total"];
		$cuentabancaria = $registro["numerodecuenta"];
		$nombrebanco = $registro["nombrebanco"];
	}
?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Datos del pago al vendedor</title>
	<link rel="stylesheet" type="text/css" href="css/AgregarPago.css">

</head>
<body>
	<center>
	<h2>Datos del pago al vendedor</h2>
	<p>Por favor ingresa los datos del deposito al vendedor</p>
	<form method="POST" action="RegistrarPago.php">
		<h5>Debe depositar la cantidad de Q. <?php echo $Total ?> </h5>
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
		<!--
		Numero de boleta de pago:<br>
		<input type="text" name="Boleta" id="Boleta"><br>
		Monto:<br>
		<input type="text" name="Monto" id="Monto"><br>
		Banco:<br>
		<a id="SelectBanco">
			<?php BuscarBancos(); ?>
		</a><br><br>-->
		<input hidden type="text" name="tipopago" value="3"> <!-- 3 = Pago al Vendedor -->
		<input hidden type="text" name="Transaccion" value="<?php echo $_GET['Transaccion'] ?>">

		<input class="btn btn-secondary" type="submit" name="" value="Enviar">
	</form>
	</center>
</body> 
</html>