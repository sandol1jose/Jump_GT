<?php
session_start();//inicio de sesion
	if(!isset($_SESSION["Cliente"])){
		header('Location: ../Registro/index.php'); //envia a la página de inicio.
	}

	$arrayCliente = $_SESSION["Cliente"];
	$IDCliente = $arrayCliente['IDCliente'];
    $Transaccion = $_GET["Transaccion"];

	include_once "../conexion.php";
	include_once "../Sesiones/sesCliente.php";

	$sql = "SELECT t.f_estado, p.precio precioproducto, 
    Vende.id IDVendedor, Compra.id IDComprador FROM transaccion t 
    JOIN producto p ON p.f_transaccion = t.id
    JOIN cliente Vende ON Vende.id = t.f_vendedor 
    JOIN cliente Compra ON Compra.id = t.f_comprador 
    WHERE t.id = '".$Transaccion."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    foreach ($registros as $registro) {
        $Estado = $registro["f_estado"];
        $PrecioProducto = $registro["precioproducto"];
        $IDVendedor = $registro["IDVendedor"];
        $IDComprador = $registro["IDComprador"];
    }


    $Pintar = 0;
    $Error = 0;
    switch($Estado){
        case 2;
            $Pintar = 2;
            break;
        case 3;
            $Pintar = 3;
            break;
        case 4;
            $Pintar = 4;
            break;
        case 5;
            $Pintar = 5;
            break;
        case 7;
            $Pintar = 6;
            break;
        case 8;
            $Pintar = 7;
            break;
        case 9;
            $Pintar = 8;
            break;
        case 12;
            $Pintar = 9;
            break;
        case 10;
            $Pintar = 10;
            break;

        //Casos en los que no se completo
        case 6;
            $Pintar = 4; //Vamos a pintar 4 y pago no correcto
            $Error = 6; //pago no correcto
            break;
        case 11;
            $Pintar = 7; //Vamos a pintar 8 y Producto invalido
            $Error = 11; //Producto invalido
            break;
    }

//VERIFICANDO SI EL CLIENTE YA TIENE CUENTA BANCARIA REGISTRADA
    $sql2 = "SELECT COUNT(c.id) cantidadcuentas FROM cuentabancaria c WHERE c.f_cliente = '".$IDCliente."'";
	$sentencia2 = $base_de_datos->prepare($sql2);
	$sentencia2->execute(); 
	$registros2 = $sentencia2->fetchAll(PDO::FETCH_ASSOC);
    $CuentaBancaria = false;
    foreach ($registros2 as $registro2) {
        $ConCuenta = $registro2["cantidadcuentas"];
        if($ConCuenta >= 1){
            $CuentaBancaria = true;
        }else{
            $CuentaBancaria = false;
        }
        
    }
?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Mis ventas</title>
	<link rel="stylesheet" type="text/css" href="../css/Master.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/DetalleCompra.css">
    <script src="../js/general.js"></script>
</head>
<body>

<?php
	if(isset($_SESSION["Alerta"])){
		$Alerta = $_SESSION["Alerta"];
		if(strcmp($Alerta, 'RecibidoOk') === 0){
			echo "<script> alertsweetalert2('Confirmaste que has recibido el producto', '', 'success'); </script>";
        }
		unset($_SESSION["Alerta"]);
	}
?>



<script>
    var VarEstado = parseInt('<?php echo $Estado; ?>');
    if(VarEstado == 12){
        //Actualizamos el estado de la transaccion en FIREBASE
        var IDTrans = '<?php echo $Transaccion; ?>';
        var IDComprador = '<?php echo $IDComprador; ?>';
        var IDVendedor = '<?php echo $IDVendedor; ?>';

        var Estado = 12; //Producto Recibido
        UpdateTransaccion(IDTrans, IDComprador, Estado); //Actualizamos el estado de la transaccion del comprador
        UpdateTransaccion(IDTrans, IDVendedor, Estado); //Actualizamos el estado de la transaccion del vendedor
    }
</script>



<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Transacción <?php echo $Transaccion; ?> </h5>
		</div>

<div class="grid-container">

    <div><div id="Img2" style="display: none" ><img src="../imagenes/check2.png" width="15px;"></div></div>
    <div><span id="Est2" class="LetrasGris">Vinculada</span></div>
    <div><div id="Lupa2" style="display: none" >
        <a href="../Comprador/DetallesDeTransaccion.php?Codigo=<?php echo $Transaccion; ?>">
        <img src="../imagenes/lupa.png" width="20px;"></a>
    </div></div>

    <div><div id="Img3" style="display: none" ><img src="../imagenes/check2.png" width="15px;"></div></div>
    <div><span id="Est3" class="LetrasGris">Aceptaste la transacción</span></div>
    <div>
        <div id="Lupa3" style="display: none" >
        <?php
            include '../Sesiones/sesTransaccion.php';
            SesionTransaccion($Transaccion, $PrecioProducto, $Estado);
        ?>
        <a href="../Comprador/pagar.php?Transaccion=<?php echo $Transaccion; ?>">
        <img src="../imagenes/lupa.png" width="20px;"></a>
    </div></div>

    <div><div id="Img4" style="display: none" ><img src="../imagenes/check2.png" width="15px;"></div></div>
    <div><span id="Est4" class="LetrasGris">Revision del pago</span></div>
    <div><div id="Lupa4" style="display: none" onclick="Mensaje('Realizaste el pago','Estamos revisando el pago', 'info');" >
        <img src="../imagenes/lupa.png" width="20px;">
    </div></div>

    <div><div id="Img5" style="display: none" ><img src="../imagenes/check2.png" width="15px;"></div></div>
    <div><span id="Est5" class="LetrasGris">Pago revisado</span></div>
    <div><div id="Lupa5" style="display: none" onclick="Mensaje('Pago revisado','Esperaremos que el vendedor envie el producto', 'info');" >
        <img src="../imagenes/lupa.png" width="20px;">
    </div></div>

    <div><div id="Img6" style="display: none" ><img src="../imagenes/check2.png" width="15px;"></div></div>
    <div><span id="Est6" class="LetrasGris">Envío de producto a Jump</span></div>
    <div><div id="Lupa6" style="display: none" onclick="Mensaje('Envio del producto', 'El producto esta en camino para poder revisarlo', 'info');" >
        <img src="../imagenes/lupa.png" width="20px;">
    </div></div>

    <div><div id="Img7" style="display: none" ><img src="../imagenes/check2.png" width="15px;"></div></div>
    <div><span id="Est7" class="LetrasGris">Revisión del producto</span></div>
    <div><div id="Lupa7" style="display: none" onclick="Mensaje('Revisión del producto','Un operador de JUMP revisa tu producto en estos momentos', 'info');" >
        <img src="../imagenes/lupa.png" width="20px;">
    </div></div> 

    <div><div id="Img8" style="display: none" ><img src="../imagenes/check2.png" width="15px;"></div></div>
    <div><span id="Est8" class="LetrasGris">Envío de producto al comprador</span></div>
    <div><div id="Lupa8" style="display: none" onclick="Mensaje('Envio del producto', 'El producto esta en camino hacia el comprador', 'info');" >
        <img src="../imagenes/lupa.png" width="20px;">
    </div></div>

    <div><div id="Img9" style="display: none" ><img src="../imagenes/check2.png" width="15px;"></div></div>
    <div><span id="Est9" class="LetrasGris">Producto recibido</span></div>
    <div>
        <div id="Lupa9" style="display: none" onclick="Mensaje('Producto recibido', 'Confirmaste que has recibido el producto', 'info');" >
            <img src="../imagenes/lupa.png" width="20px;">
        </div>

        <a href="../Comprador/ConfirmarRecepcion.php?Transaccion=<?php echo $Transaccion; ?>">
            <div id="Pregunta9" style="display: none" >
                <img src="../imagenes/pregunta.png" width="20px;">
            </div>
        </a>
    </div>

    <div><div id="Img10" style="display: none" ><img src="../imagenes/check2.png" width="15px;"></div></div>
    <div><span id="Est10" class="LetrasGris">Pago al vendedor</span></div>
    <div>
        <div id="Lupa10" style="display: none" onclick="Mensaje('Completada', 'Hemos pagado al vendedor', 'info');" >
        <img src="../imagenes/lupa.png" width="20px;">
        </div>
    </div>
</div>

<div class="grid-container2" id="divError" style="display: none" >
    <div><div id="ImgError" ><img src="../imagenes/denegada.png" width="20px;"></div></div>
    <div><span id="EstError" class="LetrasRojas">Mensaje de error 1</span></div>
    <div>
        <div id="LupaError" onclick="Mensaje('El producto no es correcto', 'Tu reembolso ya está listo, puedes retirarlo', 'error');" >
            <img src="../imagenes/lupa.png" width="20px;">
        </div>
    </div>

<?php //if($CuentaBancaria == false){ ?>
    <div></div>
    <div><span id="EstError" class="LetrasVerde">Retirar dinero</span></div>
    <div>
        <a href="../Cuenta/CuentaVirtual.php">
            <div id="Pregunta9" >
                <img src="../imagenes/retirar.png" width="20px;">
            </div>
        </a>
    </div>
<?php //} ?>
</div>



<div class="grid-container2" id="divError2" style="display: none" >
    <div><div id="ImgError2" ><img src="../imagenes/denegada.png" width="20px;"></div></div>
    <div><span id="EstError2" class="LetrasRojas">Mensaje de error 2</span></div>
    <div>
        <div id="LupaError2" onclick="Mensaje('Pago no correcto', 'Revisamos el pago y no está completo, por favor completa el pago', 'error');" >
            <img src="../imagenes/lupa.png" width="20px;">
        </div>
    </div>

    <div></div>
    <div><span id="EstError2" class="LetrasAmarillo">Completar pago</span></div>
    <div>
        <a href="../Comprador/CompletarPago.php?Transaccion=<?php echo $Transaccion; ?>">
            <div id="Pregunta9" >
                <img src="../imagenes/pregunta.png" width="20px;">
            </div>
        </a>
    </div>

</div>



        <form action="index.php">
			<div class="divBoton zoom">
				<input class="button" type="submit" name="" value="Aceptar">
			</div>
		</form>

        <center>
        <div class="zoom">
            <a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
        </div>
        </center>

    </div>
</div>
</body>
</html>

<script>
    $(document).ready(function(){
        Actualizar('<?php echo $Pintar; ?>', '<?php echo $Error; ?>');
    });

    function Actualizar(CuantasPintar, ErrorJava){
        //var CuantasPintar = '<?php echo $Pintar; ?>';
        for(i = 1; i <= CuantasPintar; i++){
            $("#Est" + i).removeClass('LetrasGris').addClass('LetrasAcua');
            $("#Img" + i).show();

            if(CuantasPintar == 8){
                //var CuentaBankJava = '<?php echo $CuentaBancaria; ?>';
                //if(CuentaBankJava == false){//No tiene cuenta bancaria registrada
                    $("#Est9").removeClass('LetrasGris').addClass('LetrasAmarillo');
                    $("#Pregunta9").show();
                //}
            }

        }
        $("#Lupa" + CuantasPintar).show();

        //var ErrorJava = '<?php echo $Error; ?>';
        switch(ErrorJava){
            case '6':
                $("#divError2").show();
                $("#EstError2").text("Pago no correcto");
                $("#Lupa4").hide();
                break;
            case '11':
                $("#divError").show();
                $("#EstError").text("Producto invalido");
                $("#Lupa7").hide();
                break;
            default:
                break;
        }
    }

    function Despintar(ErrorJava){
        for(i = 1; i <= 10; i++){
            $("#Est" + i).removeClass('LetrasAcua').addClass('LetrasGris');
            $("#Img" + i).hide();
            $("#Lupa" + i).hide();
            if(i == 8){
                $("#Est9").removeClass('LetrasAmarillo').addClass('LetrasGris');
                $("#Pregunta9").hide();
            }
            $("#divError2").hide();
            $("#divError").hide();
        }
    }

    function Mensaje(mensaje1, mensaje2, tipo){
        alertsweetalert2(mensaje1, mensaje2, tipo);
    }
</script>



<script>
//funcion que sirve para estar alerta de cualquier cambio
$(document).ready(function(){
    var PrimeraVez = 1;
    var starCountRef = firebase.database().ref('Transacciones/Cli_<?php echo $IDCliente; ?>/<?php echo $Transaccion; ?>');
    starCountRef.on('value', function(snapshot) {
        if(PrimeraVez != 1){
            console.log("Actualizando: " + snapshot.val());
            var est = snapshot.val();
            Pint = 0;
            err = 0;
            switch(est){
                case 2:
                    Pint = 2;
                    break;
                case 3:
                    Pint = 3;
                    break;
                case 4:
                    Pint = 4;
                    break;
                case 5:
                    Pint = 5;
                    break;
                case 7:
                    Pint = 6;
                    break;
                case 8:
                    Pint = 7;
                    break;
                case 9:
                    Pint = 8;
                    break;
                case 12:
                    Pint = 9;
                    break;
                case 10:
                    Pint = 10;
                    break;

                //Casos en los que no se completo
                case 6:
                    Pint = 4; //Vamos a pintar 4 y pago no correcto
                    err = '6'; //pago no correcto
                    break;
                case 11:
                    Pint = 7; //Vamos a pintar 8 y Producto invalido
                    err = '11'; //Producto invalido
                    break;
            }
            Despintar(err);
            Actualizar(Pint, err);
        }else{
            PrimeraVez = 0;
        }
    });
});
</script>