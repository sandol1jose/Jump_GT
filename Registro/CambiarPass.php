<?php
session_start();
?>
<?php include "../app/app_registro.php"; ?>
<?php include_once '../Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Restablecer su contraseña</title>

	<link rel="stylesheet" type="text/css" href="../css/registro.css">
	<link rel="stylesheet" type="text/css" href="Less.css">
	<script src="../js/general.js"></script>
</head>
<body>

<?php
	if(isset($_SESSION["Alerta"])){
		$Alerta = $_SESSION["Alerta"];
		if(strcmp($Alerta, 'CodpassSend') === 0){
			echo "<script> alertsweetalert2('Enviamos un código a tu correo', '', 'success'); </script>";
		}else if(strcmp($Alerta, 'CodPassIncorrect') === 0){
            echo "<script> alertsweetalert2('Error', 'El código es incorrecto', 'error'); </script>";
        }
		unset($_SESSION["Alerta"]);
	}
?>

<div class="base">
	<div class="Hijo">
	<div class="Titulo">
		<h5>Restablecer su contraseña</h5>
	</div>

    <br>
	<form method="POST" enctype="multipart/form-data" action="../app/CambiarPass.php">
		<div class="Campos">
			<center>
			<table>
                <h6 style="font-size: 15px;">Copie el código de restablecimiento de su correo electrónico y péguelo a continuación.</h6>
                <tr>
					<td colspan="3">
			          <div class="Body">
			            <div class="form">
			              <input style="text-transform:uppercase" type="text" name="codigo" id="codigo" autocomplete="off" required>
			              <label class="lbl-nombre">
			                <span class="text-nomb">
			                  Codigo
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
			              <input onkeyup="verificarContrasenia();" type="password" name="pass" id="pass" autocomplete="off" required>
			              <label class="lbl-nombre">
			                <span class="text-nomb">
			                  Contraseña nueva
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
			              <input onkeyup="verificarContrasenia();" type="password" name="pass2" id="pass2" autocomplete="off" required>
			              <label class="lbl-nombre">
			                <span class="text-nomb">
			                  Confirmar contraseña
			                </span>
			              </label>
			            </div>
			          </div>
					</td>
				</tr>
			</table>

			<div style="margin-top: 10px; text-align: right;" >
				<span id="txtSeguridadpass" style="font-size: 12px; font-weight: bold;"></span>
				<img id="IMGSeguridad" name="IMGSeguridad" src="../imagenes/Seguridad4.png" width="60px;">
			</div>
			<h6 style="font-size: 12px;">Recuerda utilizar mayúsculas, minúsculas, números y mínimo 8 caracteres para que tu contraseña sea segura</h6>
			</center>
		</div>

        <center>
		<div id="DivImg2" class="Imagen2 zoom" style="display: none;">
			<img src="../imagenes/Cargando6Recorte.gif" width="100px">
			<h6>cargando...</h6>
		</div>
		</center>
		
		<div id="DivButton" class="divBoton">
		<br>
			<input disabled class="button" type="submit" name="btn" id="btn" value="Siguiente" onclick="CambiarImagen();">
		</div>

        <br><br>

		<div class="Logo">
			<a href="../index.php"><img src="../imagenes/JUMPLogo2.png" width="40px;" /></a>
		</div>
	</form>
	</div>

</div>
</body>
</html>

<script type="text/javascript">

    function verificarContrasenia(){
        var pass1 = document.getElementById("pass").value;
        var pass2 = document.getElementById("pass2").value;
        if(pass1 != "" || pass2 != ""){
			validar_clave();
            if(pass1 == pass2){
				console.log("Las contraseñas son iguales");
				if(Puntuacion == 100){
					alertsweetalert2('Contraseña correcta', '', 'success');
                	document.getElementById("btn").disabled = false;
					$("#btn").focus();
				}else{
					alertsweetalert2('Alerta', 'La contraseña debe estar en verde', 'error');
				}
            }else{
                document.getElementById("btn").disabled = true;
            }
        }else{
			document.getElementById("IMGSeguridad").src = "../imagenes/Seguridad4.png";
			document.getElementById("txtSeguridadpass").innerHTML = "";
		}
    }


	var Puntuacion = 0;
	function validar_clave(){
		var contrasenna = document.getElementById('pass').value;
		//valida la seguridad de la contrasenia
		//if(contrasenna.length >= 8)
		//{		
			Puntuacion = 0
			var mayuscula = false;
			var minuscula = false;
			var numero = false;
			var caracter_raro = false;
			var seguraTotal = false;
			
			for(var i = 0;i<contrasenna.length;i++)
			{
				if(contrasenna.charCodeAt(i) >= 65 && contrasenna.charCodeAt(i) <= 90)
				{
					mayuscula = true;
				}
				else if(contrasenna.charCodeAt(i) >= 97 && contrasenna.charCodeAt(i) <= 122)
				{
					minuscula = true;
				}
				else if(contrasenna.charCodeAt(i) >= 48 && contrasenna.charCodeAt(i) <= 57)
				{
					numero = true;
				}/*
				else
				{
					caracter_raro = true;
				}*/
			}
			if(mayuscula == true && minuscula == true /*&& caracter_raro == true*/ && numero == true && (contrasenna.length >= 8))
			{
				console.log('Contrasenia segura');
				seguraTotal = true;
				//return true;
			}
		//}

		if(mayuscula == true){Puntuacion = Puntuacion + 15;}
		if(minuscula == true){Puntuacion = Puntuacion + 10;}
		//if(caracter_raro == true){Puntuacion = Puntuacion + 20;}
		if(numero == true){Puntuacion = Puntuacion + 15;}
		if(seguraTotal == true){Puntuacion = Puntuacion + 20;}
		if(contrasenna.length >= 8){Puntuacion = Puntuacion + 40;}
		console.log("Seguridad de contraseña: " + Puntuacion + "%");

		if(Puntuacion <= 25){
			document.getElementById("IMGSeguridad").src = "../imagenes/Seguridad1.png";
			document.getElementById("txtSeguridadpass").innerHTML = "Contraseña débil";
			$("#txtSeguridadpass").css("color", "#ed1818");
		}else if((Puntuacion >= 26) && (Puntuacion <= 99)){
			document.getElementById("IMGSeguridad").src = "../imagenes/Seguridad2.png";
			document.getElementById("txtSeguridadpass").innerHTML = "Contraseña semisegura";
			$("#txtSeguridadpass").css("color", "#e3bf00");
		}else if(Puntuacion == 100){
			document.getElementById("IMGSeguridad").src = "../imagenes/Seguridad3.png";
			document.getElementById("txtSeguridadpass").innerHTML = "Contraseña Segura";
			$("#txtSeguridadpass").css("color", "#37cd30");
		}

		//return false;
	}


</script>


<script>
	function CambiarImagen(){
		console.log("Cambiando");
		$("#DivButton").hide();
		$("#DivImg2").show();
	}
</script>