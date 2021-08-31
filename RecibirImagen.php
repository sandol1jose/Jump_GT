<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();//inicio de sesion
}
$Modo = $_POST["Modo"];
switch($Modo){
    case '1'://Imagenes Producto
        ImagenesProductos(); break;
    case '2'://Imagen DPI
        ImagenDPI(); break;
    case '3'://NumeroDeGuia
        ComprobanteEnvio(); break;
}
?>
<?php
function ImagenesProductos(){
	$TipoImag = $_FILES['Imagen']['type'];
	if($TipoImag == "image/jpeg" || $TipoImag == "image/jpg" || $TipoImag == "image/gif" || $TipoImag == "image/png"){
		//Imagen aceptada
        $NumeroImagen = $_POST["NumeroImagen"];
        $Imagen = base64_encode(file_get_contents($_FILES['Imagen']['tmp_name']));
        $_SESSION['IMAGENES_PRODUCTO'][$NumeroImagen] = $Imagen;
	}else{
        //Imagen no aceptada
        $_SESSION["Alerta"] = "ImagenNo";
        header('Location: ../ingresoproducto.php');
	}
}

function ImagenDPI(){
	$TipoImag = $_FILES['Imagen']['type'];
	if($TipoImag == "image/jpeg" || $TipoImag == "image/jpg" || $TipoImag == "image/gif" || $TipoImag == "image/png"){
		//Imagen aceptada
        $Imagen = base64_encode(file_get_contents($_FILES['Imagen']['tmp_name']));
        $_SESSION['IMAGEN_DPI'] = $Imagen;
	}else{
        //Imagen no aceptada
        $_SESSION["Alerta"] = "ImagenNo";
        header('Location: ../Registro/CompletarDatos.php');
	}
}


function ComprobanteEnvio(){
	$TipoImag = $_FILES['Imagen']['type'];
	if($TipoImag == "image/jpeg" || $TipoImag == "image/jpg" || $TipoImag == "image/gif" || $TipoImag == "image/png"){
		//Imagen aceptada
        $Imagen = base64_encode(file_get_contents($_FILES['Imagen']['tmp_name']));
        $_SESSION['IMAGEN_ENVIOGUIA'] = $Imagen;
	}else{
        //Imagen no aceptada
        $_SESSION["Alerta"] = "ImagenNo";
        header('Location: ../Vendedor/NumeroDeGuia.php');
	}
}
?>
<?php
/*
include_once "app/RedimencionarImagen.php";
$nombre = $_FILES['Imagen1']['name'];
$nombrer = strtolower($nombre);
$cd=$_FILES['Imagen1']['tmp_name'];

$res = explode(".", $nombre);
$extension = $res[count($res)-1];
$NombreFotografia = $nombre . "_1" . "." . $extension;
$ruta = "ImagesBD/" .  $NombreFotografia;
$destino = "ImagesBD/";
$resultado = @move_uploaded_file($_FILES["Imagen1"]["tmp_name"], $ruta);


$tipo_archivo = $_FILES['Imagen1']['type'];
$tamano_archivo = $_FILES['Imagen1']['size'];


if (!empty($resultado)){
    echo "el archivo ha sido movido exitosamente";
}else{
    echo "Error al subir el archivo";
    exit();
}

$origen= $ruta;
$destino= $ruta;
$destino_temporal= tempnam("tmp/","tmp");
if(redimensionarImagen($origen, $destino_temporal, 500, 550, 100))
{
    // guardamos la imagen redimensionada
    $fp=fopen($destino,"w");
    fputs($fp,fread(fopen($destino_temporal,"r"),filesize($destino_temporal)));
    fclose($fp);
    unlink($destino_temporal); //Eliminado el archivo temporal que se crea para redimensionar
 
    // mostramos la imagen
    echo "<img src='ImagesBD/".  $NombreFotografia ."'>";
}else{
    // la imagen original es mas pequeña que el tamaño destino
    echo "<img src='ImagesBD/".  $NombreFotografia ."'>";
    //echo "<img src='img/imagen.jpg'>";
    echo "No se redimenciono";
    unlink($destino_temporal); //Eliminado el archivo temporal que se crea para redimensionar
}
*/
?>