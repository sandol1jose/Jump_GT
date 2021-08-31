<?php
	function SesionTransaccion($ID, $Monto, $Estado){
		if (session_status() == PHP_SESSION_NONE) {
			session_start();//inicio de sesion
		}
		
		$arrayTransaccion = array(
				'ID'=>$ID,
				'Monto'=>$Monto,
				'Estado'=>$Estado
		);
		$_SESSION['Transaccion'] = $arrayTransaccion;
	}
?>