<?php
session_start();//inicio de sesion
include_once "../conexion.php";
	if(!isset($_SESSION["Cliente"])){ //Si esta registrado
        header('Location: ../index.php'); //envia a la página de inicio.
	}

    $IDCliente = $_SESSION["Cliente"]["IDCliente"];

    //Buscando las cuentas del cliente
    $sql = "SELECT c.id IDCuenta, c.numerodecuenta, b.nombrebanco, b.id IDBanco 
    FROM cuentabancaria c
    JOIN banco b ON c.f_banco = b.id 
    WHERE c.f_cliente = '".$IDCliente."';";
    $sentencia = $base_de_datos->prepare($sql);
    $sentencia->execute();
    $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $cont = count($registros);

    //Buscando el saldo que el cliente tiene
    $sql2 = "SELECT e.saldo, e.id FROM estadodecuenta e WHERE e.f_cliente = '".$IDCliente."';";
    $sentencia2 = $base_de_datos->prepare($sql2);
    $sentencia2->execute();
    $registros2 = $sentencia2->fetchAll(PDO::FETCH_ASSOC);
    $Resultados = count($registros2); //para saber si hay registros
    if($Resultados > 0){
        foreach($registros2 as $reg){
            $Saldo = number_format($reg["saldo"], 2); //colocando 2 decimales
            $SaldoNormal = $reg["saldo"];
            $IDEstadoCuentaBancaria = $reg["id"];
        }
    }else{
        $Saldo = number_format(0, 2); //colocando 2 decimales
        $SaldoNormal = 0;
        $IDEstadoCuentaBancaria = 0;
    }
?>
<?php include "../app/app_registro.php"; ?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Cuenta Virtual</title>
	<link rel="stylesheet" type="text/css" href="../css/registro.css">
	<link rel="stylesheet" type="text/css" href="../Registro/css/select.css">
	<link rel="stylesheet" type="text/css" href="../Registro/Less.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <script src="../js/general.js"></script>

    <style>
        .divInput{
	        text-align: center;
	        font-size: 30px;
	        height: 120px;
        }

        .Input{
            border: none;
            font-size: 50px;
            outline:none;
            background-color: transparent;
            font-weight: bold;
            color: rgb(21, 61, 170)
        }
    </style>
</head>
<body>

<script> alertsweetalert2('Bienvendio a tu cuenta virtual', 'Aqui puedes ver y retirar el dinero que tienes en Jump', 'info'); </script>

<div class="base">
	<div class="Hijo">
	<div class="Titulo" style="border-bottom: 2px solid #616161;">
		<h5>Cuenta Virtual</h5>
	</div>
    <br>

    <center>
    <!-- 
	<p style="font-size: 12px;">Bienvenido a tu cuenta virtual, aqui puedes ver el dinero que tienes en Jump.</p> -->
    
    Saldo:<p class="Input">Q. <?php echo $Saldo; ?></p>

	<p style="font-size: 12px;">Selecciona una cuenta bancaria para retirar tu dinero</p>
    </center>

<form action="../app/SolicitudDeRetiro.php" method="POST" name="formulario">

    <table class="table table-dark">
        <tr>
            <th>#</th>
            <th>Cuenta</th>
            <th>Banco</th>
        </tr>

    <?php foreach ($registros as $reg) { ?>
        <tr>
            <td>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="radio" name="IDCuentaBancaria" value="<?php echo $reg["IDCuenta"]; ?>">
                </div>
            </td>
            <td><?php echo $reg["numerodecuenta"]; ?></td>
            <td><?php echo $reg["nombrebanco"]; ?></td>
        </tr>

    <?php } ?>

        <tr>
            <td colspan="3"><a class="btn btn-success" href="../Vendedor/AgregarCuentaBancaria.php?Modo=Comprador">Agregar Cuenta</a></td>
        </tr>
    </table>

    <div class="mb-3">
        <label class="form-label" style="font-size: 14px;">Monto a retirar</label>
        <input type="number" class="form-control" name="monto" id="monto" required>
        <div class="form-text" style="font-size: 12px;">Escribe el monto que deseas retirar</div>
    </div>

    <input type="hidden" name="IDEstadoCuentaBancaria" value="<?php echo $IDEstadoCuentaBancaria; ?>">
    <input type="hidden" name="saldo" value="<?php echo $SaldoNormal; ?>">

    <!--  
    <center>
        <img src="../imagenes/Map2.gif" width="100px;">
    </center>-->
</form>
    <br>
    <div class="divBoton">
        <button class="button" name="botonEnviar" id="botonEnviar" onclick="EnviarForm();">Solicitar Retiro</button>
    </div>


    <center>
    <p style="font-size: 12px;">El retiro puede demorar 24 horas hábiles desde que solicitas el retiro hasta 
    llegar a tu cuenta de banco.</p>
    </center>

    <div class="Logo">
        <a href="../index.php"><img src="../imagenes/JUMPLogo2.png" width="40px;" /></a>
    </div>

</div>

</body>
</html>


<script>
    function EnviarForm(){
        var SaldoCuenta = parseFloat('<?php echo $SaldoNormal; ?>');
        var MontoARetirar = document.getElementById('monto').value;
        if(SaldoCuenta >= MontoARetirar && SaldoCuenta != 0){
            document.formulario.submit();
        }else{
            alertsweetalert2('Error', 'No tienes fondos suficientes', 'error');
        }
    }
</script>