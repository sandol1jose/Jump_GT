<?php 
	include_once "../conexion.php";

	$Codigo = $_GET["Codigo"];

	$sql = "SELECT d.id, d.monto, d.fecha, d.razon  
	FROM depositocuentavirtual d
	WHERE d.f_transaccion = '".$Codigo."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
	$cont = count($registros);
	foreach ($registros as $registro) {
		$id = $registro["id"];
		$monto = $registro["monto"];
		$fecha = $registro["fecha"];
		$razon = $registro["razon"];
	}
 ?>

<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Pago</title>
	<link rel="stylesheet" type="text/css" href="../css/Master.css">
	<link rel="stylesheet" type="text/css" href="css/devolucion.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

</head>
<body>
<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Devolucion</h5>
		</div>

<?php if($cont > 0){ ?>
		<div class="SubTitulo SubTitulo2">
			<h1>Completada</h1>
		</div>

		<div class="Texto">
			<h2>Te hemos devuelto tu dinero</h2>
		</div>

		<div class="Datos">
			<div class="Tabla">
				<table class="table table-striped">
					<tr>
						<td>ID del pago</td>
						<td><?php echo $id ?></td>
					</tr>
					<tr>
						<td>Monto</td>
						<td>
						Q. <?php echo number_format($monto, 2); ?>
						<a href="../Cuenta/CuentaVirtual.php" class="btn btn-success">Retirar</a>
						</td>
					</tr>
					<tr>
						<td>Fecha</td>
						<td><?php echo $fecha ?></td>
					</tr>
					<tr>
						<td>Razon</td>
						<td><?php echo $razon ?></td>
					</tr>
				</table>
			</div>
		</div>

<?php }else{ ?>
<br><br><br><br>
<center>
<h3>Estamos trabajando en la devolución de tu pago</h3>
</center>
<br><br><br><br>
<?php } ?>

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