<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Verificacion exitosa</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../css/anuncio.css">
	<script src="../js/general.js"></script>
</head>
<body>

<script>
	alertsweetalert2('Accion exitosa', '', 'success'); 
</script>

<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Verificación</h5>
		</div>

		<div class="SubTitulo">
			<h2>Verificación <br> Exitosa</h2>
		</div>

		<div class="divText">
			<div class="Text">
				<p>Tu correo electrónico ahora está verificado, ya puedes ingresar a nuestro sistema</p>
			</div>
		</div>

		<div class="Imagen2 zoom">
			<img src="../imagenes/check1.gif" width="150px">
		</div>

		<form action="index.php">
			<div class="divBoton zoom">
				<input class="button" type="submit" name="" value="Ingresar">
			</div>
		</form>

		<div class="Logo zoom">
			<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
		</div>
	</div>
</div>
</body>
</html>