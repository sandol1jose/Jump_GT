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

	$sql = "SELECT d.numeroguia, d.imagen, d.fechaenvio 
    FROM devolucionproducto d
    WHERE d.f_transaccion = '".$Transaccion."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    foreach($registros as  $Reg){
        $numeroguia = $Reg["numeroguia"];
        $imagen = $Reg["imagen"];
        $fechaenvio = $Reg["fechaenvio"];
    }
 ?>


<?php include "../app/app_registro.php"; ?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Ver Devolucion</title>
	<link rel="stylesheet" type="text/css" href="../css/Master.css">
	<link rel="stylesheet" type="text/css" href="../css/Less.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

</head>
<body>
<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Devolución de tu producto</h5>
		</div>

        <br>
		<center>
			<a>Detalles de la devolución</a>
		</center>

		<table class="table table-striped">
			<tr>
				<th>Número de guia:</th>
				<td style="text-align: right;"><?php echo $numeroguia; ?></td>
			</tr>

			<tr>
				<th>Fecha de envío:</th>
				<td style="text-align: right;"><?php echo date_format(date_create($fechaenvio), 'd/m/Y H:i A'); ?></td>
			</tr>
		</table>

		<div>
			<p>Tu producto ya fue enviado</p>
		</div>

<center>	

        <div style="padding-top: 0px;">
            <div class="SubTitulo" style="padding-top: 0px;">Imagen</div>
            <div id="DivImagen">
                <?php $src = 'data: jpg;base64,'. $imagen; ?>
                <?php echo '<img id="image"  src="'.$src.'" height="200px;" >'; ?><br>
            </div>
        </div>
        <br>

            

        <a href="DetalleVenta.php?Transaccion=<?php echo $Transaccion; ?>" style="text-decoration: none;">
            <button class="button zoom">Aceptar</button>
        </a> 
        


        <br><br>
        <div class="Logo zoom">
            <a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
        </div>
</center>



	</div>
</div>

</body> 
</html>