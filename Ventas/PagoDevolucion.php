<?php 
	include "../Sesiones/sesFactura.php";
    include_once "../conexion.php";

	if(!isset($_GET["Transaccion"])){
		exit();
	}

    $Transaccion = $_GET["Transaccion"];

	//Consultando si ya se pago algo pero hay pendiente
	$sql2 = "SELECT SUM(p.montorevisado) MontoRevisado FROM pago p 
	WHERE p.f_transaccion = '".$Transaccion."' AND (p.f_tipopago = 6 OR p.f_tipopago = 5);";
	$sentencia2 = $base_de_datos->prepare($sql2);
	$sentencia2->execute(); 
	$registros2 = $sentencia2->fetchAll(PDO::FETCH_ASSOC);
	$MontoRevisado = 0;
	
    foreach($registros2 as  $Reg){
        $MontoRevisado = $Reg["MontoRevisado"];
    }

	$sql = "SELECT d.reembolsoporenvioajump, d.reembolsocomision 
    FROM devolucionproducto d
    WHERE d.f_transaccion = '".$Transaccion."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    foreach($registros as  $Reg){
        $reembolsoporenvioajump = $Reg["reembolsoporenvioajump"];
        $reembolsocomision = $Reg["reembolsocomision"];
    }
	$Total = $reembolsoporenvioajump + $reembolsocomision;
	$TotalRedondeado = ceil($Total);
	$DiferenciaRedondeo = round(($TotalRedondeado - $Total), 2);

	if($MontoRevisado <= $TotalRedondeado){
		$TotalRedondeado = $TotalRedondeado - $MontoRevisado;
	}


	if($TotalRedondeado == 0){
		header("Location: VerDevolucionProducto.php?Transaccion=" . $Transaccion);
	}
 ?>


<?php include "../app/app_registro.php"; ?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Pago por devolución</title>
	<link rel="stylesheet" type="text/css" href="../css/Master.css">
	<link rel="stylesheet" type="text/css" href="../css/Less.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

</head>
<body>
<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Pago por devolución</h5>
		</div>

<?php if($TotalRedondeado > 0){ ?>

		<?php if($TotalRedondeado > 0 && $MontoRevisado > 0){ ?>
			<br>
			<center>
			<h5>No depositaste lo acordado</h5>
			<p style="font-size: 12px;">Por favor deposita el resto para poder devolverte tu producto</p>
			</center>
		<?php } ?>

		<center>
			<a>Detalles del total</a>
		</center>

		<table class="table table-striped">
			<tr>
				<th>Envio cobrado:</th>
				<td style="text-align: right;">Q. <?php echo number_format($reembolsoporenvioajump, 2) ?></td>
			</tr>

			<tr>
				<th>Daños y perjuicios:</th>
				<td style="text-align: right;">Q. <?php echo number_format($reembolsocomision, 2) ?></td>
			</tr>

			<tr>
				<th>Redondeo:</th>
				<td style="text-align: right;">Q. <?php echo number_format($DiferenciaRedondeo, 2) ?></td>
			</tr>

			<?php if($TotalRedondeado > 0 && $MontoRevisado > 0){ ?>
			<tr>
				<th style="color: red;">(-) Pagos anteriores:</th>
				<td style="text-align: right; color: red;">(-) Q. <?php echo number_format($MontoRevisado, 2) ?></td>
			</tr>
			<?php } ?>
            
			<tr>
				<th>Total a depositar</th>
				<th style="text-align: right;"><spna style="font-size: 30px;">Q. <?php echo number_format($TotalRedondeado,2); ?></span></th>
			</tr>
		</table>

		<div>
			<p>Para devolverte tu producto, debes depositar la cantidad de: Q. <?php echo number_format($TotalRedondeado,2); ?></p>
		</div>
		
		<div style="padding-top: 0px;">
			<div class="SubTitulo" style="padding-top: 0px;">Datos para el deposito</div>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Banco</th>
						<th>Cuenta</th>
					</tr>
				</thead>

				<tr>
					<td>G&T Continental</td>
					<td>086-0006170-2</td>
				</tr>
			</table>
		</div>

		<div class="SubTitulo">
			<p>A nombre de "MARS TECHNOLOGY"</p>
		</div>


	<form method="POST" action="../app/PagoDevolucion.php">

		<div style="width: 98%">
		<div class="mb-3">
			<label class="form-label" style="font-size: 14px;">No. de boleta</label>
            <input placeholder="No. de boleta" type="text" class="form-control" name="Boleta" id="Boleta" autocomplete="off" required>
        </div>

		<label class="form-label" style="font-size: 14px;">Banco</label>
		<div style="padding-bottom: 18px;">
			<select class="form-select" id='cuentajump' name='cuentajump'>
				<option value="1">G&T Continental</option>
			</select>
		</div>

		<div class="mb-3">
			<label class="form-label" style="font-size: 14px;">Fecha del depósito</label>
			<input class="form-control" placeholder="Fecha" type="datetime-local" name="FechaDeposito" id="FechaDeposito" required>
			<label style="font-size: 12px;" >Ingresa la fecha en la que realizaste el depósito</label>
		</div>

		</div>

            <input hidden type="text" name="tipopago" value="5"> <!-- 5 = Pago por devolucion -->
            <input hidden type="text" name="Transaccion" value="<?php echo $Transaccion ?>">
			<input hidden type="text" name="Transaccion" value="<?php echo $Transaccion ?>">
            <input hidden type="text" name="Monto" value="<?php echo $TotalRedondeado ?>">

			<div class="divBoton zoom">
				<input type="submit" class="button" type="submit" value="Enviar">
			</div>


		
	</form>

<?php }else{ ?>
	<center>
	<br>
	<h1>No tienes pagos pendientes</h1>
	<p>Pronto recibiras tu producto</p>
	</center>

<?php } ?>

<center>
	<div class="Logo zoom">
		<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
	</div>
</center>



	</div>
</div>

</body> 
</html>