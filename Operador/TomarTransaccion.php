<?php
session_start();//inicio de sesion
	if(!isset($_SESSION["Operador"])){
		header('Location: index.php'); //envia a la página de inicio.
	}
?>
<?php 
	$IDTransaccion = $_GET["Codigo"];

	include_once "../conexion.php";

	$sql = "SELECT t.id, t.fecha, p.url, p.descripcion, p.id idproducto, p.precio, p.detalles, pago.boleta, banco.nombrebanco, 
	p.direccion, Vende.id IDVendedor,  CONCAT(Vende.nombres, ' ', Vende.apellidos) Vendedor, 
	Compra.id IDComprador, CONCAT(Compra.nombres, ' ', Compra.apellidos) Comprador, e2.estado, e2.id IDEstado,
	DpiVendedor.cadena DpiVendedor, DpiComprador.cadena DpiComprador,
	df.comision, df.envioajump, df.envioacomprador, df.IVA 
	FROM transaccion t 
	JOIN producto p ON t.id = p.f_transaccion 
	JOIN cliente Vende ON Vende.id = t.f_vendedor
	JOIN cliente Compra ON Compra.id = t.f_comprador
	JOIN imagendpi DpiVendedor ON DpiVendedor.id = Vende.f_imagendpi
	JOIN imagendpi DpiComprador ON DpiComprador.id = Compra.f_imagendpi
	JOIN estado e2 ON e2.id = t.f_estado
	JOIN pago ON pago.f_transaccion = t.id
	JOIN cuentajump cj ON pago.f_cuentajump = cj.id 
	JOIN banco ON banco.id = cj.f_banco 
	JOIN detallefactura df ON df.f_transaccion = t.id
	WHERE t.id = " .$IDTransaccion. " LIMIT 1";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
	if($registros){
		foreach ($registros as $registro) {
			$descripcion = $registro["descripcion"];
			$idproducto = $registro["idproducto"];
			$fechatransaccion = $registro["fecha"];
			$url = $registro["url"];
			$precio = $registro["precio"];
			$detalles = $registro["detalles"];
			$boleta = $registro["boleta"];
			$nombrebanco = $registro["nombrebanco"];
			$direccion = $registro["direccion"];
			$IDVendedor = $registro["IDVendedor"];
			$Vendedor = $registro["Vendedor"];
			$IDComprador = $registro["IDComprador"];
			$Comprador = $registro["Comprador"];
			$estado = $registro["estado"];
			$IDEstado = $registro["IDEstado"];
			$DpiVendedor = $registro["DpiVendedor"];
			$DpiComprador = $registro["DpiComprador"];
			$comision = $registro["comision"];
			$envioajump = $registro["envioajump"];
			$envioacomprador = $registro["envioacomprador"];
			$IVA = $registro["IVA"];
		}
	}else{
		exit();
	}

	$sql = "SELECT id, estado FROM estado";
	$sentencia2 = $base_de_datos->prepare($sql);
	$sentencia2->execute(); 
	$registros2 = $sentencia2->fetchAll(PDO::FETCH_ASSOC);
?>

 <?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Tomar Transaccion</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>

	<link rel="stylesheet" type="text/css" href="css/TomarTransaccion.css">
</head>
<body>

<script>
	//Actualizamos el estado de la transaccion en FIREBASE
	var IDTrans = '<?php echo $IDTransaccion; ?>';
	var IDComprador = '<?php echo $IDComprador; ?>';
	var IDVendedor = '<?php echo $IDVendedor; ?>';
	var VarEstado = parseInt('<?php echo $IDEstado; ?>');

	UpdateTransaccion(IDTrans, IDComprador, VarEstado); //Actualizamos el estado de la transaccion del comprador
	UpdateTransaccion(IDTrans, IDVendedor, VarEstado); //Actualizamos el estado de la transaccion del vendedor
</script>



<div class="Base">
	<div class="Title">
		<h3>Estamos tomando la transacción</h3>
	</div>

	<div class="Tabla1">
		<table class="table table-dark">
			<tr>
				<th>Transacción</th>
				<td><?php echo $IDTransaccion ?></td>
			</tr>
			<tr>
				<th>Estado de transacción</th>
				<td><a id="aEstado"><?php echo $estado ?></a></td>
			</tr>
			<tr>
				<th>Fecha transaccion</th>
				<td><?php echo $fechatransaccion ?></td>
			</tr>
			<tr>
				<th>Descripcion</th>
				<td><a href="<?php echo $url ?>" target="_blank"><?php echo $descripcion ?></a> <img onclick="AbrirVentana('ventProducto');" class="zoom" src="../imagenes/foto.png" width="25px"></td>
			</tr>
			<tr>
				<th>Precio</th>
				<td><?php echo $precio ?></td>
			</tr>
			<tr>
				<th>Detalles</th>
				<td><?php echo $detalles ?></td>
			</tr>
			<tr>
				<th>Vendedor</th>
				<td><?php echo $Vendedor ?> <img onclick="AbrirVentana('ventVendedor');" class="zoom" src="../imagenes/foto.png" width="25px"></td>
			</tr>
			<tr>
				<th>Comprador</th>
				<td><?php echo $Comprador ?> <img onclick="AbrirVentana('ventComprador');" class="zoom" src="../imagenes/foto.png" width="25px"></td>
			</tr>
		</table>
	</div>

	<div class="Title">
		<h3>Detalles del pago esperado</h3>
	</div>

	<table class="table table-dark">
		<?php
			$Mitad = ($comision + $envioajump + $envioacomprador + $IVA) / 2;
			$Total = ($precio + $Mitad);
			$Redondeo = ceil($Total);
			$DiferenciaRedondeo = round(($Redondeo - $Total), 2);

		 ?>
		<tr>
			<th>Precio</th>
			<td style="text-align: right;">Q. <?php echo $precio ?> </td>
		</tr>
		<tr>
			<th>Comisión</th>
			<td style="text-align: right;">Q. <?php echo $comision / 2; ?> </td>
		</tr>
		<tr>
			<th>Envio</th>
			<td style="text-align: right;">Q. <?php echo ($envioajump + $envioacomprador)/2; ?></td>
		</tr>
		<tr>
			<th>IVA</th>
			<td style="text-align: right;">Q. <?php echo $IVA/2; ?> </td>
		</tr>
		<tr>
			<th>Redondeo</th>
			<td style="text-align: right;">Q. <?php echo $DiferenciaRedondeo; ?> </td>
		</tr>
		<tr>
			<th>Total</th>
			<td style="text-align: right;">Q. <?php echo $Redondeo; ?> </td>
		</tr>
	</table>

	<div class="grid-container">
		<div>
			<div class="Title">
				<h3>Datos del depósito</h3>
			</div>

			<table class="table table-dark">
				<tr>
					<th>Banco</th>
					<td><?php echo $nombrebanco ?></td>
				</tr>
				<tr>
					<th>Boleta</th>
					<td><?php echo $boleta ?></td>
				</tr>
			</table>
		</div>
		<div>
			<div class="Title">
				<h3>Cambiar estado:</h3>
			</div>

			<!--  
			<select class="btn btn-warning dropdown-toggle" id="Estado">
				<div class="dropdown-menu">
					<?php foreach ($registros2 as $registro2) { ?>
						<?php if($registro2["id"] > $IDEstado){ ?>
						<option class="dropdown-item" value="<?php echo $registro2["id"]; ?>"><?php echo $registro2["estado"]; ?></option>
						<?php } ?>
					<?php } ?>
					<option value="10">Pago al vendedor *</option>
				</div>
			</select>-->

			<div id="Botones">
			</div>
			
			<!--<button class="btn btn-secondary" onclick="CambiarEstado();">Guardar</button>-->
		</div>
	</div>
	

	<div class="Volver">
		<a class="btn btn-secondary" href="Transacciones.php">Volver</a>
	</div>

<div id="ventComprador" class="ventana">
	<button onclick="CerrarVentana('ventComprador')">Cerrar</button>
	<h6>DPI del comprador</h6>
	<?php $src = 'data: jpg;base64,'.$registro["DpiComprador"]; ?>
	<?php echo '<img src="'.$src.'" width="400px">'; ?>
</div>
<div id="ventVendedor" class="ventana">
	<button onclick="CerrarVentana('ventVendedor')">Cerrar</button>
	<h6>DPI del comprador</h6>
	<?php $src = 'data: jpg;base64,'.$registro["DpiVendedor"]; ?>
	<?php echo '<img src="'.$src.'" width="400px">'; ?><br><br>
</div>
<div id="ventProducto" class="ventana">
	<button onclick="CerrarVentana('ventProducto')">Cerrar</button>
	<h6>Producto</h6>
	<img src='PintarImagen.php?idproducto=<?php echo $idproducto ?>' border='0' width="180px;">
</div>
</body>
</html>



<script type="text/javascript">
	function AbrirVentana(id){
		document.getElementById(id).style.display = "block";
	}

	function CerrarVentana(id){
		document.getElementById(id).style.display = "none";
	}
</script>

<script type="text/javascript">
	function CambiarEstadoLocal() {
		var combo = document.getElementById("Estado");
		var selected = combo.options[combo.selectedIndex].text;
		document.getElementById('aEstado').innerHTML = selected;
		console.log(selected);
	}

	function CambiarEstado(){
		var EstadoNuevo = document.getElementById("Estado").value;
		var Transaccion = '<?php echo $IDTransaccion ?>';
		var IDComprador = '<?php echo $IDComprador ?>';
		var IDVendedor = '<?php echo $IDVendedor ?>';
		switch(EstadoNuevo){
			case '10':
				window.location.href = "AgregarPago.php?Transaccion="+Transaccion+"";
				break;

			case '11':
				window.location.href = "ReembolsoAComprador.php?Transaccion="+Transaccion+"";
				break;

			default:
				$.ajax({
					type: "POST",
					url: "ModificarTransaccion.php",
					data: {'Transaccion': Transaccion, 'EstadoNuevo': EstadoNuevo},
					dataType: "html",
					beforeSend: function(){
					},
					error: function(){
						console.log("error petición ajax");
					},
					success: function(data){
						if(data == "1"){
							CambiarEstadoLocal();
							//Actualizamos en FIREBASE
							EstadoNuevo = parseInt(EstadoNuevo);
							UpdateTransaccion(Transaccion, IDComprador, EstadoNuevo); //Actualizamos el estado de la transaccion del comprador
							UpdateTransaccion(Transaccion, IDVendedor, EstadoNuevo); //Actualizamos el estado de la transaccion del vendedor
							alert("Cambio reliazado correctamente");
						}else{
							alert("No pudimos realizar el cambio");
						}
					}
				});
				break;
		}
	}
</script>

<script>
$( document ).ready(function() {
	var IDEstado = '<?php echo $IDEstado; ?>';
	var divBotones = document.getElementById("Botones");
	var script2 = "";

	switch(IDEstado){
		case '4':
			script2 = `<button onclick="redirigir('Estados/VerificarPago.php')">Revisar el pago</button>`;
			console.log("tenemos que revisar el pago");
			break;
		case '7':
			script2 = `<button onclick="redirigir('Estados/RecibirProducto.php')">Recibir producto</button>`;
			console.log("Recibir el producto");
			break;
		case '8':
			script2 = `<button onclick="redirigir('Estados/RevisarProducto.php')">Revisar el producto</button>`;
			console.log("Revisar el producto");
			break;
		case '9':
			script2 = `<button onclick="redirigir('Estados/EnviarAlComprador.php')">Enviar al comprador</button>`;
			console.log("Enviar al comprador");
			break;
			/*
		case '10':
			script2 = `<button onclick="redirigir('AgregarPago.php')">Pagar al Vendedor</button>`;
			console.log("Pagar al vendedor");
			break;*/
		case '11':
			script2 = `<button onclick="redirigir('DevolDineroComprador.php')">Devolver Dinero</button><br>`;
			script2 += `<button onclick="redirigir('DevolProducto.php')">Devolver Producto</button>`;
			console.log("Producto invalido");
			break;
		case '12':
			script2 = `<button onclick="redirigir('AgregarPago.php')">Pagar al vendedor</button><br>`;
			console.log("Producto invalido");
			break;

	}
	if(script2 != "") divBotones.innerHTML = script2;
});


function redirigir(ruta){
	var IDTransaccion = '<?php echo $IDTransaccion; ?>';
	window.location = ruta + "?Transaccion=" + IDTransaccion;
}
</script>