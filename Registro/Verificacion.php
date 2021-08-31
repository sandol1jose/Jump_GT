<?php
session_start();
include "../app/app_registro.php";
?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Verificacion</title>
	<link rel="stylesheet" type="text/css" href="../css/registro.css">
	<link rel="stylesheet" type="text/css" href="css/select.css">

	<link rel="stylesheet" type="text/css" href="../css/Master.css">
	<link rel="stylesheet" type="text/css" href="../css/Less.css">
	<script src="../js/general.js"></script>

	<style>
		.divInput{
			text-align: center;
			font-size: 70px;
			height: 120px;
		}

		.Input{
			width: 290px;
			border: none;
			outline:none;
			background-color: transparent;
			text-align: center;
			border-bottom: 2px solid #616161;
			font-weight: bold;
		}
	</style>
</head>
<body>

<?php
	$Correo = $_GET['email'];
	if(isset($_SESSION["Alerta"])){
		$Alerta = $_SESSION["Alerta"];
		if(strcmp($Alerta, 'CodigoIncorrecto') === 0){
			echo "<script> alertsweetalert2('Error', 'Código incorrecto', 'error'); </script>";
		}
		unset($_SESSION["Alerta"]);
	}
?>

<div class="base">
	<div class="Hijo">
	<div class="Titulo">
		<h5>Verificacion</h5>
	</div>

    <div class="SubTitulo">
		<h4>Confirma tu correo</h4>
		<p>Enviamos un código a tu correo electrónico</p>	
	</div>

	<div class="Texto">
		<h6>Por favor ingresa el codigo enviado a <?php echo $Correo; ?> para verificarlo</h6>
	</div>

    <br>
		<form action="../app/VerificarEmail.php" method="POST">

			<div class="divInput zoom">
				<input style="text-transform:uppercase" autocomplete="off" class="Input" placeholder="0000" type="text" name="codigo" id="codigo">
			</div>

			<input hidden type="text" name="email" id="email" value="<?php echo $Correo; ?>">
			<div id="DivButton" class="divBoton zoom">
				<input class="button" type="submit" name="" value="Aceptar">
			</div>

		</form>

		<br><br>
		<div class="Logo zoom">
			<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
		</div>
	</div>

</div>
</body>
</html>