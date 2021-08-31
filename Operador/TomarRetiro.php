<?php
session_start();//inicio de sesion
	if(!isset($_SESSION["Operador"])){
		header('Location: index.php'); //envia a la página de inicio.
	}
?>
<?php 
	include_once "../conexion.php";

    if(!isset($_GET["IDRetiro"])){
        header("Location: transacciones.php");
    }
    $IDRetiro = $_GET["IDRetiro"];
    $IDOperador = $_SESSION["Operador"]["IDOperador"];

    //Tomando la solicitud de retiro
	$sql = "UPDATE retiro SET f_operador = '".$IDOperador."', f_estadoretiro = 2 WHERE id = '".$IDRetiro."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute();

	$sql = "SELECT e.id IDEstadodecuenta, e.saldo, r.monto MontoRetiro, r.fechasolicitud, c.numerodecuenta, 
    c.nombre, c.f_banco, R.banco,
    CONCAT(clie.nombres, ' ', clie.apellidos) cliente
    FROM estadodecuenta e
    JOIN retiro r ON r.f_estadodecuenta = e.id
    JOIN cuentabancaria c ON c.id = r.f_cuentabancaria
    JOIN cliente clie ON c.f_cliente = clie.id 
    WHERE r.id = '".$IDRetiro."'";
	$sentencia = $base_de_datos->prepare($sql);
	$sentencia->execute(); 
	$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    foreach($registros as $reg){
        $saldoCuenta = number_format($reg["saldo"], 2);
        $MontoRetiro = number_format($reg["MontoRetiro"], 2);
        $MontoRetiroNormal = $reg["MontoRetiro"];
        $fechasolicitud = $reg["fechasolicitud"];
        $IDEstadodecuenta = $reg["IDEstadodecuenta"];
        $numerodecuenta = $reg["numerodecuenta"];
        $nombre = $reg["nombre"];
        $f_banco = $reg["f_banco"];
        $NombreBanco = $reg["banco"];
        $cliente = $reg["cliente"];
    }
?>

<?php include_once '../Templates/Cabecera.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Tomar Retiro</title>

    <script src="../js/general.js"></script>
</head>
<body>

<?php
	if(isset($_SESSION['Alerta'])){
		$Alerta = $_SESSION['Alerta'];
		if (strcmp($Alerta, "Logout") === 0){
			echo "<script> alertsweetalert2('Has salido de tu cuenta', '', 'success'); </script>";
		}
		unset($_SESSION["Alerta"]);
	}
?>


<h1>Realizar retiro</h1>

<?php if($MontoRetiro <= $saldoCuenta){ ?>

    <table class="table table-striped">
        <tr>
            <th>Saldo Cuenta:</th>
            <td>Q. <?php echo $saldoCuenta; ?></td>
        </tr>

        <tr>
            <th>Solicitud de retiro:</th>
            <td>Q. <?php echo $MontoRetiro; ?></td>
        </tr>

        <tr>
            <th>Fecha de solicitud:</th>
            <td>Q. <?php echo $fechasolicitud; ?></td>
        </tr>

        <tr>
            <th>No. Cuenta:</th>
            <td><?php echo $numerodecuenta; ?></td>
        </tr>

        <tr>
            <th>A nombre de:</th>
            <td><?php echo $nombre; ?></td>
        </tr>

        <tr>
            <th>Banco:</th>
            <td><?php echo $NombreBanco; ?></td>
        </tr>

        <tr>
            <th>Cliente:</th>
            <td><?php echo $cliente; ?></td>
        </tr>
    </table>

    <form action="app/ProcesarRetiro.php" method="POST" name="formulario">

        boleta:<br>
        <input type="number" name="boleta"><br><br>

        Fecha y hora del deposito:<br>
        <input type="datetime-local" name="fechaDeposito" id=""><br><br>

        Monto Depositado:<br>
        <input type="number" name="MontoDepositado" id="MontoDepositado" value="">

        <input type="hidden" name="IDRetiro" value="<?php echo $IDRetiro; ?>">
        <input type="hidden" name="IDEstadodecuenta" value="<?php echo $IDEstadodecuenta; ?>">
        <input type="hidden" name="MontoRetiro" id="MontoRetiro" value="<?php echo $MontoRetiroNormal; ?>">

        <br><br>
        

    </form>

    <button onclick="EnviarForm()">Enviar</button>

<?php }else{ ?>

<h2>No hay fondos suficientes</h2>

<?php } ?>
   
</body>
</html>



<script>

    function EnviarForm(){
        var MontoDepositado = document.getElementById("MontoDepositado").value;
        var MontoRetiro = document.getElementById('MontoRetiro').value;
        if(MontoDepositado == MontoRetiro){
            console.log("Son iguales");
            document.formulario.submit();
        }else{
            console.log("No son iguales");
            alertsweetalert2('Error', 'El monto del deposito no es igual al retiro solicitado', 'error');
        }
    }

</script>