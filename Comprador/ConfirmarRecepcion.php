<?php
session_start();//inicio de sesion
	if(!isset($_SESSION["Cliente"])){
		header('Location: ../Registro/index.php'); //envia a la página de inicio.
	}

    $Transaccion = $_GET["Transaccion"];
?>
<?php include_once '../Templates/Cabecera.php'; ?>
<?php include "../app/app_registro.php"; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Recepcion del producto</title>
	<link rel="stylesheet" type="text/css" href="../Vendedor/css/EnviarProducto.css">
    <script src="../js/VerificarBanco.js"></script>

    <script src="../js/general.js"></script>
</head>
<body>
<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Recepción de producto</h5>
		</div>

		<div class="SubTitulo2">
			<h4>Recibi el producto</h4>
		</div>

		<div class="Texto">
			<h6>¿Confirmas que has recibido el producto?</h6>
		</div>

        <center>
            <img src="../imagenes/Caja-unscreen2.gif" alt="" width="150px;">
        </center>

        <div class="divBoton zoom">
			<input class="button" type="submit" name="" value="SI" onclick="Preguntar();">
		</div>

        <br>
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
    function Preguntar(){
        Swal.fire({
        title: '¿Estas seguro?',
        text: 'Confirmas que has recibido tu producto?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No',
        confirmButtonText: 'Si'
      }).then((result) => {
        if (result.isConfirmed) {
            location.href ="ConfirmaRecibido.php?Transaccion=<?php echo $Transaccion; ?>";
        }
      })
    }
</script>