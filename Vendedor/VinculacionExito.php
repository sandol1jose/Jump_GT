<?php
session_start();//inicio de sesion
	if(!isset($_SESSION["Cliente"]) || !$_GET["Codigo"]){
		header('Location: ../Registro/index.php'); //envia a la página de inicio.
	}

	$CodigoTransaccion = $_GET["Codigo"];
?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Vinculación</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>

	<link rel="stylesheet" type="text/css" href="css/CompartirCodigo.css">
	<link rel="stylesheet" type="text/css" href="css/VinculacionExito.css">
</head>
<body>
<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Vinculación</h5>
		</div>

		<div class="SubTitulo">
			<h2>Vinculación <br> Exitosa</h2>
		</div>

		<div class="divText">
			<div class="Text">
				<p>Cuando tengamos el pago te notificaremos para que envies el producto</p>
			</div>
		</div>

		<div class="Imagen2 zoom">
			<img src="../imagenes/check.png" width="50px">
		</div>

		<form action="../index.php">
			<div class="divBoton zoom">
				<input class="button" type="submit" name="" value="Aceptar">
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
	function RevisarPago(){
		var Codigo = '<?php echo $CodigoTransaccion ?>';
		console.log(Codigo);
		if(Codigo != ''){
			$.ajax({
				type: "POST",
				url: "RevisarPago.php",
				data: {'Codigo': Codigo},
				dataType: "html",
				beforeSend: function(){
				},
				error: function(){
					console.log("error petición ajax");
				},
				success: function(data){
					if(data == "1"){
						window.location.href = "EnvioProducto.php?Codigo="+Codigo+"";
					}else{
						console.log("Todavia no 2");
					}
				}
			});
		}else{
			console.log("Todavia no");
		}
	}

	setInterval('RevisarPago()', 3000);
</script>