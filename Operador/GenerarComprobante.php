<?php
    include_once "../conexion.php";
    $IDTransacccion = $_GET["Transaccion"];

    $sql = "SELECT r.id IDRecepcion, r.fecha, CONCAT(o.nombres, ' ', o.apellidos) Operador, 
    p.descripcion, p.precio, p.detalles,
    t.id IDTransaccion
    FROM recepcion_producto_jump r
    JOIN operador o ON r.f_operador = o.id
    JOIN transaccion t ON r.f_transaccion = t.id 
    JOIN producto p ON p.f_transaccion = t.id 
    WHERE r.f_transaccion = '".$IDTransacccion."';";
    $sentencia = $base_de_datos->prepare($sql);
    $sentencia->execute();
    $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $contar = count($registros);
    foreach ($registros as $registro) {
        $IDRecepcion = $registro["IDRecepcion"];
        $fecha = $registro["fecha"];
        $Operador = $registro["Operador"];
        $descripcion = $registro["descripcion"];
        $precio = $registro["precio"];
        $detalles = $registro["detalles"];
        $IDTransaccion = $registro["IDTransaccion"];
    }
?>

<?php include_once 'CabeceraOperador.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generando comprobante de recepción</title>
</head>
<body>
    <center>
    <br><br>
    <h1>Comprobante de recepción</h1>

    <p>Jump ha recibido el producto</p>

    <div style="width: 50%">
	<table class="table table-striped">
		<tr>
			<th>Recepción No.</th>
			<td style="text-align: right;"><?php echo $IDRecepcion ?> </td>
		</tr>
		<tr>
			<th>Fecha de Recepción</th>
			<td style="text-align: right;"><?php echo $fecha; ?> </td>
		</tr>
		<tr>
			<th>Encargado</th>
			<td style="text-align: right;"><?php echo $Operador; ?></td>
		</tr>
		<tr>
			<th>Producto</th>
			<td style="text-align: right;"><?php echo $descripcion; ?> </td>
		</tr>
		<tr>
			<th>Precio del producto</th>
			<td style="text-align: right;">Q. <?php echo $precio; ?></td>
		</tr>
		<tr>
			<th>Detalles</th>
			<td style="text-align: right;"><?php echo $detalles; ?> </td>
		</tr>
		<tr>
			<th>Transaccion No.</th>
			<td style="text-align: right;"><?php echo $IDTransaccion; ?> </td>
		</tr>
	</table>
    </div>

    <br>
    
    <p><h4>Nota: </h4>Guarda éste comprobante, es la prueba de que entregaste tu producto a Jump</p>

    <p>www.jumpgt.com</p>

    <br><br>
    <img src="../imagenes/JUMPLogo2.png" width="300px;">

    <br><br>
    <form action="Transacciones.php">
        <input type="submit" value="OK">
    </form>
    <br><br><br><br>

    </center>
</body>
</html>