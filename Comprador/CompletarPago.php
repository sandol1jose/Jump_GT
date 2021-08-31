<?php 
	include "../Sesiones/sesFactura.php";
    include_once "../conexion.php";

    $Transaccion = $_GET["Transaccion"];

	$sql = "SELECT ROUND((d.precioproducto + (d.comision+ d.envioajump + d.envioacomprador+ d.IVA)/2),2) Total 
    FROM detallefactura d
    WHERE d.f_transaccion = '".$Transaccion."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    foreach($registros as  $Reg){
        $MontoEsperado = ceil($Reg["Total"]);
    }


	$sql = "SELECT p.montorevisado monto, p.boleta FROM pago p 
    WHERE (p.f_tipopago = 1 OR p.f_tipopago = 4) AND p.f_transaccion = '".$Transaccion."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros2 = $sentencia->fetchAll(PDO::FETCH_ASSOC);
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
<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Completar el pago</h5>
		</div>

		<br>
		<center>
		<a>Detalles del total</a>
		</center>

		<table>
			<tr>
				<td>Total esperado</td>
				<td style="text-align: right;">Q. <?php echo $MontoEsperado ?></td>
			</tr>


        <?php 
        $TotalSumado = 0;
        foreach($registros2 as  $Reg2){ 
            $TotalSumado = $Reg2["monto"] + $TotalSumado;
        ?>
			<tr>
				<td>Dep. <?php echo $Reg2["boleta"]; ?> </td>
				<td style="text-align: right; color: red;">- Q. <?php echo $Reg2["monto"] ?></td>
			</tr>
        <?php } 
            $Diferencia = $MontoEsperado - $TotalSumado;

        ?>
			<tr>
				<th>Total a depositar</th>
				<th style="text-align: right;"><spna style="font-size: 30px;">Q. <?php echo $Diferencia ?></span></th>
			</tr>
		</table>

        <?php if($TotalSumado > 0){ ?>

		<div class="SubTitulo">
			<p>Por favor ingresa los datos de tu deposito, debes depositar la cantidad de: Q. <?php echo $Diferencia ?></p>
		</div>

        <?php }else{ ?>
            <div class="SubTitulo" style="padding-bottom: 0px;">
			    <p>El numero de boleta no se pudo confirmar por favor deposita la cantidad de: Q. <?php echo $Diferencia ?></p>
		    </div>
        <?php } ?>
		
		<div class="Tabla zoom" style="padding-top: 0px;">
			<div class="SubTitulo">Datos para el deposito</div>
			<table>
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






	<form method="POST" action="../app/CompletarPago.php">

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

		<!--  
		<div class="Datos">
			<div class="grid-container">
				<div><img src="../imagenes/boleta.png" width="30px"></div>
				<div>
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
				<div class="divSelect">
					<select class='SelectVisual' id='banco' name='banco'>
						<option value="4">G&T Continental</option>
					</select>
				</div>

				<div><img src="../imagenes/banco.png" width="30px"></div>
				<div>
					<div class="divCalendar">
						<input class="Calendar" placeholder="Fecha" type="date" name="Fecha" id="Fecha">
					</div>
				</div>

				<div><img src="../imagenes/banco.png" width="30px"></div>
				<div><input type="time" name="Hora" id="Hora" placeholder="Hora de deposito"></div>
			</div>
		</div>
		-->

			<input hidden type="text" name="tipopago" value="4"> <!-- 4 = Complemento de pago -->
			<input hidden type="text" name="Transaccion" value="<?php echo $Transaccion ?>">
            <input hidden type="text" name="Monto" value="<?php echo $Diferencia ?>">

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