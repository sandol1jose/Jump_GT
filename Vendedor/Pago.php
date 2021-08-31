<?php 
	include_once "../conexion.php";

	$Codigo = $_GET["Codigo"];

	$sql = "SELECT t.id Transaccion, b.nombrebanco, pa.boleta, cb.numerodecuenta cuentavendedor, pa.monto, p.descripcion FROM transaccion t JOIN
	producto p ON t.id = p.f_transaccion
	JOIN pago pa ON pa.f_transaccion = t.id
	JOIN cliente c ON c.id = t.f_vendedor
	JOIN cuentabancaria cb ON cb.f_cliente = c.id 
	JOIN banco b ON cb.f_banco = b.id 
	WHERE pa.f_tipopago = 3 AND t.id = '".$Codigo."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

	$Transaccion;
	$nombrebanco;
	$boleta;
	$cuentavendedor;
	$precio;
	$descripcion;

	foreach ($registros as $registro) {
		$Transaccion = $registro["Transaccion"];
		$nombrebanco = $registro["nombrebanco"];
		$boleta = $registro["boleta"];
		$cuentavendedor = $registro["cuentavendedor"];
		$precio = $registro["monto"];
		$descripcion = $registro["descripcion"];
	}
 ?>

<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Pago</title>
	<link rel="stylesheet" type="text/css" href="../css/Master.css">
	<link rel="stylesheet" type="text/css" href="css/Pago.css">
</head>
<body>
<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Pago</h5>
		</div>

		<div class="SubTitulo SubTitulo2">
			<h1>Completado</h1>
		</div>

		<div class="Texto">
			<h2>Te hemos pagado</h2>
		</div>

		<div class="Datos">
			<div class="Tabla">
				<table>
					<tr>
						<td>Transaccion</td>
						<td><?php echo $Transaccion ?></td>
					</tr>
					<tr>
						<td>Banco</td>
						<td><?php echo $nombrebanco ?></td>
					</tr>
					<tr>
						<td>No. Boleta</td>
						<td><?php echo $boleta ?></td>
					</tr>
					<tr>
						<td>Cuenta de deposito</td>
						<td><?php echo $cuentavendedor ?></td>
					</tr>
					<tr>
						<td>Cantidad</td>
						<td>Q. <?php echo $precio ?></td>
					</tr>
					<tr>
						<td>Producto</td>
						<td><?php echo $descripcion ?></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="Imagen zoom">
			<img src="../imagenes/Monedas.png" width="50px">
		</div>

		<form action="../index.php">
			<div class="divBoton zoom">
				<input class="button" type="submit" name="" value="Jump">
			</div>
		</form>

	</div>
</div>
</body>
</html>