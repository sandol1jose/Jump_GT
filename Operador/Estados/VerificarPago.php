<?php
    include_once "../../conexion.php";
    $IDTransacccion = $_GET["Transaccion"];

    $sql2 = "SELECT p.precio, df.comision, df.envioajump, df.envioacomprador, df.IVA 
    FROM transaccion t 
    JOIN producto p ON t.id = p.f_transaccion 
    JOIN detallefactura df ON df.f_transaccion = t.id
    WHERE t.id ='".$IDTransacccion."' LIMIT 1;";
    $sentencia2 = $base_de_datos->prepare($sql2);
    $sentencia2->execute();
    $registros2 = $sentencia2->fetchAll(PDO::FETCH_ASSOC);
    $contar2 = count($registros2);
    foreach ($registros2 as $registro) {
        $precio = $registro["precio"];
        $comision = $registro["comision"];
        $envioajump = $registro["envioajump"];
        $envioacomprador = $registro["envioacomprador"];
        $IVA = $registro["IVA"];
    }


    $sql = "SELECT p.id, b.nombrebanco, p.boleta, p.fechadeposito, p.fecharegistro, p.monto, p.montorevisado
    FROM pago p 
    JOIN cuentajump cj ON cj.id = p.f_cuentajump 
    JOIN banco b ON b.id = cj.f_banco 
    WHERE p.f_transaccion = '".$IDTransacccion."' AND (p.f_tipopago = 1 OR p.f_tipopago = 4);"; // p.f_tipopago = 1 "Pago del comprador a JUMP"
    $sentencia = $base_de_datos->prepare($sql);
    $sentencia->execute();
    $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $contar = count($registros);
    if($contar == 0){
        echo "<script>alert('No hay pagos registrados');</script>";
    }
?>

<?php include_once '../CabeceraOperador.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de pago</title>

    <style>
        table, tr, td, th{
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h1>Verificando el pago del comprador</h1>
    <h3>Transacción <?php echo $IDTransacccion; ?> </h3>

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
			<th>Precio Producto</th>
			<td style="text-align: right;">Q. <?php echo $precio ?> </td>
		</tr>
		<tr>
			<th>Comisión / 2</th>
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

    <br>
    <h2>Pagos realizados por el comprador</h2>

    <table>
        <tr>
            <th>Banco</th>
            <th>Boleta</th>
            <th>Fecha deposito</th>
            <th>Fecha de registro en jump</th>
            <th>Monto</th>
            <th>Confirmar Monto</th>
            <th>Acción</th>
            <th></th>
        </tr>

        <?php foreach($registros as $reg){ ?>

            <tr>
                <td><?php echo $reg['nombrebanco']; ?></td>
                <td><?php echo $reg['boleta']; ?></td>
                <td><?php echo $reg['fechadeposito']; ?></td>
                <td><?php echo $reg['fecharegistro']; ?></td>
                <td><?php echo $reg['monto']; ?></td>

                <?php if($reg['montorevisado'] == NULL){ ?>
                    <td><input type="text" name="Confirmacion" id="Input_<?php echo $reg['id']; ?>"></td>
                    <td><button id="btn_<?php echo $reg['id']; ?>" onclick="UpdatePago(<?php echo $reg['id']; ?>, <?php echo $reg['monto']; ?>);" >Guardar</button></td>
                    <td>
                        <div id="divImg" style="display: none"> 
                        <img id="Img_<?php echo $reg['id']; ?>" src="" width="30px;" >
                        </div>
                    </td>
                <?php }else{ ?>
                    <td><input type="text" name="Confirmacion" id="Input_<?php echo $reg['id']; ?>" value="<?php echo $reg['montorevisado']; ?>"></td>
                    <td><button id="btn_<?php echo $reg['id']; ?>" onclick="UpdatePago(<?php echo $reg['id']; ?>, <?php echo $reg['monto']; ?>);" >Guardar</button></td>
                    <td>
                        <div id="divImg" style="display: none"> 
                        <img id="Img_<?php echo $reg['id']; ?>" src="../../imagenes/completada.png" width="30px;" >
                        </div>
                    </td>
                <?php } ?>
            </tr>

        <?php } ?>

    </table>

    <br>
    <button onclick="Concluir();">Concluir</button>

</body>
</html>


<script>



function UpdatePago(IDPago, MontoEsperado){
    /* ESTADOS DE PAGO
        1 - REVISION
        2 - REVISADO
        3 - DENEGADO
        4 - COMPLETADO
    */
    var MontoVerificado = document.getElementById('Input_' + IDPago).value;
if(MontoVerificado != ""){
    var Estado = 0;
    if(MontoVerificado == MontoEsperado){
        Estado = 2; // 2 - REVISADO
    }else if(MontoVerificado < MontoEsperado || MontoVerificado > MontoEsperado){
        Estado = 2; // 2 - REVISADO
    }
    
    $.ajax({
        type: "POST",
        url: "../app/UpdatePago.php",
        data: {'IDPago': IDPago, 'MontoVerificado': MontoVerificado, 'Estado': Estado},
        dataType: "html",
        beforeSend: function(){
            $("#divImg").show();
            $("#Img_" + IDPago).attr("src","../../imagenes/Cargando6Recorte.gif");
        },
        error: function(){
            console.log("error petición ajax");
        },
        success: function(data){
            if(data == "1"){
                console.log("Actualizado correctamente");
                $('#btn_' + IDPago).attr("disabled", true);
                $("#Img_" + IDPago).attr("src","../../imagenes/completada.png");
            }else{
                console.log("Ocurrio un error");
                $("#Img_" + IDPago).attr("src","../../imagenes/denegada.png");
            }
        }
    });
}else{
    alert("Agrega el monto real verificado en la banca del banco");
}
}


function Concluir(){
    var MontoEsperado = parseInt('<?php echo $Redondeo; ?>', 10);
    var Transaccion = '<?php echo $IDTransacccion; ?>';
    console.log("MontoEsperado: " + MontoEsperado);

    $.ajax({
        type: "POST",
        url: "../app/UpdateTransaccion.php",
        data: {'MontoEsperado': MontoEsperado, 'Transaccion': Transaccion},
        dataType: "html",
        beforeSend: function(){
        },
        error: function(){
            console.log("error petición ajax");
        },
        success: function(data){
            if(data == "1"){
                console.log("Transaccion actualizada");
                alert("Transaccion actualizada");
                window.location="../TomarTransaccion.php?Codigo=" + Transaccion;
            }else{
                console.log("Ocurrio un error");
            }
        }
    });
}

</script>