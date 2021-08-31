<?php include "../app/app_registro.php"; ?>
<?php include_once '../Templates/Cabecera.php'; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Registro de usuarios</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/registro.css">
	<link rel="stylesheet" type="text/css" href="css/select.css">
	<link rel="stylesheet" type="text/css" href="Less.css">
	<script src="../js/general.js"></script>
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
		<h5>Completar datos</h5>
	</div>

	<p style="font-size: 12px;">Por ser tu primera transacción, debes completar estos datos</p>

	<form method="POST" enctype="multipart/form-data" action="../app/CompletarUsuario.php">
		<div class="Campos">
			<table>
				<tr>
					<td colspan="3">
			          <div class="Body">
			            <div class="form">
			              <input onkeyup='PrimeraMayuscula("nombre");' type="text" name="nombre" id="nombre" autocomplete="off" required>
			              <label class="lbl-nombre">
			                <span class="text-nomb">
			                  Nombres
			                </span>
			              </label>
			            </div>
			          </div>
					</td>
				</tr>

				<tr>
					<td colspan="3">
			          <div class="Body">
			            <div class="form">
			              <input onkeyup='PrimeraMayuscula("apellido");' type="text" name="apellido" id="apellido" autocomplete="off" required>
			              <label class="lbl-nombre">
			                <span class="text-nomb">
			                  Apellidos
			                </span>
			              </label>
			            </div>
			          </div>
					</td>
				</tr>

				<tr>
					<td colspan="3">
			          <div class="Body">
			            <div class="form">
			              <input type="text" onblur="VerificarDPI()"; onkeyup="BorrarEspacios()" onkeydown="" name="DPI" id="DPI" autocomplete="off" required>
			              <label class="lbl-nombre">
			                <span class="text-nomb">
			                  DPI
			                </span>
			              </label>
			            </div>
			          </div>
					</td>

					<!--
					<td>
						<input type="file" name="imgDPI" id="imgDPI">
					</td>-->
				</tr>

				<tr>
					<td width="80%">
						<div class="divCalendar">
							<input class="Calendar" placeholder="fechanacimiento" type="date" name="fechanacimiento" id="fechanacimiento">
						</div>
					</td>

					<td width="10%"></td>

					<td width="10%">
						<div style="text-align: center; padding-top: 5px;">
							<img id="imgbebe" src="../imagenes/bebe1.png" width="30px;">
						</div>
					</td>
				</tr>

				<tr>
					<td colspan="3">
			          <div class="Body">
			            <div class="form">
			              <input type="text" name="telefono" id="telefono" autocomplete="off" required>
			              <label class="lbl-nombre">
			                <span class="text-nomb">
			                  Telefono
			                </span>
			              </label>
			            </div>
			          </div>
					</td>
				</tr>

				<tr>
					<td colspan="3">
						<div class="divSelect">
								<select class='SelectVisual' name="genero" id="genero">
									<option value="Masculino">Masculino</option>
									<option value="Femenino">Femenino</option>
								</select>
						</div>
					</td>
				</tr>
			</table>

		</div>

		<div class="ImagenDPI">
			<input hidden type="file" name="imgDPI" id="imgDPI">
			<img id="imagen" name="imagen" src="../imagenes/carne-de-identidad.png" width="50px;" onclick="BuscarArchivo()">
			<a style="font-size: 12px;">Presiona para subir DPI <a style="font-size: 8px;"> (Documento Personal de Identificación)</a></a>
		</div>

		<div class="divBoton">
			<input disabled class="button" type="submit" name="botonEnviar" id="botonEnviar" value="Enviar">
		</div>

		<center>
			<a style="font-size: 12px;">Éstos datos son para la seguridad de la transacción,
			en ningún momento la información de tu DPI -Documento Personal de Identificación- es compartida con otro usuario.</a>
		</center><br>

		<div class="Logo">
			<a href="../index.php"><img src="../imagenes/JUMPLogo2.png"width="40px;" /></a>
		</div>
	</form>
	</div>



</div>

</body>
</html>

<script type="text/javascript">


	function BuscarArchivo(){
		console.log("Estmaos buscando el archivo");
		document.getElementById("imgDPI").click();
	}
/*
	function CambiarImagen(){
		console.log("Debemos cambiar la imagen");
		var urlimagen = document.getElementById('imgDPI').files[0].name;
		console.log(urlimagen);
		//document.getElementById("imagen").src = urlimagen;
	}*/

const $seleccionArchivos = document.querySelector("#imgDPI"),
  $imagenPrevisualizacion = document.querySelector("#imagen");

// Escuchar cuando cambie
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
});

</script>

<script type="text/javascript">

	function BorrarEspacios(){
		var DPI = document.getElementById("DPI").value;
		DPI = DPI.replace(" ", "");
		document.getElementById("DPI").value = DPI;
	}

	function VerificarDPI(){
		var DPI = document.getElementById("DPI").value;
		if(DPI != ''){
			if(!isNaN(DPI)){
				if(DPI.length == 13){
					var arrayDPIS = [
					'101', '102', '103', '104', '105', '106', '107', '108',
					'109', '110', '111', '112', '113', '114', '115', '116',
					'117', '201', '202', '203', '204', '205', '206', '207',
					'208', '301', '302', '303', '304', '305', '306', '307',
					'308', '309', '311', '312', '313', '314', '315', '316',
					'401', '402', '403', '404', '405', '406', '407', '408',
					'409', '410', '411', '412', '413', '414', '415', '416',
					'501', '502', '503', '504', '505', '506', '507', '508',
					'509', '510', '511', '512', '513',
					'601', '602', '603', '604', '605', '606', '607', '608',
					'609', '610', '611', '612', '613', '614',
					'701', '702', '703', '704', '705', '706', '707', '708',
					'709', '710', '711', '712', '713', '714', '715', '716',
					'717', '718', '719',
					'801', '802', '803', '804', '805', '806', '807', '808',
					'901', '902', '903', '904', '905', '906', '907', '908',
					'909', '910', '911', '912', '913', '914', '915', '916',
					'917', '918', '919', '920', '921', '922', '923', '924',

					'1001', '1002', '1003', '1004', '1005', '1006', '1007', '1008',
					'1009', '1010', '1011', '1012', '1013', '1014', '1015', '1016',
					'1017', '1018', '1019', '1020', 
					'1101', '1102', '1103', '1104', '1105', '1106', '1107', '1108',
					'1109',
					'1201', '1202', '1203', '1204', '1205', '1206', '1207', '1208',
					'1209', '1210', '1211', '1212', '1213', '1214', '1215', '1216',
					'1217', '1218', '1219', '1220', '1221', '1222', '1223', '1224',
					'1225', '1226', '1227', '1228', '1229',
					'1301', '1302', '1303', '1304', '1305', '1306', '1307', '1308',
					'1309', '1310', '1311', '1312', '1313', '1314', '1315', '1316',
					'1317', '1318', '1319', '1320', '1321', '1322', '1323', '1324',
					'1325', '1326', '1327', '1328', '1329', '1330', '1331',
 					'1401', '1402', '1403', '1404', '1405', '1406', '1407', '1408',
 					'1409', '1410', '1411', '1412', '1413', '1414', '1415', '1416',
 					'1417', '1418', '1419', '1420', '1421',
					'1501', '1502', '1503', '1504', '1505', '1506', '1507', '1508',
					'1601', '1602', '1603', '1604', '1605', '1606', '1607', '1608', 
					'1609', '1610', '1611', '1612', '1613', '1614', '1615', '1616',
					'1701', '1702', '1703', '1704', '1705', '1706', '1707', '1708', 
					'1709', '1710', '1711', '1712',
					'1801', '1802', '1803', '1804', '1805',
					'1901', '1902', '1903', '1904', '1905', '1906', '1907', '1908', 
					'1909', '1910',
					'2001', '2002', '2003', '2004', '2005', '2006', '2007',
					'2008', '2009', '2010', '2011',
					'2101', '2102', '2103', '2104', '2105', '2106', '2107',
					'2201', '2202', '2203', '2204', '2205', '2206', '2207', '2208', 
					'2209', '2210', '2211', '2212', '2213', '2214', '2215', '2216', 
					'2217'
					];

					var EsDPI = 0;
					if(VerificarUltimosDigitos(-4, DPI, arrayDPIS) == 1){
						var EsDPI = 1;
					}else if(VerificarUltimosDigitos(-3, DPI, arrayDPIS) == 1){
						var EsDPI = 1;
					}

					if(EsDPI == 1){
						console.log("SI ES UN DPI");
					}else{
						document.getElementById("DPI").value = "";
						alert("El número ingresado no es un DPI");
					}
				}else{
					document.getElementById("DPI").value = "";
					alert("Un DPI debe tener 13 números");
				}
			}else{
				document.getElementById("DPI").value = "";
				alert("Solo ingresa numeros por favor");
			}
		}
	}

	function VerificarUltimosDigitos(NumeroDigitos, DPI, arrayDPIS){
		DPI = DPI.substr(NumeroDigitos); //Verificamos los últimos dijitos
		var EsDPI = 0;
		for (i = 0; i < arrayDPIS.length; i++) {
			if(DPI == arrayDPIS[i])	{
				EsDPI = 1;
			}
		}
		return EsDPI;
	}

</script>



<script>
	$("#imgDPI").change(function(){
		if($("#imgDPI").length == 1){
			//Se cargo una imagen
			document.getElementById("botonEnviar").disabled = false;
		}else{
			//Se quito la imagen
			document.getElementById("botonEnviar").disabled = true;
		}
	});


	function PrimeraMayuscula(idinput){
		var nombre = document.getElementById(idinput).value;
		nombre = nombre.replace(/\b[a-z]/g,c=>c.toUpperCase());
		document.getElementById(idinput).value = nombre;
	}
</script>




<script src="../Libraries/compressorjs-master/docs/js/compressor.js"></script>
<script  src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"> </script>
<script>
document.getElementById('imgDPI').addEventListener('change', (e) => {
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
		formData.append('Modo', '2'); //Imagen DPI

        let config = {
            header : {
            'Content-Type' : 'multipart/form-data'
            }
        }
        
        axios.post('../Sesiones/RecibirImagen.php', formData, config).then((response) => {
            console.log('Upload success');
			document.getElementById('imgDPI').value = null;
            //console.log(response.data);
        }).catch(error => {
            console.log('error', error)
        });

    },
    error(err) {
      console.log(err.message);
      document.getElementById('imgDPI').value = null;
	  document.getElementById("imagen").src = "../imagenes/carne-de-identidad.png";
	  document.getElementById("botonEnviar").disabled = true; //Desactivamos el boton
	  alertsweetalert2('Error', 'Por favor carga una imagen', 'error');
    },
  });
});
</script>