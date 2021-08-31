<?php
session_start();
	include '../conexion.php';
	include "../Sesiones/sesFactura.php";
	if(!isset($_SESSION['Transaccion']) || !isset($_SESSION['Cliente'])){
		header('Location: ../index.php');
	}

	$arrayTransaccion = $_SESSION['Transaccion'];
	$IDCompra = $arrayTransaccion["ID"];
	$Monto = $arrayTransaccion["Monto"];
	//echo $IDCompra;

	if(!isset($_SESSION['TransaccionFirebase'])){
		//Debemos hacer una consulta a la base de datos
		$sql = "SELECT t.f_comprador, t.f_vendedor FROM transaccion t WHERE t.id = '".$IDCompra."';";
		$sentencia = $base_de_datos->prepare($sql);
		$sentencia->execute(); 
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		foreach($registros as $reg){
			$IDComprador = $reg["f_comprador"];
			$IDVendedor = $reg["f_vendedor"];
			$Codigo = $IDCompra;
		}

		$arrayTransaccionFirebase = array(
			'IDComprador'=>$IDComprador,
			'IDVendedor'=>$IDVendedor,
			'IDTransaccion'=>$Codigo
		);
		$_SESSION['TransaccionFirebase'] = $arrayTransaccionFirebase;
	}
	
	$IDComprador = $_SESSION['TransaccionFirebase']['IDComprador'];
	$IDVendedor = $_SESSION['TransaccionFirebase']['IDVendedor'];
	$IDTransaccion = $_SESSION['TransaccionFirebase']['IDTransaccion'];

	//echo "IDCompra: " . $IDCompra . "<br>";
	$PrecioProducto = $Monto;
	//$Envioajump = 35;
	//$Envioacomprador = 15;
	//$EnvioTotal = round($Envioajump + $Envioacomprador, 2);

	$Envioajump = 0;
	$Envioacomprador = 0;
	$EnvioTotal = 0;

	$Comision = round(($PrecioProducto * 0.05), 2);
	$IVA = round(($Comision * 0.05), 2); //IVA del 5% por ser Pequeño Contribuyente
	$Mitad = ($EnvioTotal + $Comision + $IVA) / 2;
	$Total = round($PrecioProducto + $Mitad, 2);
	$Redondeo = ceil($Total);
	$DiferenciaRedondeo = round(($Redondeo - $Total), 2);

	//Creamos la sesion Factura
	CrearSesionFactura($PrecioProducto, $Comision, $Envioajump, $Envioacomprador, $IVA, $DiferenciaRedondeo);
?>
<?php include "../app/app_registro.php"; ?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Pagar</title>
	<link rel="stylesheet" type="text/css" href="../css/Master.css">
	<link rel="stylesheet" type="text/css" href="css/pagar.css">
	<link rel="stylesheet" type="text/css" href="../css/Less.css">
	<link rel="stylesheet" type="text/css" href="css/select.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>

<script>
	//Actualizamos el estado de la transaccion en FIREBASE
	var IDTrans = '<?php echo $IDTransaccion; ?>';
	var IDComprador = '<?php echo $IDComprador; ?>';
	var IDVendedor = '<?php echo $IDVendedor; ?>';

	var Estado = 3; //Aceptada por comprador
	UpdateTransaccion(IDTrans, IDComprador, Estado); //Actualizamos el estado de la transaccion del comprador
	UpdateTransaccion(IDTrans, IDVendedor, Estado); //Actualizamos el estado de la transaccion del vendedor
</script>



<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Datos del pago</h5>
		</div>

		<br>
		<center>
		<a>Detalles del total</a>
		</center>

		<table class="table table-striped">
			<tr>
				<td>Precio del producto</td>
				<td style="text-align: right;">Q. <?php echo $PrecioProducto ?></td>
			</tr>
			<tr>
				<td>Comisión</td>
				<td style="text-align: right;">Q. <?php echo $Comision/2 ?></td>
			</tr>
			<!--
			<tr>
				<td>Envio</td>
				<td style="text-align: right;">Q. <?php echo $EnvioTotal/2 ?></td>
			</tr>-->
			<tr>
				<td>IVA</td>
				<td style="text-align: right;">Q. <?php echo $IVA/2 ?></td>
			</tr>
			<tr>
				<td>Redondeo</td>
				<td style="text-align: right;">Q. <?php echo $DiferenciaRedondeo ?></td>
			</tr>
			<tr>
				<th>Total a pagar</th>
				<th style="text-align: right;"><spna style="font-size: 30px;">Q. <?php echo $Redondeo ?></span></th>
			</tr>
		</table>

		<div class="SubTitulo" style="padding-bottom: 0px;">
			<p>Por favor ingresa los datos de tu deposito, debes depositar la cantidad de: Q. <?php echo $Redondeo ?></p>
		</div>

		
		<div class="Tabla zoom" style="padding-top: 0px;">
			<div class="SubTitulo">Datos para el deposito</div>
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


		<form method="POST" action="../app/RegistrarPago.php">


	<div style="width: 98%">
		<div class="mb-3">
			<label class="form-label" style="font-size: 14px;">No. de boleta</label>
            <input placeholder="No. de boleta" type="text" class="form-control" name="Boleta" id="Boleta" autocomplete="off" required>
        </div>

		<label class="form-label" style="font-size: 14px;">Banco</label>
		<div style="padding-bottom: 18px;">
			<select class="form-select" id='banco' name='banco'>
				<option value="1">G&T Continental</option>
			</select>
		</div>

		<div class="mb-3">
			<label class="form-label" style="font-size: 14px;">Fecha del depósito</label>
			<input class="form-control" placeholder="Fecha" type="date" name="Fecha" id="Fecha" required>
			<label style="font-size: 12px;" >Ingresa la fecha en la que realizaste el depósito</label>
		</div>

		<div class="mb-3">
			<label class="form-label" style="font-size: 14px;">Hora del depósito</label>
            <input class="form-control" type="time" name="Hora" id="Hora" placeholder="Hora de deposito" required>
			<label style="font-size: 12px;" >Ingresa la hora en la que realizaste el depósito</label>
		</div>
	</div>

		<!--  
		<div class="Datos">
			<div class="grid-container">
				<div><img src="../imagenes/boleta.png" width="30px"></div>
				<div>
					<div class="mb-3">
                        <input placeholder="No. de boleta" type="text" class="form-control" name="Boleta" id="Boleta" autocomplete="off" required>
                    </div>

					
					<div class="Body">
						<div class="form">
						  <input type="text" name="Boleta" id="Boleta" autocomplete="off" required>
						  <label class="lbl-nombre">
						    <span class="text-nomb">
						      No. de boleta
						    </span>
						  </label>
						</div>
					</div>
				</div>

				<div><img src="../imagenes/banco.png" width="30px"></div>
				<div class="divSelect"><a id="SelectBanco"><?php BuscarBancos(); ?></a></div>
				<select class="form-select" id='banco' name='banco'>
                    <option value="Nuevo">G&T Continental</option>
                </select>
				
				<div class="divSelect">
					<select class='SelectVisual' id='banco' name='banco'>
						<option value="4">G&T Continental</option>
					</select>
				</div>

				<div><img src="../imagenes/banco.png" width="30px"></div>
				<div>
					<div class="mb-3">
                        <input class="form-control" placeholder="Fecha" type="date" name="Fecha" id="Fecha" required>
                    </div>
					 
					<div class="divCalendar">
						<input class="Calendar" placeholder="Fecha" type="date" name="Fecha" id="Fecha">
					</div>
				</div>

				<div><img src="../imagenes/banco.png" width="30px"></div>
				<div>
					<div class="mb-3">
                        <input class="form-control" type="time" name="Hora" id="Hora" placeholder="Hora de deposito" required>
                    </div>
					 
					<input type="time" name="Hora" id="Hora" placeholder="Hora de deposito"> 
				</div>
			</div>
		</div>
		-->
			<input hidden type="text" name="tipopago" value="1"> <!-- 1 = Pago del comprador a JUMP -->
			<input hidden type="text" name="Total" value="<?php echo $Redondeo ?>">

			<div class="divBoton zoom">
				<input type="submit" class="button" type="submit" value="Enviar">
			</div>

			<div class="Logo zoom">
				<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
			</div>
		
		</form>

	</div>
</div>
</body> 
</html>