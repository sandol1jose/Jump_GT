<?php 
	include_once "../conexion.php";

	$Codigo = $_GET["Codigo"];

	$sql = "SELECT p.descripcion, p.precio, p.direccion, p.url, i2.cadena imagen
		FROM transaccion t JOIN producto p ON t.id = p.f_transaccion
		JOIN imagenproducto i2 ON p.id = i2.f_producto
		WHERE t.id =  '".$Codigo."' LIMIT 1";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

	$nombre = '';
	$dpi = '';
	$descripcion = '';
	$precio = '';
	$direccion = '';
	foreach ($registros as $registro) {
		$descripcion = $registro["descripcion"];
		$precio = $registro["precio"];
		$direccion = $registro["direccion"];
		$url = $registro["url"];
		$Imagen = ExtraerImagen($registro["imagen"]);
	}

	function ExtraerImagen($ImagenPura){
		$src = 'data: jpg;base64,'.$ImagenPura;
		return '<img class="zoom" src="'.$src.'" width="100px">';
	}
 ?>

 <?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Envio del producto</title>
	<link rel="stylesheet" type="text/css" href="css/EnviarProducto.css">
	<style type="text/css">
		table, th, td {
		  border: 1px solid black;
		}
	</style>
</head>
<body>
<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Envio de Producto</h5>
		</div>

		<div class="SubTitulo2">
			<h4>Tenemos el pago</h4>
			<p>El cliente ya realizó su depósito</p>	
		</div>

		<div class="Texto">
			<h6>Debes enviar el producto <a href="<?php echo $url ?>"><?php echo $descripcion; ?>
			</a>  a la siguiente dirección:</h6>
		</div>

		<!--
		<div class="grid-container">
			<div class="item1"><?php echo $Imagen ?></div>
			<div class="item2"><a href="<?php echo $url ?>"><?php echo $descripcion ?></a></div>
			<div class="item3">Q. <?php echo $precio  ?></div>
			 <div class="item4"><?php // echo $direccion ?></div> 
		</div>-->

		<br>
		<center>
			<p>Oficinas centrales de Jump:</p>
			<p style="font-weight: bold;">Km. 169.5 ruta a Esquipulas, Chiquimula, GT 20001.
				<a href="https://www.google.com/maps/place/14%C2%B047'25.1%22N+89%C2%B032'09.0%22W/@14.7902953,-89.5363702,189m/data=!3m2!1e3!4b1!4m6!3m5!1s0x0:0x0!7e2!8m2!3d14.7902941!4d-89.5358231?hl=es" target="_blank">Ver mapa</a> </p>
			<p>A nombre de: Jump GT</p>
			<p style="font-size: 12px;">Un operador de JUMP revisará el producto</p>
			<!--
			<p style="font-size: 12px;">Nota: Si estás fuera de Chiquimula debes enviarlo por medio de <a href="https://www.cargoexpreso.com/" target="_blank">Cargo Expreso</a> por cobrar</p>
			-->
			<p style="font-size: 12px;">Nota: Puedes entregarlo personalmente en nuestra oficina o si estás fuera de chiquimula enviarlo por transporte (Forza, Cargo Expreso o Guatex)</p>
		</center>

		<div class="Imagen zoom">
			<img src="../imagenes/Envio.png" width="50px">
		</div>

		<form method="POST" action="NumeroDeGuia.php">
			<input hidden type="text" name="Transaccion" value="<?php echo $Codigo ?>">
			
			<div class="divBoton zoom">
				<input class="button" type="submit" name="" value="Siguiente">
			</div>
		</form>

		<!-- 
		<form method="POST" action="../app/CambiarEstadoTransaccion.php">
			<input hidden type="text" name="Transaccion" value="<?php echo $Codigo ?>">
			<input hidden type="text" name="EstadoNuevo" value="7"> 7 = Envio a JUMP 
			
			<div class="divBoton zoom">
				<input class="button" type="submit" name="" value="Siguiente">
			</div>
		</form>-->

		<!--
		<div class="Logo zoom">
			<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
		</div>-->
	</div>
</div>
</body>
</html>