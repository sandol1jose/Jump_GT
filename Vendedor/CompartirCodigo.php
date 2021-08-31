<?php
session_start();//inicio de sesion
	if(!isset($_SESSION["Cliente"]) || !isset($_GET["Codigo"]) ){
		header('Location: ../Registro/index.php'); //envia a la página de inicio.
	}

	$CodigoTransaccion = $_GET["Codigo"];
	$IDCliente = $_SESSION["Cliente"]["IDCliente"];

	$IDVendedor = NULL;
	$IDTrans = NULL;
	if(isset($_SESSION['TransaccionFirebase'])){
		$IDVendedor = $_SESSION['TransaccionFirebase']['IDVendedor'];
		$IDTrans = $_SESSION['TransaccionFirebase']['IDTransaccion'];
		unset($_SESSION["TransaccionFirebase"]);
	}
?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Codigo de transaccion</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>

	<link rel="stylesheet" type="text/css" href="css/CompartirCodigo.css">
	
</head>
<body>

<script>
	//Agregamos la transaccion a FIREBASE
	<?php if($IDVendedor != NULL){ ?>
		var IDVendedor = '<?php echo $IDVendedor; ?>';
		var IDTrans = '<?php echo $IDTrans; ?>';
		InsertTransaccion(IDTrans, IDVendedor, 1); //Estado 1 (Ingreso)
	<?php } ?>
</script>


<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Codigo de transaccion</h5>
		</div>

		<div class="Imagen zoom">
			<img src="../imagenes/Cargando5.1.gif" width="170px">
		</div>

		<div class="divInput zoom">
			<input class="Input" disabled="" type="text" name="CodigoTransaccion" id="CodigoTransaccion" value="<?php echo $CodigoTransaccion ?>">
		</div>

		<div class="Foother">
			<p>Comparte este codigo con tu comprador</p>
		</div>

		<div class="Logo zoom">
			<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
		</div>
	</div>
</div>
</table>
</body>
</html>

<script type="text/javascript">
	function RevisarTransaccion(){
		var Codigo = document.getElementById("CodigoTransaccion").value;
		console.log(Codigo);
		if(Codigo != ''){
			$.ajax({
				type: "POST",
				url: "RevisarTransaccion.php",
				data: {'Codigo': Codigo},
				dataType: "html",
				beforeSend: function(){
				},
				error: function(){
					console.log("error petición ajax");
				},
				success: function(data){
					if(data == "1"){
						window.location.href = "VinculacionExito.php?Codigo=" +Codigo+ "";
					}else{
						console.log("Todavia no 2");
					}
				}
			});
		}else{
			console.log("Todavia no");
		}
	}

	setInterval('RevisarTransaccion()', 3000);
</script>