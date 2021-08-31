<?php
session_start();//inicio de sesion
	if(!isset($_SESSION["Cliente"])){ //Si esta registrado
        header('Location: ../index.php'); //envia a la página de inicio.
	}
?>
<?php include "../app/app_registro.php"; ?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Nueva Dirección</title>
	<link rel="stylesheet" type="text/css" href="../css/registro.css">
	<link rel="stylesheet" type="text/css" href="../Registro/css/select.css">
	<link rel="stylesheet" type="text/css" href="../Registro/Less.css">

    <script src="../js/general.js"></script>
</head>
<body>


<?php
	if(isset($_SESSION["Alerta"])){
		$Alerta = $_SESSION["Alerta"];
		if (strcmp($Alerta, "CompletaCampos") === 0){
			echo "<script> alertsweetalert2('Por favor selecciona un departamento y municipio', '', 'error'); </script>";
		}
		unset($_SESSION["Alerta"]);
	}
?>

<div class="base">
	<div class="Hijo">
	<div class="Titulo">
		<h5>Agregar dirección</h5>
	</div>

	<p style="font-size: 12px;">Debes agregar la dirección donde quieres recibir tu producto</p>

	<form method="POST" enctype="multipart/form-data" action="../app/AgregarDireccion.php">
		<div class="Campos">
			<table>
                <tr>
					<td width="45%">
						<div class="divSelect">
							<a id="SelectDepartamento">
								<?php BuscarDepartamentos(); ?>
							</a>
						</div>
					</td>
					<td width="10%">
					</td>
					<td width="45%">
						<div class="divSelect">
							<a id="demo">
								<?php BuscarMunicipios(); ?>
							</a>
						</div>
					</td>
				</tr>

				<tr>
					<td colspan="3">
			          <div class="Body">
			            <div class="form">
			              <input type="text" name="dire1" id="dire1" autocomplete="off" required>
			              <label class="lbl-nombre">
			                <span class="text-nomb">
                                Dirección 1
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
			              <input type="text" name="dire2" id="dire2" autocomplete="off" required="false">
			              <label class="lbl-nombre">
			                <span class="text-nomb">
			                  Dirección 2
			                </span>
			              </label>
			            </div>
			          </div>
					</td>
				</tr>
			</table>
		</div>

		<center>
			<img src="../imagenes/Map2.gif" width="100px;">
		</center>
        <br>
		<div class="divBoton">
			<input class="button" type="submit" name="botonEnviar" id="botonEnviar" value="Guardar">
		</div>

		<center>
			<a style="font-size: 12px;">Recuerda agregar una dirección muy bien especificada para poder entregar tu producto con éxito</a>
		</center><br>

		<div class="Logo">
			<a href="../index.php"><img src="../imagenes/JUMPLogo2.png" width="40px;" /></a>
		</div>
	</form>
	</div>



</div>

</body>
</html>


<script>
	function BuscarMunicipios(){
		//Cargamos los municipios cuando se selecciona un departamento
		var Departamento = $('#Departamento').val();
		$.ajax({
			type: "POST",
			url: "BuscarMunicipios.php",
			data: {'Departamento': Departamento},
			dataType: "html",
			beforeSend: function(){
			},
			error: function(){
				console.log("error petición ajax");
			},
			success: function(data){
				document.getElementById("demo").innerHTML = data;
			}
		});
	}
</script>