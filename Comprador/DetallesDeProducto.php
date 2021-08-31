<?php
session_start();//inicio de sesion
	include_once "../conexion.php";

	if(!isset($_SESSION['TransaccionFirebase']) || !isset($_SESSION['Cliente'])){
		header('Location: ../index.php');
	}

	$Codigo = $_SESSION['TransaccionFirebase'];
	$IDComprador = $_SESSION['Cliente']['IDCliente'];

	$sql = "SELECT d.marca, d.material1, d.material2, d.estado, d.color, d.desperfectos, 
    d.enciende, d.descripciondetallada, d.tiempodeuso, d.imei, d.alto, d.ancho, d.profundidad,
    d.medida, d.accesorios
    FROM detalleproducto d
    JOIN producto p ON p.id = d.f_producto
    JOIN transaccion t ON t.id = p.f_transaccion 
    WHERE t.id = '".$Codigo."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
	foreach ($registros as $registro) {
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


	$sql2 = "SELECT CONCAT(c.nombres, ' ', c.apellidos) Vendedor, c.id IDVendedor, c.dpi, p.descripcion, p.precio, p.direccion, p.url, p.detalles 
	FROM transaccion t JOIN cliente c ON t.f_vendedor = c.id 
	JOIN producto p ON t.id = p.f_transaccion 
	WHERE t.id = '".$Codigo."'";
	$sentencia2 = $base_de_datos->prepare($sql2);
	$sentencia2->execute(); 
	$registros2 = $sentencia2->fetchAll(PDO::FETCH_ASSOC);
	foreach ($registros2 as $registro) {
		$IDVendedor = $registro["IDVendedor"];
		$Vendedor = $registro["Vendedor"];
		$dpi = $registro["dpi"];
		$descripcion = $registro["descripcion"];
		$precio = $registro["precio"];
		$direccion = $registro["direccion"];
		$url = $registro["url"];
		$detalles = $registro["detalles"];
	}
?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Detalles del producto</title>
	<link rel="stylesheet" type="text/css" href="../css/ingresoproducto.css">
	<link rel="stylesheet" type="text/css" href="../css/Less.css">
	<script src="../js/general.js"></script>
</head>
<body>

<script>
    alertsweetalert2('Detalles del producto', 'Por favor revisa los detalles del producto que el vendedor colocó', 'info');
</script>

<script>
	//Actualizamos el estado de la transaccion en FIREBASE
	var IDTrans = '<?php echo $Codigo; ?>';
	var IDComprador = '<?php echo $IDComprador; ?>';
	var IDVendedor = '<?php echo $IDVendedor; ?>';

	var Estado = 2; //Vinculada
	InsertTransaccion(IDTrans, IDComprador, Estado); //Insertamos la nueva transaccion para el comprador
	UpdateTransaccion(IDTrans, IDVendedor, Estado); //Actualizamos el estado de la transaccion del vendedor
	
	<?php 
		$arrayTransaccionFirebase = array(
			'IDComprador'=>$IDComprador,
			'IDVendedor'=>$IDVendedor,
			'IDTransaccion'=>$Codigo
		);
		$_SESSION['TransaccionFirebase'] = $arrayTransaccionFirebase;
	?>
</script>


<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Detalles del producto</h5>
		</div>
        <center>
        <br>
        <p style="font-size: 15px;">Estos son los detalles del producto que Jump revisará, por favor comprueba que sea lo que esperas
        recibir, de lo contrario no des en el botón aceptar.</p>
        <br>

        <table class="table table-striped">
            <tr>
                <td>Marca:</td>
                <td><?php echo $marca; ?></td>
            </tr>
            <tr>
                <td>Material 1:</td>
                <td><?php echo $material1; ?></td>
            </tr>
            <tr>
                <td>Material 2:</td>
                <td><?php echo $material2; ?></td>
            </tr>
            <tr>
                <td>Estado:</td>
                <td><?php echo $estado; ?></td>
            </tr>
            <tr>
                <td>Color:</td>
                <td><?php echo $color; ?></td>
            </tr>
            <tr>
                <td>desperfectos:</td>
                <td><?php echo $desperfectos; ?></td>
            </tr>
            <tr>
                <td>Enciende:</td>
                <td><?php echo $enciende; ?></td>
            </tr>
            <tr>
                <td>Descripción:</td>
                <td><?php echo $descripciondetallada; ?></td>
            </tr>
            <tr>
                <td>Uso:</td>
                <td><?php echo $tiempodeuso; ?></td>
            </tr>
            <tr>
                <td>IMEI:</td>
                <td><?php echo $imei; ?></td>
            </tr>
            <tr>
                <td>Altura:</td>
                <td><?php echo $alto; ?> cm.</td>
            </tr>
            <tr>
                <td>Anchura:</td>
                <td><?php echo $ancho; ?> cm.</td>
            </tr>
            <tr>
                <td>Profundidad:</td>
                <td><?php echo $profundidad; ?> cm.</td>
            </tr>
            <tr>
                <td>medida:</td>
                <td><?php echo $medida; ?></td>
            </tr>
            <tr>
                <td>Accesorios:</td>
                <td><?php echo $accesorios; ?></td>
            </tr>
        </table>
        </center>


		<form method="POST" action="../app/AceptarTransaccion.php">		
			<div class="divBoton zoom">
				<input class="button" type="submit" name="" value="Aceptar">
			</div>

			<input hidden type="text" name="Codigo" id="Codigo" value="<?php echo $Codigo ?>">
			<input hidden type="text" name="Precio" id="Precio" value="<?php echo $precio ?>">

			<div class="Logo zoom">
				<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
			</div>
		</form>
		

	</div>
</div>

</body>
</html>