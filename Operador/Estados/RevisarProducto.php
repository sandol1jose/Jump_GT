<?php
    include_once "../../conexion.php";
    $IDTransacccion = $_GET["Transaccion"];

	$sql = "SELECT d.id, d.marca, d.material1, d.material2, d.estado, d.color, d.desperfectos, 
    d.enciende, d.descripciondetallada, d.tiempodeuso, d.imei, d.alto, d.ancho, d.profundidad,
    d.medida, d.accesorios
    FROM detalleproducto d
    JOIN producto p ON p.id = d.f_producto
    JOIN transaccion t ON t.id = p.f_transaccion 
    WHERE t.id = '".$IDTransacccion."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
	foreach ($registros as $registro) {
        $id =                   $registro["id"];
		$marca =                $registro["marca"];
		$material1 =            $registro["material1"];
		$material2 =            $registro["material2"];
		$estado =               $registro["estado"];
		$color =                $registro["color"];
		$desperfectos =         $registro["desperfectos"];
		$enciende =             $registro["enciende"];
		$descripciondetallada = $registro["descripciondetallada"];
        $tiempodeuso =          $registro["tiempodeuso"];
		$imei =                 $registro["imei"];
		$alto =                 $registro["alto"];
		$ancho =                $registro["ancho"];
		$profundidad =          $registro["profundidad"];
		$medida =               $registro["medida"];
		$accesorios =           $registro["accesorios"];
        if($marca == NULL) $marca = "NO APLICA";
        if($material1 == NULL) $material1 = "NO APLICA";
        if($material2 == NULL) $material2 = "NO APLICA";
        if($estado == NULL) $estado = "NO APLICA";
        if($color == NULL) $color = "NO APLICA";
        if($desperfectos == NULL) $desperfectos = "NO APLICA";
        if($enciende == NULL) $enciende = "NO APLICA";
        if($descripciondetallada == NULL) $descripciondetallada = "NO APLICA";
        if($tiempodeuso == NULL) $tiempodeuso = "NO APLICA";
        if($imei == NULL) $imei = "NO APLICA";
        if($alto == NULL) $alto = "NO APLICA";
        if($ancho == NULL) $ancho = "NO APLICA";
        if($profundidad == NULL) $profundidad = "NO APLICA";
        if($medida == NULL) $medida = "NO APLICA";
        if($accesorios == NULL) $accesorios = "NO APLICA";
	}

?>

<?php include_once '../CabeceraOperador.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisar Producto</title>
</head>
<body>

    <h1>Revisando el producto</h1>

        <div class="Titulo">
			<h5>Detalles del producto</h5>
		</div>

        <center>
        <br>
        <p style="font-size: 15px;">Detalles a revisar del producto.</p>
        <br>

<form action="../app/RevisandoProducto.php" method="POST">
    <div style="width: 50%">
        <table class="table table-striped">
            <tr>
                <th>Descripción</th>
                <th>valor</th>
                <th>Revisión</th>
            </tr>
            <tr>
                <td>Marca:</td>
                <td><?php echo $marca; ?></td>
                <td><?php if($marca != "NO APLICA"){ ?> 
                    <input type="hidden" name="marca" value="0" />
                    <input type="checkbox" name="marca" id="" value="1"> 
                <?php } ?></td>
            </tr>
            <tr>
                <td>Material 1:</td>
                <td><?php echo $material1; ?></td>
                <td><?php if($material1 != "NO APLICA"){ ?> 
                    <input type="hidden" name="material1" value="0" />
                    <input type="checkbox" name="material1" id="" value="1"> 
                <?php } ?></td>
            </tr>
            <tr>
                <td>Material 2:</td>
                <td><?php echo $material2; ?></td>
                <td><?php if($material2 != "NO APLICA"){ ?> 
                    <input type="hidden" name="material2" value="0" />
                    <input type="checkbox" name="material2" id="" value="1"> 
                <?php } ?></td>
            </tr>
            <tr>
                <td>Estado:</td>
                <td><?php echo $estado; ?></td>
                <td><?php if($estado != "NO APLICA"){ ?> 
                    <input type="hidden" name="estado" value="0" />
                    <input type="checkbox" name="estado" id="" value="1"> 
                <?php } ?></td>
            </tr>
            <tr>
                <td>Color:</td>
                <td><?php echo $color; ?></td>
                <td><?php if($color != "NO APLICA"){ ?> 
                    <input type="hidden" name="color" value="0" />
                    <input type="checkbox" name="color" id="" value="1"> 
                <?php } ?></td>
            </tr>
            <tr>
                <td>desperfectos:</td>
                <td><?php echo $desperfectos; ?></td>
                <td><?php if($desperfectos != "NO APLICA"){ ?>
                    <input type="hidden" name="desperfectos" value="0" />
                    <input type="checkbox" name="desperfectos" id="" value="1">
                <?php } ?></td>
            </tr>
            <tr>
                <td>Enciende:</td>
                <td><?php echo $enciende; ?></td>
                <td><?php if($enciende != "NO APLICA"){ ?> 
                    <input type="hidden" name="enciende" value="0" />
                    <input type="checkbox" name="enciende" id="" value="1"> 
                <?php } ?></td>
            </tr>
            <tr>
                <td>Descripción:</td>
                <td><?php echo $descripciondetallada; ?></td>
                <td><?php if($descripciondetallada != "NO APLICA"){ ?>
                    <input type="hidden" name="descripcion" value="0" />
                    <input type="checkbox" name="descripcion" id="" value="1"> 
                <?php } ?></td>
            </tr>
            <tr>
                <td>Uso:</td>
                <td><?php echo $tiempodeuso; ?></td>
                <td><?php if($tiempodeuso != "NO APLICA"){ ?> 
                    <input type="hidden" name="uso" value="0" />
                    <input type="checkbox" name="uso" id="" value="1"> 
                <?php } ?></td>
            </tr>
            <tr>
                <td>IMEI:</td>
                <td><?php echo $imei; ?></td>
                <td><?php if($imei != "NO APLICA"){ ?> 
                    <input type="hidden" name="imei" value="0" />
                    <input type="checkbox" name="imei" id="" value="1"> 
                <?php } ?></td>
            </tr>
            <tr>
                <td>Altura:</td>
                <td><?php echo $alto; ?> cm.</td>
                <td><?php if($alto != "NO APLICA"){ ?> 
                    <input type="hidden" name="alto" value="0" />
                    <input type="checkbox" name="alto" id="" value="1"> 
                <?php } ?></td>
            </tr>
            <tr>
                <td>Anchura:</td>
                <td><?php echo $ancho; ?> cm.</td>
                <td><?php if($ancho != "NO APLICA"){ ?> 
                    <input type="hidden" name="ancho" value="0" />
                    <input type="checkbox" name="ancho" id="" value="1"> 
                <?php } ?></td>
            </tr>
            <tr>
                <td>Profundidad:</td>
                <td><?php echo $profundidad; ?> cm.</td>
                <td><?php if($profundidad != "NO APLICA"){ ?> 
                    <input type="hidden" name="profundidad" value="0" />
                    <input type="checkbox" name="profundidad" id="" value="1"> 
                <?php } ?></td>
            </tr>
            <tr>
                <td>medida:</td>
                <td><?php echo $medida; ?></td>
                <td><?php if($medida != "NO APLICA"){ ?> 
                    <input type="hidden" name="medida" value="0" />
                    <input type="checkbox" name="medida" id="" value="1"> 
                <?php } ?></td>
            </tr>
            <tr>
                <td>Accesorios:</td>
                <td><?php echo $accesorios; ?></td>
                <td><?php if($accesorios != "NO APLICA"){ ?> 
                    <input type="hidden" name="accesorios" value="0" />
                    <input type="checkbox" name="accesorios" id="" value="1"> 
                <?php } ?></td>
            </tr>
        </table>
    </div>
    </center>

    <input type="radio" name="Valor" id="" value="1"> ¿Cumple con las carracteristicas? <br>
    <input type="radio" name="Valor" id="" value="0"> ¿No cumple con las caracteristicas? <br><br>

    <span>Comentario</span><br>
<textarea name="comentario" id="" cols="100" rows="" value="">
</textarea>

    <input type="text" hidden value="<?php echo $id; ?>" name="idDetalleProducto">
    <input type="text" hidden value="<?php echo $IDTransacccion; ?>" name="Transaccion">

    <br><br>
    <input type="submit" value="Siguiente">

    </form>
</body>
</html>