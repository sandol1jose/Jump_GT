<?php
session_start();//inicio de sesion
	if(!isset($_SESSION["Cliente"])){
		header('Location: Registro/index.php'); //envia a la página de inicio.
	}
 ?>

 <?php include_once 'Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Ingresar Producto</title>
	<link rel="stylesheet" type="text/css" href="css/ingresoproducto.css">
	<link rel="stylesheet" type="text/css" href="css/Less.css">
	<script src="js/general.js"></script>
	<script src="js/NuevaVisita.js"></script> <!-- Guarda la nueva visita a una página -->
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
			<h5>Ingresar Producto</h5>
		</div>
		

		<form method="POST" action="Sesiones/sesProducto.php" enctype="multipart/form-data">
			<div class="Campos">
				<div class="grid-container">
					<div class="item1"><img class="zoom" src="imagenes/url.png" width="40px"></div>
					<div class="item2">
				          <div class="Body">
				            <div class="form">
				              <input type="text" name="url" id="url" autocomplete="off" required>
				              <label class="lbl-nombre">
				                <span class="text-nomb">
				                  URL del producto en Facebook
				                </span>
				              </label>
				            </div>
				          </div>
						<!-- <input type="text" name="url" id="url" required> -->
					</div>
					<div class="item3"><img class="zoom" src="imagenes/Descripcion.png" width="40px"></div>
					<div class="item4">
				          <div class="Body">
				            <div class="form">
				              <input type="text" name="descripcion" id="descripcion" autocomplete="off" required>
				              <label class="lbl-nombre">
				                <span class="text-nomb">
				                  Nombre del producto
				                </span>
				              </label>
				            </div>
				          </div>
						<!-- <input type="text" name="descripcion" id="descripcion" required> -->
					</div>

					<div class="item5"><img class="zoom" src="imagenes/Precio.png" width="40px"></div>
					<div class="item6">
				          <div class="Body">
				            <div class="form">
				              <input type="number" name="precio" id="precio" autocomplete="off" required>
				              <label class="lbl-nombre">
				                <span class="text-nomb">
				                  Precio
				                </span>
				              </label>
				            </div>
				          </div>
					</div>

					<div class="item7"><img class="zoom" src="imagenes/Ubicacion.png" width="40px"></div>
					<div class="item8">
				          <div class="Body">
				            <div class="form">
				              <input type="text" name="direccion" id="direccion" autocomplete="off" required>
				              <label class="lbl-nombre">
				                <span class="text-nomb">
				                  Ubicación del producto
				                </span>
				              </label>
				            </div>
				          </div>
					</div>


					<div class="item9">
						<div class="form-floating">
							<textarea style="height: 80px" class="TextArea form-control" id="detalles" required></textarea>
							<label for="floatingTextarea">Detalles</label>
						</div>
						<!--
						<textarea class="TextArea" placeholder="Detalles: Ejemplo, estado actual del producto u otros aspectos que desea dar a conocer." 
						name="detalles" id="detalles" required></textarea>-->
					</div>
				</div>
			</div>

			<div class="Imagenes">
				<div class="Container2">
					<div class="Imagen1">
						<img class="zoom ImagenesFotos" onclick="BuscarArchivo('Imagen1', 'imgImagen1')" src="imagenes/foto.png" name="imgImagen1" id="imgImagen1">
						<input onchange="Cambio('Imagen1', 'imgImagen1')" hidden type="file" name="Imagen1" id="Imagen1" accept="image/*">
					</div>

					<div class="Imagen2">
						<img class="zoom ImagenesFotos" onclick="BuscarArchivo('Imagen2', 'imgImagen2')" src="imagenes/foto.png" name="imgImagen2" id="imgImagen2">
						<input onchange="Cambio('Imagen2', 'imgImagen2')" hidden type="file" name="Imagen2" id="Imagen2" accept="image/*">
					</div>

					<div class="Imagen3">
						<img class="zoom ImagenesFotos" onclick="BuscarArchivo('Imagen3', 'imgImagen3')" src="imagenes/foto.png" name="imgImagen3" id="imgImagen3">
						<input onchange="Cambio('Imagen3', 'imgImagen3')" hidden type="file" name="Imagen3" id="Imagen3" accept="image/*">
					</div>
				</div>
			</div>

			<center>
				<a href="https://youtu.be/MSfIxMoBbn8" target="_blank">Video instructivo</a><br><br>
			</center>

			<div class="divBoton zoom">
				<input disabled class="button" type="submit" name="botonEnviar" id="botonEnviar" value="Aceptar">
			</div>

			<div class="Logo zoom">
				<a href="index.php"><img src="imagenes/JUMPLogo2.png"width="40px;" /></a>
			</div>
		</form>
		

	</div>
</div>
</body>
</html>


<script type="text/javascript">
	function BuscarArchivo(idFileImagen, divImagen){
		document.getElementById(idFileImagen).click();
	}

	function Cambio(idFileImagen, divImagen){
		var $seleccionArchivos = document.getElementById(idFileImagen);
		var $imagenPrevisualizacion = document.getElementById(divImagen);
		// Los archivos seleccionados, pueden ser muchos o uno
		const archivos = $seleccionArchivos.files;
		// Si no hay archivos salimos de la función y quitamos la imagen
		if (!archivos || !archivos.length) {
		$imagenPrevisualizacion.src = "";
		return;
		}
		// Ahora tomamos el primer archivo, el cual vamos a previsualizar
		const primerArchivo = archivos[0];
		// Lo convertimos a un objeto de tipo objectURL
		const objectURL = URL.createObjectURL(primerArchivo);
		// Y a la fuente de la imagen le ponemos el objectURL
		//$imagenPrevisualizacion.style.width = 70;
		$imagenPrevisualizacion.src = objectURL;
	}


	//VERIFICANDO QUE SE HAYAN CARGADO LAS IMAGENES
	var Im1 = 0, Im2 = 0, Img3 = 0;
	$("#Imagen1").change(function(){
		if($("#Imagen1").length == 1){
			//Se cargo una imagen
			Im1 = 1;
		}else{
			//Se quito la imagen
			Im1 = 0;
			document.getElementById("botonEnviar").disabled = true;
		}
		HabilitarBoton();
    	//$("button").prop("disabled", this.files.length == 0); // Para habilitar un boton
	});
	$("#Imagen2").change(function(){
		if($("#Imagen2").length == 1){
			//Se cargo una imagen
			Im2 = 1;
		}else{
			Im2 = 0;
			document.getElementById("botonEnviar").disabled = true;
		}
		//HabilitarBoton();
	});
	$("#Imagen3").change(function(){
		if($("#Imagen3").length == 1){
			//Se cargo una imagen
			Im3 = 1;
		}else{
			Im3 = 0;
			document.getElementById("botonEnviar").disabled = true;
		}
		HabilitarBoton();
	});

	function HabilitarBoton(){
		if(Im1 == 1 && Im2 == 1 && Im3 == 1){
			//Estan cargadas todas las imagenes
			document.getElementById("botonEnviar").disabled = false;
		}else{
			document.getElementById("botonEnviar").disabled = true;
		}
	}


// Escuchar cuando cambie
/*
$seleccionArchivos.addEventListener("change", () => {
	// Los archivos seleccionados, pueden ser muchos o uno
	const archivos = $seleccionArchivos.files;
	// Si no hay archivos salimos de la función y quitamos la imagen
	if (!archivos || !archivos.length) {
	$imagenPrevisualizacion.src = "";
	return;
	}
	// Ahora tomamos el primer archivo, el cual vamos a previsualizar
	const primerArchivo = archivos[0];
	// Lo convertimos a un objeto de tipo objectURL
	const objectURL = URL.createObjectURL(primerArchivo);
	// Y a la fuente de la imagen le ponemos el objectURL
	$imagenPrevisualizacion.src = objectURL;
});*/

</script>


<script>
	document.getElementById('Imagen1').addEventListener('change', (e) => {
		ProcesarImagen('Imagen1', 'imgImagen1', e, 1);
	});

	document.getElementById('Imagen2').addEventListener('change', (e) => {
		ProcesarImagen('Imagen2', 'imgImagen2', e, 2);
	});

	document.getElementById('Imagen3').addEventListener('change', (e) => {
		ProcesarImagen('Imagen3', 'imgImagen3', e, 3);
	});
</script>

<script src="Libraries/compressorjs-master/docs/js/compressor.js"></script>
<script  src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"> </script>
<script>
	//COMPRIMIR IMAGENES ANTES DE SUBIR
function  ProcesarImagen(NameInputFile, NameImage, e, img_var) {
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
        formData.append("Imagen", result, result.name);
		formData.append("NumeroImagen", img_var);
		formData.append('Modo', '1'); //Imagenes Producto

        let config = {
            header : {
            'Content-Type' : 'multipart/form-data'
            }
        }
        
        axios.post('Sesiones/RecibirImagen.php', formData, config).then((response) => {
            console.log('Upload success');
			document.getElementById(NameInputFile).value = null;
            //console.log(response.data);
        }).catch(error => {
            console.log('error', error)
        });

    },
    error(err) {
      console.log(err.message);
      document.getElementById(NameInputFile).value = null;
	  switch(img_var){
		case 1:
			Im1 = 0;
			break;
		case 2:
			Im2 = 0;
			break;
		case 3:
			Im3 = 0;
			break;
	  }
	  HabilitarBoton();
	  document.getElementById(NameImage).src = "imagenes/foto.png";
	  alertsweetalert2('Error', 'Por favor carga una imagen', 'error');
    },
  });
}
</script>