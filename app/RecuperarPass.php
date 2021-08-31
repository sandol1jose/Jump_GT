<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include '../conexion.php';

$Email = $_POST["Email"];

EnviarEmail($Email, $base_de_datos);

//header('Location: ../Registro/Verificacion.php?email=' . $Email); //envia a la página de inicio.

	function EnviarEmail($Email, $base_de_datos){/*
		$to = $Email;
		$subject = "Cambio de contraseña";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$from = "jumpchiquimula@gmail.com";
		$headers .= "From:" . $from;*/
		 
		$Pass = generarCodigo(5);
		$message = "
		<html>
		<head>
		<title>Cambio de clave</title>
		</head>
		<body>
		<h2>Este es tu codigo:</h2>
		<p>Ha solicitado restablecer su contraseña para la cuenta de Jump asociada con esta 
		dirección de correo electrónico (".$Email."). Para obtener el código de 
		restablecimiento de contraseña, por favor copie este código y péguelo en la aplicación:</p>
		<H1>".$Pass."</H1><br><br>
		<p>Si no realizó la solicitud, puede ignorar este correo electrónico y no hacer nada. 
		Otro usuario probablemente ingresó su dirección de correo electrónico por error al 
		intentar restablecer una contraseña.</p><br>
		<p>Jump GT</p>
		<p>https://www.jumpgt.com/</p>
		</body>
		</html>";
		
		require '../Libraries/PHPMailer-master/src/Exception.php';
		require '../Libraries/PHPMailer-master/src/PHPMailer.php';
		require '../Libraries/PHPMailer-master/src/SMTP.php';
		
		//Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);
		
		try {
			//Server settings
			$mail->SMTPDebug = 0;                      //Enable verbose debug output
			//$mail->isSMTP();                                            //Send using SMTP
			//$mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
			$mail->Host       = 'smtp.hostinger.com';                       //Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			//$mail->Username   = 'jumpchiquimula@gmail.com';             //SMTP username
			//$mail->Password   = 'jumpchiquimula9899';                  //SMTP password
			$mail->Username   = 'soporte@jumpgt.com';             //SMTP username
			$mail->Password   = '$6y9KUtAs2sVWF';                  		//SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
			$mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
			//Recipients
			$mail->setFrom('soporte@jumpgt.com', 'Jump GT');
			$mail->addAddress($Email);                 					//Add a recipient
		
			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = 'Instrucciones para cambiar su clave de Jump GT';
			$mail->Body    = $message;
			//$mail->AltBody = 'Enviado desde 000webhost.com';
		
			
			if(VerificarEmail($base_de_datos, $Email) == 1){ //Si existe el email
				//echo "1";
				if(GuardarCodigo($Pass, $base_de_datos, $Email) == 1){
					//echo "2";
					$_SESSION["Alerta"] = "CodpassSend"; //Codigo de pass enviado
					$_SESSION["Correo"] = $Email;
					$mail->send();
					header('Location: ../Registro/CambiarPass.php');
				}else{
					//echo "3";
				}
			}else{
				//echo "4";
				//El correo no existe
				$_SESSION["Alerta"] = "MailNoExist";
				header('Location: ../Registro/RecuperarPass.php');
			}
			//echo "5";
			//echo 'Message has been sent';
		} catch (Exception $e) {
			echo $e;
			//echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}

	/*
	function ActualizarContrasenia($Pass, $base_de_datos, $Email){
        $PassCifrada = password_hash($Pass, PASSWORD_DEFAULT); //Encriptando contraseñas
		$sql = "UPDATE usuario u SET u.password = '".$PassCifrada."' WHERE u.email = '".$Email."';";
		$sentencia = $base_de_datos->prepare($sql);
		$sentencia->execute(); 

		if($sentencia == true){
			//SE AGREGO CORRECTAMENTE AL CLIENTE
			return 1;
		}else{
			return 0;
		}
	}*/

	function GuardarCodigo($Codigo, $base_de_datos, $Email){
		//guarda el codigo para cambiar contraseña
		$sql = "SELECT u.id FROM usuario u WHERE u.email = '".$Email."';";
		$sentencia = $base_de_datos->prepare($sql);
		$sentencia->execute(); 
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$IDusuario;
		foreach($registros as $registro){
			$IDusuario = $registro['id'];
		}
		$Fecha = date("Y-m-d h:i:s");

		$sentencia2 = $base_de_datos->prepare("CALL NewCodigoPass(?,?,?);");
		$resultado2 = $sentencia2->execute([$Codigo, $Fecha, $IDusuario]);
			
		if($resultado2 == true){
			//SE AGREGO CORRECTAMENTE AL CLIENTE
			return 1;
		}else{
			return 0;
		}
	}

	function VerificarEmail($base_de_datos, $Email){
		$sql = "SELECT * FROM usuario u WHERE u.email = '".$Email."';";
		$sentencia = $base_de_datos->prepare($sql);
		$sentencia->execute(); 
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$contador = count($registros);

		if($contador == 1){
			//SI EXISTE EL CORREO
			return 1;
		}else{
			//NO EXISTE EL CORREO
			return 0;
		}
	}

	function generarCodigo($longitud) {
		$key = '';
		//$pattern = '1234567890';s
		//$pattern = '1234567890ABCDEFGHIJKLMNPOQRSTUVWXYZabcdefghijklmnopqrstuvwxyz+#@$%&=';
		$pattern = '1234567890ABCDEFGHIJKLMNPOQRSTUVWXYZ';
		$max = strlen($pattern)-1;
		//for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
		for($i=0;$i < $longitud;$i++) $key .= $pattern[mt_rand(0,$max)];
		return $key;
	}
?>