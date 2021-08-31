<?php include_once '../Templates/Cabecera.php'; ?>

<?php

    $email = $_GET["email"];

?>

<!DOCTYPE html>
<html>
<head>
	<title>Email no verificado</title>

	<link rel="stylesheet" type="text/css" href="../css/anuncio.css">
	<link rel="stylesheet" type="text/css" href="../css/Master.css">
	<link rel="stylesheet" type="text/css" href="../css/Less.css">
</head>
<body>
<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Email no verificado</h5>
		</div>

		<div class="SubTitulo">
			<h2>Necesita <br> verificacion</h2>
		</div>

		<div class="divText">
			<div class="Text">
				<p>Tu correo electronico no ha sido verificado</p>
			</div>
		</div>
        
		<div id="DivimgError" class="Imagen2 zoom">
			<img src="../imagenes/ErorConfirm.gif" width="150px">
		</div>

		<form action="../app/ReenviarEmail.php" method="POST" >
			<div id="DivForm">
				<br>
				<center>
				<div class="Body">
					<div class="form">
						<input type="email" name="Email" id="Email" autocomplete="off" required value="<?php echo $email; ?>">
							<label class="lbl-nombre">
							<span class="text-nomb">
								Escribe tu correo
							</span>
						</label>
					</div>
				</div>
				
				<br>

				<a style="font-size: 13px;" href="Verificacion.php?email=<?php echo $email; ?>">-Tengo un código-</a>
				</center>

				<div class="divBoton zoom">
					<input class="button" type="submit" name="" value="Reenviar codigo" onclick="CambiarImagen();">
				</div>
			</div>
		</form>

		<div id="DivImg2" class="Imagen2 zoom" style="display: none;">
			<img src="../imagenes/Cargando6Recorte.gif" width="100px">
			<h6>cargando...</h6>
			<br><br>
		</div>

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
		$("#DivForm").hide();
		$("#DivimgError").hide();

		$("#DivImg2").show();
	}
</script>