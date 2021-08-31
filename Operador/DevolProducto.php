<?php
    include_once "../conexion.php";
    $IDTransacccion = $_GET["Transaccion"];

    $sql = "SELECT p.id, b.nombrebanco,  cj.cuenta, p.boleta, p.fechadeposito, p.fecharegistro,
     p.monto, p.montorevisado FROM pago p 
    JOIN cuentajump cj ON cj.id = p.f_cuentajump 
    JOIN banco b ON b.id = cj.f_banco 
    WHERE p.f_transaccion = '".$IDTransacccion."' AND (p.f_tipopago = 6 OR p.f_tipopago = 5);"; // p.f_tipopago = 1 "Pago del comprador a JUMP"
    $sentencia = $base_de_datos->prepare($sql);
    $sentencia->execute();
    $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $contar = count($registros);
    if($contar == 0){
        echo "<script>alert('No hay pagos registrados');</script>";
        exit();
    }

	$sql2 = "SELECT d.id, d.reembolsoporenvioajump, d.reembolsocomision, d.fechaenvio
    FROM devolucionproducto d
    WHERE d.f_transaccion = '".$IDTransacccion."'";
	$sentencia2 = $base_de_datos->prepare($sql2);
	$sentencia2->execute(); 
	$registros2 = $sentencia2->fetchAll(PDO::FETCH_ASSOC);
    foreach($registros2 as  $Reg){
        $IDdevolucionproducto = $Reg["id"];
        $reembolsoporenvioajump = $Reg["reembolsoporenvioajump"];
        $reembolsocomision = $Reg["reembolsocomision"];
        $fechaenvio = $Reg["fechaenvio"];
    }
    $Total = $reembolsoporenvioajump + $reembolsocomision;
	$TotalRedondeado = ceil($Total);
	$DiferenciaRedondeo = round(($TotalRedondeado - $Total), 2);
?>

<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devolver Producto</title>
</head>
<body>

    <h1>Devolviendo el producto</h1>

<?php if($fechaenvio == NULL){ //Si es NULL quiere decir que no se ha enviado el producto ?>

    <h5>El cliente debe depositar la cantidad de:</h5>

    <div width="50px;">
    <table class="table table-striped">
        <tr>
            <th>Envio cobrado:</th>
            <td style="text-align: right;">Q. <?php echo number_format($reembolsoporenvioajump, 2) ?></td>
        </tr>

        <tr>
            <th>Daños y perjuicios:</th>
            <td style="text-align: right;">Q. <?php echo number_format($reembolsocomision, 2) ?></td>
        </tr>

        <tr>
            <th>Redondeo:</th>
            <td style="text-align: right;">Q. <?php echo number_format($DiferenciaRedondeo, 2) ?></td>
        </tr>
        
        <tr>
            <th>Total a depositar</th>
            <th style="text-align: right;"><spna style="font-size: 30px;">Q. <?php echo number_format($TotalRedondeado,2); ?></span></th>
        </tr>
    </table>
    </div>
    <br>

    <h2>Pagos realizados por el comprador</h2>

    <table class="table table-striped">
        <tr>
            <th>Cuenta Jump</th>
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
                <td><?php echo $reg['cuenta']; ?></td>
                <td><?php echo $reg['nombrebanco']; ?></td>
                <td><?php echo $reg['boleta']; ?></td>
                <td><?php echo date_format(date_create($reg['fechadeposito']), 'd/m/Y H:i A'); ?></td>
                <td><?php echo date_format(date_create($reg['fecharegistro']), 'd/m/Y H:i A'); ?></td>
                <td>Q. <?php echo number_format($reg['monto'], 2); ?></td>

                <?php if($reg['montorevisado'] == NULL){ ?>
                    <td><input type="text" name="Confirmacion" id="Input_<?php echo $reg['id']; ?>"></td>
                    <td><button id="btn_<?php echo $reg['id']; ?>" onclick="UpdatePago(<?php echo $reg['id']; ?>, <?php echo $reg['monto']; ?>);" >Guardar</button></td>
                    <td>
                        <div id="divImg_<?php echo $reg['id']; ?>" style="display: none">
                        <img id="Img_<?php echo $reg['id']; ?>" src="" width="30px;" >
                        </div>
                    </td>
                <?php }else{ ?>
                    <td><input type="text" name="Confirmacion" id="Input_<?php echo $reg['id']; ?>" value="<?php echo $reg['montorevisado']; ?>"></td>
                    <td><button id="btn_<?php echo $reg['id']; ?>" onclick="UpdatePago(<?php echo $reg['id']; ?>, <?php echo $reg['monto']; ?>);" >Guardar</button></td>
                    <td>
                        <div name="divImg">
                        <img id="Img_<?php echo $reg['id']; ?>" src="../imagenes/completada.png" width="30px;" >
                        </div>
                    </td>

                <script></script>

                <?php } ?>
            </tr>

        <?php } ?>
    </table>

    <button onclick="Verificar();" >Verificar</button>

    <a id="mensaje"></a>
    <div id="divEnvio" style="border-top: 3px solid black; display: none">
        <h5>Datos del envio:</h5>
        <form action="app/UpdateDevolProducto.php" method="POST">
            <span>Número de guia</span><br>
            <input type="number" name="Numeroguia" required><br><br>

            <span>Imagen de guia</span><br>
            <input type="file" name="guia" id="guia"><br><br>

            <span>Fecha de envio</span><br>
            <input type="datetime-local" name="Fecha" required><br><br>

            <input type="hidden" name="IDdevolucionproducto" value="<?php echo $IDdevolucionproducto; ?>">

            <input type="submit" value="Siguiente"><br><br>
        </form>
    </div>

<?php }else{ ?>

    <br>
    <h3>No hay productos que devolver</h3>

<?php } ?>

</body>
</html>



<script>
function UpdatePago(IDPago, MontoEsperado){
    /* ESTADOS DE PAGO
        1 - REVISION
        2 - REVISADO
        3 - DENEGADO
        4 - COMPLETADO
        5 - DEVUELTO
    */
    var MontoVerificado = document.getElementById('Input_' + IDPago).value;
    if(MontoVerificado != ""){
        var Estado = 2;
    
        $.ajax({
            type: "POST",
            url: "app/UpdatePago.php",
            data: {'IDPago': IDPago, 'MontoVerificado': MontoVerificado, 'Estado': Estado},
            dataType: "html",
            beforeSend: function(){
                $("#divImg_" + IDPago).show(); //Mostramos el div de la imagen
                $("#Img_" + IDPago).attr("src","../imagenes/Cargando6Recorte.gif");
            },
            error: function(){
                console.log("error petición ajax");
            },
            success: function(data){
                if(data == "1"){
                    console.log("Actualizado correctamente");
                    $('#btn_' + IDPago).attr("disabled", true);
                    $("#Img_" + IDPago).attr("src","../imagenes/completada.png");
                }else{
                    console.log("Ocurrio un error");
                    $("#Img_" + IDPago).attr("src","../imagenes/denegada.png");
                }
            }
        });
    }else{
        alert("Agrega el monto real verificado en la banca del banco");
    }
}

function Verificar(){
    //Verifica si los pagos del realizados por el cliente son => que la cantidad que tenia que depositar
    var arrayRegistros = <?= json_encode($registros) ?>;//Pasando el array
    var TotalPagosCliente = 0;
    for(var i = 0; i < arrayRegistros.length; i++){
        var IDPagoVar = arrayRegistros[i]["id"];
        TotalPagosCliente += parseFloat(document.getElementById('Input_' + IDPagoVar).value);
    }
    var TotalEsperado = parseFloat('<?php echo $TotalRedondeado; ?>');
 
    if(TotalPagosCliente >= TotalEsperado){
        $("#divEnvio").show();
        document.getElementById('mensaje').innerHTML = "";
    }else{
        $("#divEnvio").hide();
        document.getElementById('mensaje').innerHTML = "<h3>El cliente debe completar el pago</h3>";
    }
}
</script>





<script src="../Libraries/compressorjs-master/docs/js/compressor.js"></script>
<script  src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"> </script>
<script>
document.getElementById('guia').addEventListener('change', (e) => {
    //comprimir imagen
  const file = e.target.files[0];
  console.log(file['size'] / 1000);

  var calidad = 0;
  var Size = (file['size'] / 1000);
  if( Size >= 1000 && Size < 5000){
    calidad = 0.4;
  }else if(Size >= 5000){
    calidad = 0.3;
  }else{
    calidad = 0.6;
  }

  if (!file) {
    return;
  }

  new Compressor(file, {
    quality: calidad,

    // The compression process is asynchronous,
    // which means you have to access the `result` in the `success` hook function.
    success(result) {
        console.log(result['size'] / 1000);
        let  formData = new FormData();

        // The third parameter is required for server
        formData.append('Imagen', result, result.name);
		formData.append('Modo', '3'); //3 NumeroDeGuia

        let config = {
            header : {
            'Content-Type' : 'multipart/form-data'
            }
        }
        
        axios.post('../Sesiones/RecibirImagen.php', formData, config).then((response) => {
            console.log('Upload success');
			document.getElementById('guia').value = null;
            //console.log(response.data);
        }).catch(error => {
            console.log('error', error)
        });

    },
    error(err) {
      console.log(err.message);
      document.getElementById('guia').value = null;
	  alertsweetalert2('Error', 'Por favor carga una imagen', 'error');
    },
  });
});
</script>