<?php
    include_once "../conexion.php";
    $IDTransacccion = $_GET["Transaccion"];

	$sql = "SELECT SUM(montorevisado) Total, CONCAT(c.nombres, ' ', c.apellidos) comprador, c.id IDCliente, 
    dr.comentario FROM pago p
    JOIN transaccion t ON t.id  = p.f_transaccion 
    JOIN cliente c ON t.f_comprador = c.id
    JOIN producto pro ON pro.f_transaccion = t.id
    JOIN detalleproducto d ON d.f_producto = pro.id
    JOIN detalleproducto_revision dr ON dr.f_detalleproducto = d.id 
    WHERE t.id = '".$IDTransacccion."' AND (p.f_tipopago = 1 OR p.f_tipopago = 4) AND p.f_tipoestado = 2;";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute();
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
	foreach ($registros as $registro) {
        $TotalMoneda =          number_format($registro["Total"], 2); //colocando 2 decimales
        $Total =                $registro["Total"];
		$comprador =            $registro["comprador"];
		$IDCliente =            $registro["IDCliente"];
        $comentario =           $registro["comentario"];
	}
?>

<?php include_once 'CabeceraOperador.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dovolución</title>
</head>
<body>

<h1>Devolver dinero al comprador</h1>
<p>El producto no era lo que se esperaba, se necesita devolver el dinero al comprador</p>

<?php if($Total != NULL){ ?>
<table class="table table-striped">
    <tr>
        <th>Transaccion</th>
        <th>Motivo</th>
        <th>Monto</th>
        <th>Cliente</th>
    </tr>

    <tr>
        <td><?php echo $IDTransacccion; ?></td>
        <td><?php echo $comentario; ?></td>
        <td>Q. <?php echo $TotalMoneda; ?></td>
        <td><?php echo $comprador; ?></td>
    </tr>
</table>
<?php }else{ ?>

    <h2>No hay pagos para devolver</h2>

<?php } ?>

<br>
<form action="app/DevolverMonto.php" method="POST">
    <input type="hidden" name="monto" value="<?php echo $Total; ?>">
    <input type="hidden" name="razon" value="<?php echo $comentario; ?>">
    <input type="hidden" name="transaccion" value="<?php echo $IDTransacccion; ?>">
    <input type="submit" value="Devolver">
</form>
    
</body>
</html>