<?php
session_start();//inicio de sesion
	if(!isset($_SESSION["Cliente"])){
		header('Location: Registro/index.php'); //envia a la página de inicio.
	}
?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Vinculacion</title>
	<link rel="stylesheet" type="text/css" href="css/Vinculacion.css">
	<link rel="stylesheet" type="text/css" href="../css/Master.css">

	<script src="../js/general.js"></script>
	<script src="../js/NuevaVisita.js"></script> <!-- Guarda la nueva visita a una página -->
</head>
<body>

<?php
	if(isset($_SESSION["Alerta"])){
		$Alerta = $_SESSION['Alerta'];
		if (strcmp($Alerta, "TransaccionNoExist") === 0){
			echo "<script> alertsweetalert2('Número incorrecto', 'La transacción no existe o ya está en proceso', 'error'); </script>";
		}
		unset($_SESSION["Alerta"]);
	}
	unset($_SESSION["CodigoTransaccion"]); //Eliminamos la variable de CodigoTransaccion
?>


<div class="base">
	<div class="Hijo">
		<form method="POST" action="../app/vincular.php">
			<div class="Titulo">
				<h5>Vinculacion</h5>
			</div>

			<div class="SubTitulo3">
				<h5>Código de transacción</h5>
			</div>

			<div class="divInput zoom">
				<input autocomplete="off" class="Input" placeholder="0000" type="text" name="codigotransaccion" id="codigotransaccion" value="">
			</div>

			<div class="Foother">
				<p>Solicita el código a tu vendedor</p>
			</div>

			<center>
				<a href="https://youtu.be/1t3epItPaBs" target="_blank">Video instructivo</a><br>
			</center>

			<div class="divBoton zoom">
				<input class="button" type="submit" name="" value="Vincular">
			</div>
		</form>

		<div class="Logo zoom">
			<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
		</div>
	</div>
</div>

</body>
</html>