<?php
session_start();

	if(!isset($_SESSION['Cliente'])  || !isset($_SESSION['TransaccionFirebase'])){
		header('Location: ../index.php');
	}

	$IDComprador = $_SESSION['TransaccionFirebase']['IDComprador'];
	$IDVendedor = $_SESSION['TransaccionFirebase']['IDVendedor'];
	$IDTransaccion = $_SESSION['TransaccionFirebase']['IDTransaccion'];
?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Pago Completado</title>
	<link rel="stylesheet" type="text/css" href="../Vendedor/css/CompartirCodigo.css">
	<link rel="stylesheet" type="text/css" href="../Vendedor/css/VinculacionExito.css">

</head>
<body>

<script>
	//Actualizamos el estado de la transaccion en FIREBASE
	var IDTrans = '<?php echo $IDTransaccion; ?>';
	var IDComprador = '<?php echo $IDComprador; ?>';
	var IDVendedor = '<?php echo $IDVendedor; ?>';

	var Estado = 4; //Revision de pago
	UpdateTransaccion(IDTrans, IDComprador, Estado); //Actualizamos el estado de la transaccion del comprador
	UpdateTransaccion(IDTrans, IDVendedor, Estado); //Actualizamos el estado de la transaccion del vendedor
</script>


<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Pago Completado</h5>
		</div>

		<div class="SubTitulo">
			<h2>Completaste la <br> compra</h2>
		</div>

		<div class="divText">
			<div class="Text">
				<p>Si todo esta bien, recibiras el producto en los proximos días</p>
			</div>
		</div>

		<div class="Imagen2 zoom">
			<img src="../imagenes/check.png" width="50px">
		</div>

		<form action="../index.php">
			<div class="divBoton zoom">
				<input class="button" type="submit" name="" value="Concluir">
			</div>
		</form>

		<div class="Logo zoom">
			<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
		</div>
	</div>
</div>
</body>
</html>