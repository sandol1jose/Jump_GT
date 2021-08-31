<?php
	$estado = $_POST["estado"];
    $IDTransaccion = $_POST["IDTransaccion"];

    $_SESSION['ESTADO_TRANSACCIONES'][$IDTransaccion] = $estado;
?>