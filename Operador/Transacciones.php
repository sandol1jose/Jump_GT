<?php
session_start();//inicio de sesion
	if(!isset($_SESSION["Operador"])){
		header('Location: index.php'); //envia a la página de inicio.
	}
?>
<?php 
	include_once "../conexion.php";

	$sql = "SELECT t.id, t.fecha, p.descripcion, p.precio, p.direccion, e2.estado, e2.id IDEstado
		FROM transaccion t 
		JOIN producto p ON t.id = p.f_transaccion
		JOIN estado e2 ON e2.id = t.f_estado";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Transacciones</title>
	<link rel="stylesheet" type="text/css" href="css/Transacciones.css">
	<link rel="stylesheet" type="text/css" href="css/Transacciones.css">
	<link rel="stylesheet" type="text/css" href="../css/Master.css">

</head>
<body>
<nav class="navbar navbar-dark bg-dark">
  <!-- Navbar content -->
</nav>

	<div class="Title">
		<h3>Transacciones pendientes</h3>
	</div>

	<div class="Logo zoom">
		<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
	</div>

<div class="divTabla">
	<table class="table">
		<thead class="thead-dark">
			<tr>
				<th scope="col">ID</th>
				<th scope="col">Fecha</th>
				<th scope="col">Descripcion</th>
				<th scope="col">Precio</th>
				<th scope="col">Direccion</th>
				<th scope="col">Estado</th>
				<th scope="col">Accion</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($registros as $registro) { ?>
				<tr>
					<th scope="row"><?php echo $registro["id"]; ?></th>
					<td><?php echo $registro["fecha"]; ?></td>
					<td><?php echo $registro["descripcion"]; ?></td>
					<td>Q. <?php echo $registro["precio"]; ?></td>
					<td><?php echo $registro["direccion"]; ?></td>
					<td><?php echo $registro["estado"]; ?></td>
					<td><button class="btn btn-dark" onclick="Tomar(<?php echo $registro["id"]; ?>);">Tomar</button></td>
				</tr>	
			<?php } ?>
		</tbody>
	</table>
</div>

</body>
</html>


<script type="text/javascript">
	function Tomar(CodigoTransaccion){
		//Estado 5 = Pago Correcto;
		window.location.href = "TomarTransaccion.php?Codigo="+CodigoTransaccion+"";
	}

	/*
	function Aceptar(CodigoTransaccion, Estado){
		//Estado 5 = Pago Correcto;
		window.location.href = "ModificarTransaccion.php?Codigo="+CodigoTransaccion+"&Estado="+Estado+"";
	}

	function Denegar(CodigoTransaccion){
		//Estado 6 = Pago no correcto;
		window.location.href = "ModificarTransaccion.php?Codigo="+CodigoTransaccion+"&Estado=6";
	}*/
</script>