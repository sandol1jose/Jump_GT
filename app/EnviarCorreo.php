<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

	function EnviarEmail($Email, $base_de_datos){
		/*
		$to = $Email;
		$subject = "Confirmación de correo electrónico";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$from = "jumpchiquimula@gmail.com";
		$headers .= "From:" . $from;*/
		 
		$Codigo = BuscarCodigo($base_de_datos, $Email);
		$message = "
		<html>
		<head>
		<title>Confirmación de correo electrónico</title>
		</head>
		<body>
		<h2>Debes confirmar tu correo electrónico</h2>
		<p>Ingresa el siguiente codigo para verificar tu correo electrónico</p>
		<H1>".$Codigo."</H1><br><br>
		<p>Jump GT</p>
		</body>
		</html>";
		 
		//mail($to, $subject, $message, $headers);

		
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
			/*$mail->addAddress('ellen@example.com');                   //Name is optional
			$mail->addReplyTo('info@example.com', 'Information');
			$mail->addCC('cc@example.com');
			$mail->addBCC('bcc@example.com');*/
		
			//Attachments
			/*
			$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
			$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name*/
		
			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = 'Confirmacion de correo electronico';
			$mail->Body    = $message;
			//$mail->AltBody = 'Enviado desde 000webhost.com';
		
			$mail->send();
			//echo 'Message has been sent';
		} catch (Exception $e) {
			//echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}


	function BuscarCodigo($base_de_datos, $Email){
		$Codigo = generarCodigo(5);//Generamos un codigo nuevo
		//Lo buscamos en la base de datos
		$sql = "SELECT id FROM verificacion WHERE clave = '".$Codigo."'";
		$sentencia = $base_de_datos->prepare($sql);
		$sentencia->execute(); 
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$contar = count($registros);
		if($contar == 0){
			if(GrabarCodigo($Codigo, $base_de_datos, $Email) == 1){
				return $Codigo;
			}else{
				BuscarCodigo($base_de_datos, $Email);
			}
		}else{
			BuscarCodigo($base_de_datos, $Email);
		}
	}

	function GrabarCodigo($Codigo, $base_de_datos, $Email){
		$sql = "SELECT u.id FROM usuario u WHERE u.email = '".$Email."';";
		$sentencia = $base_de_datos->prepare($sql);
		$sentencia->execute(); 
		$registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		$IDusuario;
		foreach($registros as $registro){
			$IDusuario = $registro['id'];
		}
		$Fecha = date("Y-m-d h:i:s");

		$sentencia2 = $base_de_datos->prepare("CALL NewCodVerificacion(?,?,?);");
		$resultado2 = $sentencia2->execute([$Codigo, $Fecha, $IDusuario]);
			
		if($resultado2 == true){
			//SE AGREGO CORRECTAMENTE AL CLIENTE
			return 1;
		}else{
			return 0;
		}
	}

	function generarCodigo($longitud) {
		$key = '';
		//$pattern = '1234567890';s
		$pattern = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
		$max = strlen($pattern)-1;
		for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
		return $key;
	}
?>