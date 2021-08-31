<?php
session_start();//inicio de sesion
	if(!isset($_SESSION["Cliente"])){
		header('Location: index.php'); //envia a la página de inicio.
	}
 ?>

 <?php include_once 'Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>JUMP</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<script src="js/general.js"></script>
	<script src="js/NuevaVisita.js"></script> <!-- Guarda la nueva visita a una página -->

	<style>
		.Color {
			background-color: #FF5B3D;
		}
	</style>
</head>
	<body>

<?php
	if(isset($_SESSION["Alerta"])){
		$Alerta = $_SESSION["Alerta"];
		if(strcmp($Alerta, 'inicioSesion') === 0){
			echo "<script> alertsweetalert2('Has iniciado correctamente', '', 'success'); </script>";
		}
		unset($_SESSION["Alerta"]);
	}
?>

		<div class="Base">
			<div class="Hijo">
				<br>
			<?php 
				if(isset($_SESSION["Cliente"])){?>
				<div class="Cuenta">
					<a style="font-size: 10px;" href="Cuenta"><img src="imagenes/Cuenta.png" alt="Cuenta" width="30px;" /><br>Cuenta</a>
				</div>
			<?php }else{ ?>

				<div class="Cuenta">
					<a href="Registro">Iniciar Sesión</a>
				</div>
				<?php } ?>

				<div class="Logotipo" style="padding-bottom: 10px;">
					<img class="imagen zoom" src="imagenes/JUMPLogo2.png">
				</div>

				<div class="AreaBotones">
					<form action="ingresoproducto.php">
						<button class="button zoom Color" >Vender</button><br>
					</form>
					<form action="Comprador/Vinculacion.php">
						<button class="button zoom Color" >Comprar</button>
					</form>
				</div>
				
				
				<div class="pie">
					<a>© Copyright. All Right Reserved</a><br>
					<a><b>Jump GT</b> ® - 2020</a><br>
					<a href="https://www.jumpgt.com">www.jumpgt.com</a>
				</div>
				
			</div>
		</div>
	</body>

</html>