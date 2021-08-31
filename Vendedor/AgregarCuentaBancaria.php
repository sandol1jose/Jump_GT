<?php
session_start();//inicio de sesion
	if(!isset($_SESSION["Cliente"])){
		header('Location: ../Registro/index.php'); //envia a la página de Registro.
	}

    if(!isset($_GET["Modo"])){
        header('Location: ../indexLogeo.php'); //envia a la página de inicio.
    }

    $Modo = $_GET["Modo"]; //Para Saber si es comprador o vendedor
?>
<?php include_once '../Templates/Cabecera.php'; ?>
<?php include "../app/app_registro.php"; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Agregar Cuenta Bancaria</title>
	<link rel="stylesheet" type="text/css" href="css/EnviarProducto.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">


    <script src="../js/VerificarBanco.js"></script>
</head>
<body>
<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Cuenta Bancaria</h5>
		</div>

		<div class="SubTitulo2">
			<h4>Agregar cuenta</h4>
            <?php if($Modo == "Comprador"){ ?>
			    <p>Servirá para reembolsarte el monto de una compra que no se completó</p>
            <?php }else{ ?>
                <p>Servirá para depositarte el monto de tus ventas</p>
            <?php } ?>
		</div>

		<div class="Texto">
			<h6>Por favor selecciona el banco, ingresa el número de cuenta y nombre.</h6>
		</div>

    <form method="POST" action="../app/NuevaCuentaBancaria.php">
        <div>
            <br>
                <label class="form-label" style="font-size: 14px;">Estado</label>
                <div style="padding-bottom: 18px;">
                    <?php BuscarBancos2(); ?>
                </div>
            <!--  
            <label>Banco</label><br>
            <div class="divSelect">
                <a id="SelectBanco">
                    <?php BuscarBancos(); ?>
                </a>
            </div><br>-->

            <div class="mb-3">
                <label class="form-label" style="font-size: 14px;">Numero de cuenta</label>
                <input onchange="VerificarBanco('cuenta', 'banco');" type="number" class="form-control" name="cuenta" id="cuenta" required>
            </div>

            <div class="mb-3">
                <label class="form-label" style="font-size: 14px;">A nombre de</label>
                <input class="form-control" onkeyup="Mayuscula('nombrecuenta');" type="text" id="nombrecuenta" name="nombrecuenta" required autocomplete="off">
            </div>

            <input type="hidden" id="Modo" name="Modo" value="<?php echo $Modo; ?>">

            <!--  
            <label>Numero de cuenta</label><br>
            <input onchange="VerificarBanco('cuenta', 'banco');" type="number" id="cuenta" name="cuenta"><br><br>
            <label>A nombre de</label><br>
            <input onkeyup="Mayuscula('nombrecuenta');" type="text" id="nombrecuenta" name="nombrecuenta"><br>-->
        </div>

        <div class="divBoton zoom">
			<input class="button" type="submit" name="" value="Siguiente">
		</div>
    </form>

	</div>
</div>
</body>
</html>



<script>
    function Mayuscula(IDInput){
        var text = document.getElementById(IDInput).value;
        text = text.toUpperCase();
        document.getElementById(IDInput).value = text;
    }
</script>