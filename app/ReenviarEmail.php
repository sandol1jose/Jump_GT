<?php
	include '../conexion.php';
    include 'EnviarCorreo.php';

    $Email = $_POST["Email"];

    EnviarEmail($Email, $base_de_datos);

    header('Location: ../Registro/Verificacion.php?email=' . $Email); //envia a la página de inicio.
?>