<?php
session_start();
if(isset($_SESSION['imagen'])){
    //echo $_SESSION['imagen'];
}else{
    //echo "No existe";
}
?>
<?php include_once 'Templates/Cabecera.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <input type="file" id="file" accept="image/*">  
</body>
</html>


<script src="Libraries/compressorjs-master/docs/js/compressor.js"></script>
<script  src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"> </script>
<script>
//import axios from 'axios';
//import Compressor from 'Libraries/compressorjs-master/dist/compressorjs';

document.getElementById('file').addEventListener('change', (e) => {
  const file = e.target.files[0];
  console.log(file['size'] / 1000);
  //alert(file['size'] / 1000);

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
        formData.append('Imagen1', result, result.name);

        let config = {
            header : {
            'Content-Type' : 'multipart/form-data'
            }
        }
        
        axios.post('RecibirImagen.php', formData, config).then((response) => {
            console.log('Upload success');
            console.log(response.data);
        }).catch(error => {
            console.log('error', error)
        });

    },
    error(err) {
      console.log(err.message);
      document.getElementById('file').value = null;
    },
  });
});
</script>