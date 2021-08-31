<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
  $(document).ready(function(){
    $("a[title|='Hosted on free web hosting 000webhost.com. Host your own website for FREE.']").css("display", "none");
    $("img[alt|='www.000webhost.com']").css("display", "none");
  });
</script>

<!--
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximun-scale=1.0, minimun-scale=1.0">
-->

<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">

<!--
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>


<!-- Libreria para mensajes flotantes -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<!-- FIREBASE  -->
	<script src="https://www.gstatic.com/firebasejs/8.2.10/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/8.2.10/firebase-analytics.js"></script>
	<script src="https://www.gstatic.com/firebasejs/8.2.10/firebase-database.js"></script>

  
<!--<script src="https://192.168.1.45/JUMP/js/firebase2.js"></script>-->
<script src="https://www.jumpgt.com/JUMP/js/firebase2.js"></script>
  
<?php
    //include("https://192.168.1.45/JUMP/js/firebase2.php");
    //include($_SERVER['DOCUMENT_ROOT']."/JUMP/js/firebase2.php");
    if(isset($_SESSION['Cliente']['IDCliente'])){
?>
  <script>
    var IDClienteFIREBASE = '<?php echo $_SESSION["Cliente"]["IDCliente"]; ?>';
    //console.log(IDClienteFIREBASE);
  </script>
<?php } ?>

<?php
    if(isset($_SESSION['ESTADO_TRANSACCIONES'])){
?>
  <script>
    var EstadosTransacciones = <?= json_encode($_SESSION['ESTADO_TRANSACCIONES']) ?>;

  </script>
<?php } ?>

