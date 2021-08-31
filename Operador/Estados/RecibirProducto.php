<?php
    include_once "../../conexion.php";
    $IDTransacccion = $_GET["Transaccion"];

    $sql = "SELECT e.id, e.numero, e.imagen, e.f_tipoenvioajump, t.tipo, e.fecha FROM envioajump e
    JOIN tipoenvioajump t ON e.f_tipoenvioajump = t.id 
    WHERE e.f_transaccion = '".$IDTransacccion."';";
    $sentencia = $base_de_datos->prepare($sql);
    $sentencia->execute();
    $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $cont = count($registros);
    if($cont == 1){//Si hay registros
        foreach ($registros as $registro) {
            $id = $registro["id"];
            $numero = $registro["numero"];
            $imagen = $registro["imagen"];
            $f_tipoenvioajump = $registro["f_tipoenvioajump"];
            $tipo = $registro["tipo"];
            $fecha = $registro["fecha"];
        }
    }else{
        //No hay registros, recibir en oficina
        
    }
?>

<?php include_once '../CabeceraOperador.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibiendo producto</title>

    <style>
        table, tr, td, th{
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h1>Recibiendo producto</h1>
    <h3>Transacción <?php echo $IDTransacccion; ?> </h3>

<?php if($cont == 1){?>
	<div class="Title">
		<h3>Detalles</h3>
	</div>

	<table class="table table-dark">
		<tr>
			<th>ID</th>
			<td style="text-align: right;"><?php echo $id ?> </td>
		</tr>
		<tr>
			<th>Guia / Numero</th>
			<td style="text-align: right;"><?php echo $numero; ?> </td>
		</tr>
		<tr>
			<th>Fecha</th>
			<td style="text-align: right;"><?php echo $fecha; ?></td>
		</tr>
		<tr>
			<th>Tipo</th>
			<td style="text-align: right;"><?php echo $tipo; ?> </td>
		</tr>
	</table>

        <center>

        <?php if($f_tipoenvioajump == 1){ //Envio por transporte ?>
        
            <h2>Imagen de la guia</h2>
            <div>
                <?php $src = 'data: jpg;base64,'. $imagen; ?>
                <?php echo '<img src="'.$src.'" width="80%">'; ?><br>
            </div>
            
        <?php } //De lo contrario no hay imagen ?>

    
        <form action="../app/RecibirProductoTransporte.php" method="POST">
            <br><br>
            <span>Cuanto cobró el transporte por el envio:</span><br>
            <input type="text" name="CobroPorEnvio" id="CobroPorEnvio" placeholder="Cobro por el envio" required>
            <input hidden type="text" name="transaccion" id="transaccion" value="<?php echo $IDTransacccion; ?>">
            <br><input type="submit" value="Recibir"><br><br>
        </form>   
        </center>


<?php }else{ ?>

    <form action="../app/RecibirProductoTransporte.php" method="POST">
        <input hidden type="text" name="transaccion" id="transaccion" value="<?php echo $IDTransacccion; ?>">
        <br><input type="submit" value="Recibir En Oficinas"><br><br>
    </form> 

<?php } ?>

</body>
</html>