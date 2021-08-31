<?php
session_start();
include_once '../Templates/Cabecera.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Inicio de Sesion</title>
	<link rel="stylesheet" type="text/css" href="../css/Master.css">
	<link rel="stylesheet" type="text/css" href="../css/Less.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">

	<script src="../js/general.js"></script>
	<script src="../js/NuevaVisita.js"></script> <!-- Guarda la nueva visita a una página -->
</head>

<body>
<?php
	if(isset($_SESSION["Alerta"])){
		$Alerta = $_SESSION["Alerta"];
		//echo = $Alerta;
		if (strcmp($Alerta, "passUpdate") === 0){
			echo "<script> alertsweetalert2('Contraseña recuperada', '', 'success'); </script>";
		}

		if (strcmp($Alerta, "passIncorrect") === 0){
			echo "<script> alertsweetalert2('Contraseña incorrecta', '', 'error'); </script>";
		}

		if (strcmp($Alerta, "EmailIsNotExist") === 0){
			echo "<script> alertsweetalert2('El correo ingresado no existe', '', 'error'); </script>";
		}

		if (strcmp($Alerta, "CodCaducate") === 0){
			echo "<script> alertsweetalert2('El código ha caducado', '', 'error'); </script>";
		}

		unset($_SESSION["Alerta"]);
	}
?>

<div class="base">
	<div class="Hijo">

	<div class="Titulo">
		<h5>Iniciar Sesión</h5>
	</div>

	<form method="POST" action="Logear.php">
		<div class="PadreImputs">
		<div class="Imputs">
			<div class="grid-container">
				<div><img src="../imagenes/Cuenta.png" width="30px;"></div>
				<div>
					<div class="Body">
						<div class="form">
							<input type="email" name="email" id="email" autocomplete="off" required>
								<label class="lbl-nombre">
								<span class="text-nomb">
									usarname@example.com
								</span>
							</label>
						</div>
					</div>
				</div>
				<div><img src="../imagenes/contrasenia.png" width="30px;"></div>  
				<div>
					<div class="Body">
						<div class="form">
							<input type="password" name="password" id="password" autocomplete="off" required>
								<label class="lbl-nombre">
								<span class="text-nomb">
									********************
								</span>
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>

	<div style="text-align: center;">
		<a style="font-size: 14px;"  class="Vinculo" href="RecuperarPass.php"> Olvidaste tu contraseña?</a>
	</div>

			<div class="divBoton zoom">
				<input class="button" type="submit" name="enviar" value="Ingresar">
			</div>
	</form>
	
	<div style="text-align: center;">
		<a class="Vinculo" href="registro.php">- Registrarse -</a>
	</div>


	<div class="Logo zoom">
		<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
	</div>

	</div>
</div>
</body>
</html>