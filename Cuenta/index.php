<?php
session_start();//inicio de sesion
	if(!isset($_SESSION["Cliente"])){
		header('Location: ../Registro/index.php'); //envia a la página de inicio.
	}
?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Mi cuenta</title>
	<link rel="stylesheet" type="text/css" href="../css/Master.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">

	<script src="../js/general.js"></script>
	<script src="../js/NuevaVisita.js"></script> <!-- Guarda la nueva visita a una página -->
</head>
<body>

<?php
	if(isset($_SESSION["Alerta"])){
		$Alerta = $_SESSION["Alerta"];
		if (strcmp($Alerta, "RetiroSolicitado") === 0){
			echo "<script> alertsweetalert2('Retiro solicitado con éxito', '', 'success'); </script>";
		}else if (strcmp($Alerta, "FondosInsuficientes") === 0){
			echo "<script> alertsweetalert2('Error', 'No tienes fondos suficientes', 'error'); </script>";
		}else if (strcmp($Alerta, "PagoAgregado") === 0){ //Enviado de ../app/PagoDevolucion.php
			echo "<script> alertsweetalert2('Pago agregado correctamente', '', 'success'); </script>";
		}
		unset($_SESSION["Alerta"]);
	}
?>

<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Mi cuenta</h5>
			<?php if($_SESSION["Cliente"]["Nombre"] != NULL){ ?>
				<h7><?php echo $_SESSION["Cliente"]["Nombre"]; ?></h7>
			<?php }else{ ?>
				<h7><?php echo $_SESSION["Cliente"]["Correo"]; ?></h7>
			<?php } ?>
		</div>

		<div class="Botones">
			<div class="grid-container">
				<div class="item1 zoom2" onclick="Redireccionar('../Ventas');">
					<div class="Img">
						<img src="../imagenes/Ventas.png" width="70px">
					</div>
					<div class="Letrero">
						ventas
					</div>
				</div>

				<div class="item2 zoom2" onclick="Redireccionar('../Compras');">
					<div class="Img">
						<img src="../imagenes/Compras.png" width="70px">
					</div>
					<div class="Letrero">
						compras
					</div>
				</div>
				
				<!--
				<div class="item3 zoom2">
					<div class="Img">
						<img src="../imagenes/MisDatos.png" width="70px">
					</div>
					<div class="Letrero">
						mis datos
					</div>
				</div> -->

				<div class="item4 zoom2" onclick="Redireccionar('../Manuales/Manual1.pdf');">
					<div class="Img">
						<img src="../imagenes/Manual.png" width="70px">
					</div>
					<div class="Letrero">
						manual
					</div>
				</div>

			</div>
		</div>


		<form action="LogOut.php">
			<div class="divBoton zoom">
				<input class="button" type="submit" name="" value="Cerrar Sesion">
			</div>
		</form>

		<div class="Logo zoom">
			<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
		</div>

	</div>
</div>
</body>
</html>

<script type="text/javascript">
	function Redireccionar(Ruta){
		window.location.href = Ruta;
	}
</script>


	<?php 
	/*
		$arrayCliente = $_SESSION["Cliente"];
		echo "IDCliente: " . $arrayCliente['IDCliente'] . "<br>";
		echo "Nombre: " . $arrayCliente['Nombre'] . "<br>";
		echo "DPI: " . $arrayCliente['DPI'] . "<br>";*/
	?>

	<!--
	<img src='../app/leerimagen.php?id=<?php echo $arrayCliente['IDCliente']; ?>' border='0' width="180px;"><br>-->