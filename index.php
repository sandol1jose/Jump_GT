<?php
session_start();//inicio de sesion
	if(isset($_SESSION["Cliente"])){ //Si esta registrado
        header('Location: indexLogeo.php'); //envia a la página de inicio.
	}else if (isset($_COOKIE["COOKIE_CLIENTE_EMAIL"]) && isset($_COOKIE["COOKIE_CLIENTE_PASS"])) {
		//si no existe la Sesion cliente la buscamos en las cookies
		$Email = $_COOKIE['COOKIE_CLIENTE_EMAIL'];
		$Pass = $_COOKIE['COOKIE_CLIENTE_PASS'];

		//Logear
		header('Location: app/LogearConCookie.php?email=' . $Email . '&password=' . $Pass);
	}
?>

<?php include_once 'Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>JUMP</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<script src="js/general.js"></script>
	<script src="js/NuevaVisita.js"></script> <!-- Guarda la nueva visita a una página -->

	<style>
		.button2 {
			background-color: #FF5233;
		}
	</style>


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
		<div class="Base">
			<div class="Hijo">
				<br>

				<div class="Cuenta">
					<a href="Registro">Iniciar Sesión</a>
				</div>

                
				<div class="Logotipo2">
					<img class="imagen2 zoom" src="imagenes/rana (2).png">
				</div>

				<center>
				<div>
					<video poster="imagenes/Que es jump.png" src="Que es jump para web.webm" width="275px" height="150px"
					 mute loop controls></video><br>
				</div>
				<!--
				<img src="imagenes/flecha 5.gif" alt="" height="50px"><br> --><br>
				</center>
				
				<div class="AreaBotones">
					<form action="Registro/registro.php">
						<button class="button zoom button2" >Registrarme</button><br>
					</form>

                    
                    <div>
                        <p class="fuenteNormal">Jump verificará que tu compra se realice con éxito.</p>
                    </div>
				</div>
				<div class="pie">
					<a>© Copyright. All Right Reserved</a><br>
					<a><b>Jump GT</b> ® - 2020</a><br>
					<a href="https://www.jumpgt.com">www.jumpgt.com
				</div>
			</div>
		</div>
	</body>

	<p id="parrafo"></p>
</html>

<script type="text/javascript">
        function showAndroidToast(Titulo, Mensaje) {
			try {
				Android.showToast(Titulo, Mensaje);
			} catch (error) {
				console.log("No se esta ejecutando desde Android");
				NotificationJS();
			}
        }

		function NotificationJS(){
			console.log("Enviando Notificacion con JS");
		}
</script>