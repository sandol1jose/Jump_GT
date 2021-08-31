<?php
session_start();//inicio de sesion
	include_once "../conexion.php";

	if(!isset($_SESSION['TransaccionFirebase']) || !isset($_SESSION['Cliente'])){
		header('Location: ../index.php');
	}

	$Codigo = $_SESSION['TransaccionFirebase'];
	$IDComprador = $_SESSION['Cliente']['IDCliente'];

	$sql = "SELECT CONCAT(c.nombres, ' ', c.apellidos) Vendedor, c.id IDVendedor, c.dpi, p.descripcion, p.precio, p.direccion, p.url, p.detalles 
	FROM transaccion t JOIN cliente c ON t.f_vendedor = c.id 
	JOIN producto p ON t.id = p.f_transaccion 
	WHERE t.id = '".$Codigo."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

	foreach ($registros as $registro) {
		$IDVendedor = $registro["IDVendedor"];
		$Vendedor = $registro["Vendedor"];
		$dpi = $registro["dpi"];
		$descripcion = $registro["descripcion"];
		$precio = $registro["precio"];
		$direccion = $registro["direccion"];
		$url = $registro["url"];
		$detalles = $registro["detalles"];
	}

	$sql2 = "SELECT i.cadena FROM imagenproducto i
		JOIN producto p ON p.id = i.f_producto
		WHERE p.f_transaccion = '".$Codigo."'";
	$sentencia2 = $base_de_datos->prepare($sql2);
	$sentencia2->execute(); 
	$registros2 = $sentencia2->fetchAll(PDO::FETCH_ASSOC);


?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Detalles de Transaccion</title>
	<link rel="stylesheet" type="text/css" href="../css/ingresoproducto.css">
	<link rel="stylesheet" type="text/css" href="../css/Less.css">
	<script src="../js/general.js"></script>
</head>
<body>

<?php
	if(isset($_SESSION["Alerta"])){
		$Alerta = $_SESSION["Alerta"];
		if (strcmp($Alerta, "DireExito") === 0){
			echo "<script> alertsweetalert2('Dirección agregada con éxito', '', 'success'); </script>";
		}
		unset($_SESSION["Alerta"]);
	}
?>

<script>
/*
	//Actualizamos el estado de la transaccion en FIREBASE
	var IDTrans = '<?php echo $Codigo; ?>';
	var IDComprador = '<?php echo $IDComprador; ?>';
	var IDVendedor = '<?php echo $IDVendedor; ?>';

	var Estado = 2; //Vinculada
	InsertTransaccion(IDTrans, IDComprador, Estado); //Insertamos la nueva transaccion para el comprador
	UpdateTransaccion(IDTrans, IDVendedor, Estado); //Actualizamos el estado de la transaccion del vendedor
	
	<?php /*
		$arrayTransaccionFirebase = array(
			'IDComprador'=>$IDComprador,
			'IDVendedor'=>$IDVendedor,
			'IDTransaccion'=>$Codigo
		);
		$_SESSION['TransaccionFirebase'] = $arrayTransaccionFirebase;*/
	?>
</script>


<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Detalles de transacción</h5>
		</div>

		<form method="POST" action="DetallesDeProducto.php">
			<div class="Campos">
				<div class="grid-container">
					<div class="item1"><img class="zoom" src="../imagenes/vendedor.png" width="40px"></div>
					<div class="item2">
				    	<span><?php echo $Vendedor ?></span>
					</div>
					<div class="item3"><img class="zoom" src="../imagenes/Descripcion.png" width="40px"></div>
					<div class="item4">
				        <span><a href="<?php echo $url ?>" target="_blank"><?php echo $descripcion ?></a></span>
					</div>

					<div class="item5"><img class="zoom" src="../imagenes/Precio.png" width="40px"></div>
					<div class="item6">
				        <span>Q. <?php echo $precio; ?></span>
					</div>

					<div class="item7"><img class="zoom" src="../imagenes/Ubicacion.png" width="40px"></div>
					<div class="item8">
				        <span><?php echo $direccion ?></span>
					</div>

					
					<div class="item9">
					<br>
<textarea id="detalles" name="detalles" rows="4" cols="35">
<?php echo $detalles ?>
</textarea>
					</div>
				</div>
			</div>
	

			<div class="Imagenes">
				<div class="Container2">
					<?php $Contador = 0; ?>
					<?php foreach ($registros2 as $registro2) { ?>
						<?php $src = 'data: jpg;base64,'.$registro2["cadena"]; ?>
						<?php $Contador = $Contador + 1; ?>
						<?php $Nombre = "Imagen" . $Contador; ?>
						<div class="<?php echo $Vendedor ?>">
							<?php echo '<img class="zoom" src="'.$src.'" width="50px">'; ?>
						</div>
					<?php } ?>
				</div>
			</div>
		
			<div class="divBoton zoom">
				<input class="button" type="submit" name="" value="Aceptar">
			</div>

			
			<input hidden type="text" name="Codigo" id="Codigo" value="<?php echo $Codigo ?>">
			<input hidden type="text" name="Precio" id="Precio" value="<?php echo $precio ?>">

			<div class="Logo zoom">
				<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
			</div>
		</form>
		

	</div>
</div>

<!--
	<center>
	<h1>Detalles de Transaccion</h1>
	<form method="POST" action="../app/AceptarTransaccion.php">
		Nombre Vendedor:<br>
		<input type="text" name="" value="<?php echo $Nombre ?>"><br>
		DPI Vendedor:<br>
		<input type="text" name="" value="<?php echo $dpi ?>"><br>
		Codigo de transaccion:<br>
		<input type="text" name="Codigo" id="Codigo" value="<?php echo $Codigo ?>"><br>

		<h2>Detalles del producto</h2>
		Descripcion:<br>
		<input type="text" name="" value="<?php echo $descripcion ?>"><br>
		Precio:<br>
		<input type="text" name="Precio" id="Precio" value="<?php echo $precio + 100 ?>">
		Direccion:<br>
		<input type="text" name="" value="<?php echo $direccion ?>"><br>
		<input type="submit" name="" value="Pagar">
	</form>
	</center>-->
</body>
</html>