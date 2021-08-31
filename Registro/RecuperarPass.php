<?php
session_start();
include_once '../Templates/Cabecera.php';?>

<!DOCTYPE html>
<html>
<head>
	<title>Recuperara password</title>
	<link rel="stylesheet" type="text/css" href="../css/anuncio.css">
	<link rel="stylesheet" type="text/css" href="../css/Master.css">
	<link rel="stylesheet" type="text/css" href="../css/Less.css">
	<script src="../js/general.js"></script>
</head>
<body>

<?php
	if(isset($_SESSION["Alerta"])){
		$Alerta = $_SESSION["Alerta"];
		if (strcmp($Alerta, "MailNoExist") === 0){
			echo "<script> alertsweetalert2('El correo no está registrado', '', 'error'); </script>";
		}
		unset($_SESSION["Alerta"]);
	}
?>


<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Recuperar contraseña</h5>
		</div>

		<div class="SubTitulo">
			<h2>Recuperacion</h2>
		</div>

		<div class="divText">
			<div class="Text">
				<p>Enviaremos un codigo a tu correo:</p>
			</div>
		</div>
        

		<div id="DivImg1" class="Imagen2 zoom">
			<img src="../imagenes/jingle-keys.gif" width="150px">
		</div>
		
		<div id="DivImg2" class="Imagen2 zoom" style="display: none;">
			<img src="../imagenes/Cargando6Recorte.gif" width="150px">
			<h2>Cargando...</h2>
		</div>

		<form action="../app/RecuperarPass.php" method="POST" >
            <br><br>
			<center>
			<div id="DivImput" class="Body">
				<div class="form">
					<input type="email" name="Email" id="Email" autocomplete="off" required>
						<label class="lbl-nombre">
						<span class="text-nomb">
							Escribe tu correo
						</span>
					</label>
				</div>
			</div>
			<br>
			</center>
			<br>
			
			<div id="DivButton" class="divBoton zoom">
				<input class="button" type="submit" name="" value="Recuperar contraseña" onclick="CambiarImagen();">
			</div>
		</form>

		<div class="Logo zoom">
			<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
		</div>
	</div>
</div>
</body>
</html>



<script>
	function CambiarImagen(){
		console.log("Cambiando");
		$("#DivImput").hide();
		$("#DivButton").hide();
		$("#DivImg1").hide();
		$("#DivImg2").show();
	}
</script>