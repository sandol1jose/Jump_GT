<?php
session_start();//inicio de sesion
	if(!isset($_SESSION["Cliente"])){
		header('Location: ../Registro/index.php'); //envia a la página de inicio.
	}

	$arrayCliente = $_SESSION["Cliente"];
	$IDCliente = $arrayCliente['IDCliente'];

	include_once "../conexion.php";
	include_once "../Sesiones/sesCliente.php";

	$sql = "SELECT t.id, p.descripcion, p.precio, p.direccion, e.estado, e.id idEstado, imp.cadena imagen FROM transaccion t JOIN producto p ON t.id = p.f_transaccion JOIN imagenproducto imp ON imp.f_producto = p.id JOIN estado e ON e.id = t.f_estado WHERE t.f_comprador = '".$IDCliente."' GROUP BY t.id";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Mis compras</title>
	<link rel="stylesheet" type="text/css" href="../css/Master.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Mis compras</h5>
		</div>

<?php foreach ($registros as $registro) { ?>
	<div class="Ventas zoom2" onclick="DetallarCompra(<?php echo $registro['id']; ?>);">
		<div class="grid-container">
			<?php $src = 'data: jpg;base64,'.$registro["imagen"]; ?>
			<div class="item1"><?php echo '<img class="ImagenesFotos" src="'.$src.'">'; ?></div>
			<div class="ellipsis"><b><?php echo $registro["descripcion"]; ?></b></div>

			<?php
				$Estado = $registro["idEstado"];
				switch ($Estado) {
					case 10:
						//Transaccion completa
						$URLimagen = "../imagenes/completada.png";
						break;

					case 6:
						//Pago no correcto
						$URLimagen = "../imagenes/denegada.png";
						break;

					case 11:
						//Pago no correcto
						$URLimagen = "../imagenes/denegada.png";
						break;
					
					default:
						//Transaccion en proceso
						$URLimagen = "../imagenes/enproceso.png";
						break;
				}

			 ?>
			<div style="text-align: right;"><img src="<?php echo $URLimagen ?>" width="15px;"></div>  
			<div> Q. <?php echo number_format($registro["precio"], 2); //colocando 2 decimales ?></div>
			<div></div>
			<div class="item6"><a style="font-size: 10px;"><?php echo $registro["direccion"]; ?></a></div>
			<?php 
				$Estado = $registro["idEstado"];
				if($Estado == 11){?>
			<div class="zoom" style="text-align: right;"><a href="devolucion.php?Codigo=<?php echo $registro["id"] ?>"><img src="../imagenes/retirar.png"width="30px;" /></a></div>
			<?php 	} ?>
		</div>
	</div>
<?php } ?>

	<div class="Logo zoom">
		<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
	</div>

	</div>
</div>
</body>
</html>


<script>
	function DetallarCompra(idTransaccion){
		window.location.href = "DetalleCompra.php?Transaccion=" + idTransaccion + "";
	}
</script>