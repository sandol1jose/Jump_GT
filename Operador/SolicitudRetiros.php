<?php
session_start();//inicio de sesion
	if(!isset($_SESSION["Operador"])){
		header('Location: index.php'); //envia a la página de inicio.
	}
?>
<?php 
	include_once "../conexion.php";

	$sql = "SELECT r.id, r.monto, r.fechasolicitud, CONCAT(c.nombres, ' ', c.apellidos) Cliente
    FROM retiro r
    JOIN estadodecuenta e ON r.f_estadodecuenta = e.id
    JOIN cliente c ON e.f_cliente = c.id
    WHERE r.f_estadoretiro = 1";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de retiro</title>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <!-- Navbar content -->
</nav>

	<div class="Title">
		<h3>Solicitudes de retiro de dinero</h3>
	</div>

	<div class="Logo zoom">
		<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
	</div>


<div class="divTabla">
	<table class="table">
		<thead class="thead-dark">
			<tr>
				<th scope="col">ID</th>
				<th scope="col">Monto</th>
				<th scope="col">Solicitud</th>
				<th scope="col">Cliente</th>
				<th scope="col">Accion</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($registros as $registro) { ?>
				<tr>
					<th scope="row"><?php echo $registro["id"]; ?></th>
					<td>Q. <?php echo number_format($registro["monto"], 2); ?></td>
					<td><?php echo $registro["fechasolicitud"]; ?></td>
					<td><?php echo $registro["Cliente"]; ?></td>
					<td><button class="btn btn-dark" onclick="Tomar(<?php echo $registro['id']; ?>);">Tomar</button></td>
				</tr>	
			<?php } ?>
		</tbody>
	</table>
</div>
    
</body>
</html>

<script type="text/javascript">
	function Tomar(IDRetiro){
		window.location.href = "TomarRetiro.php?IDRetiro="+IDRetiro+"";
	}
</script>