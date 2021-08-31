<?php
session_start();//inicio de sesion
	include_once "../conexion.php";

  if(!isset($_POST["Transaccion"])){
    echo "<script>window.history.back(-1)</script>"; //Regresamos a la pagina anterior
  }else{
    $Transaccion = $_POST["Transaccion"];
  }
	
 ?>

 <?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Envio del producto</title>
	<link rel="stylesheet" type="text/css" href="css/EnviarProducto.css">
	<link rel="stylesheet" type="text/css" href="../css/Master.css">
  <link rel="stylesheet" type="text/css" href="../css/Less.css">
  <link rel="stylesheet" type="text/css" href="../Registro/css/select.css">

    <script src="../js/general.js"></script>
</head>
<body>  

<?php
	if(isset($_SESSION['Alerta'])){
		$Alerta = $_SESSION['Alerta'];
		if (strcmp($Alerta, "ImagenNo") === 0){
			echo "<script> alertsweetalert2('Error', 'Por favor carga una imagen', 'error'); </script>";
		}
		unset($_SESSION["Alerta"]);
	}
?>


<div class="base">
	<div class="Hijo">
		<div class="Titulo">
			<h5>Envio de Producto</h5>
		</div>

        
		<div class="SubTitulo2">
			<h4>Agregar datos de envío</h4>
			<p>Ingresa los datos que se te solicitan</p>	
		</div>
        
        <center>
        <label style="font-size: 12px;" for="">Selecciona cómo enviaste el producto</label>

      <div class="divSelect" style="width: 70%;">
        <select style="width: 85%;" class='SelectVisual' name="Sel" id="Sel" onchange="MostrarDiv();">
            <option value="0">Seleccionar opcion</option>
            <option value="1">Envié por Transporte</option>
            <option value="2">Entregué en oficinas</option>
        </select>
      </div>
        
        <br>

<div id="CargoEspreso" style="display: none;" >
  <form method="POST" enctype="multipart/form-data" action="../app/AgregarNumeroGuia.php">
    <br>
    <div class="Body">
      <div class="form">
        <input type="text" name="Numero" id="Numero" autocomplete="off" required>
        <label class="lbl-nombre">
          <span class="text-nomb">
            No. de guía
          </span>
        </label>
      </div>
    </div>
    <br><br>

    <span>Subir fotografia</span>
    <input type="file" id="Comprobante" name="Comprobante">

    <input hidden type="text" name="Transaccion" value="<?php echo $Transaccion ?>">
    <input hidden type="text" name="Modo" value="1">

    <div class="Imagen zoom">
      <img src="../imagenes/Envio.png" width="50px">
    </div>

    <div class="divBoton zoom">
      <input class="button" type="submit" name="" value="Siguiente">
    </div>

  </form>
</div>   

    <div id="Oficinas" style="display: none;">
      <label style="font-size: 12px;" for="">Cuando entregues el producto en las oficinas, se te entregara un comprobante</label>
      <div class="Imagen zoom">
			  <img src="../imagenes/Envio.png" width="50px">
		  </div>
        <!--  
        <form method="POST" enctype="multipart/form-data" action="../app/AgregarNumeroGuia.php">
            <span>No de entrega Jump</span><br>
            <label style="font-size: 12px;" for="">Número de entrega proporcionado por Jump</label>
            <br><br>
            <div class="Body">
              <div class="form">
                <input type="text" name="Numero" autocomplete="off" required>
                <label class="lbl-nombre">
                  <span class="text-nomb">
                    No de entrega Jump
                  </span>
                </label>
              </div>
            </div><br><br>


			      <input hidden type="text" name="Transaccion" value="<?php echo $Transaccion ?>">
            <input hidden type="text" name="Modo" value="2">
			
            <div class="Imagen zoom">
			      <img src="../imagenes/Envio.png" width="50px">
		    </div>

			<div class="divBoton zoom">
				<input class="button" type="submit" name="" value="Siguiente">
			</div>
      -->
		</form>
    </div>


    </center>
		<div class="Logo zoom">
			<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
		</div>
	</div>
</div>
</body>
</html>



<script>

    function MostrarDiv() {
        switch($("#Sel").val()){
            case '0':
                $("#CargoEspreso").hide();
                $("#Oficinas").hide();
                break;
            case '1':
                $("#CargoEspreso").show();
                $("#Oficinas").hide();
                break;
            case '2':
                $("#Oficinas").show();
                $("#CargoEspreso").hide();
                break;
        }
    }

</script>



<script src="../Libraries/compressorjs-master/docs/js/compressor.js"></script>
<script  src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"> </script>
<script>
document.getElementById('Comprobante').addEventListener('change', (e) => {
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
		    formData.append('Modo', '3'); //Numero de Guia

        let config = {
            header : {
            'Content-Type' : 'multipart/form-data'
            }
        }
        
        axios.post('../Sesiones/RecibirImagen.php', formData, config).then((response) => {
            console.log('Upload success');
			      //document.getElementById('Comprobante').value = result;
            //console.log(response.data);
        }).catch(error => {
            console.log('error', error)
        });

    },
    error(err) {
      console.log(err.message);
      document.getElementById('Comprobante').value = null;
	    alertsweetalert2('Error', 'Por favor carga una imagen', 'error');
    },
  });
});
</script>