// Your web app's Firebase configuration
var IDClienteFIREBASE = -1;
var EstadosTransacciones;

var dominio = "https://www.jumpgt.com";
//var dominio = "http://192.168.1.45"


var firebaseConfig = {
    apiKey: "AIzaSyCoJqecLIhA6783bGUmeF8ZSCixmuH6NtI",
    authDomain: "jump-775a6.firebaseapp.com",
    databaseURL: "https://jump-775a6-default-rtdb.firebaseio.com",
    projectId: "jump-775a6",
    storageBucket: "jump-775a6.appspot.com",
    messagingSenderId: "346897442850",
    appId: "1:346897442850:web:5d4d140d6c5f10aaa8027b",
    measurementId: "G-KYDHYCLH9K"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();

//funcion que sirve para estar alerta de cualquier cambio
$(document).ready(function(){
    var PrimeraVez = 1;
    var starCountRef = firebase.database().ref('Transacciones/Cli_' + IDClienteFIREBASE);
    starCountRef.on('value', function(snapshot) {
        if(PrimeraVez != 1){
            RecorrerObjeto(snapshot.val());
        }else{
            console.log(IDClienteFIREBASE);
            if(IDClienteFIREBASE != -1){
                console.log("Tiene IDCliente");
                if(EstadosTransacciones == null){
                    //Cargar lista de transacciones con sus estados
                    CargarEstadosTransacciones();
                }else{
                    console.log("Lista Cargada");
                }
            }else{
                console.log("No tiene IDCliente");
            }
            PrimeraVez = 0;
        }
    });
});


function RecorrerObjeto(Objeto){
    //Funcion para obtener el valor del estado que cambio
    var obj = Objeto;
    var obj2;
    var Interruptor;
    var idCheckBox;
    for (const prop in obj) {//recorriendo el objeto
        IDTransaccion = prop;
        try {
            EstadoAnterior = EstadosTransacciones[IDTransaccion];
            EstadoActual = obj[prop]; //Obtenemos el valor
            
            if(EstadoAnterior != EstadoActual){
                Titulo = "La transacción "+prop+" cambio de estado";
                UpdateSESSIONEstadoTransaccion(IDTransaccion, EstadoActual); //Actualizamos la variable de sesion
                EstadosTransacciones[IDTransaccion] = EstadoActual; //Actualizamos el array local
                ConsultarRol(IDClienteFIREBASE, IDTransaccion, Titulo, EstadoActual);
            }
        }catch (error) {
            console.log("existe un error");
            console.log(error);
        }
    }
}

function ConsultarRol(idcliente, idtransaccion, Titulo, Estado){
    //Consultamos el rol que tiene un cliente en la transaccion para saber que mensaje mandarle por notificacion
    $.ajax({
        type: "POST",
        url: dominio + "/JUMP/js/ajax/ConsultaDeRol.php",
        data: {'idcliente': idcliente, 'idtransaccion': idtransaccion},
        dataType: "html",
        headers: {'Access-Control-Allow-Origin': 'origin-list'},
        beforeSend: function(){
        },
        error: function(Error){
            console.log("error petición ajax");
        },
        success: function(data){
            console.log(data);
            if(data == "1"){
                MensajesVendedor(Estado, Titulo); //Es Vendedor
            }else{
                MensajesComprador(Estado, Titulo); //Es Comprador
            }
        }
    });
}

function UpdateSESSIONEstadoTransaccion(IDTransaccion, estado){
    //Actualizamos el estado guardado en la variable de sesion
    $.ajax({
        type: "POST",
        url: dominio + "/JUMP/js/ajax/UpdateVarSesion.php",
        data: {'estado': estado, 'IDTransaccion': IDTransaccion},
        dataType: "html",
        headers: {'Access-Control-Allow-Origin': 'origin-list'},
        beforeSend: function(){
        },
        error: function(Error){
            console.log("error petición ajax");
        },
        success: function(data){
            //console.log("VariableActualizada");
        }
    });
}

function CargarEstadosTransacciones(){
    //Cargamos Todos los estados actuales de las transacciones
    $.ajax({
        type: "POST",
        url: dominio +  "/JUMP/js/ajax/CargarEstadosTransacciones.php",
        data: {'IDCliente': IDClienteFIREBASE},
        dataType: "html",
        headers: {'Access-Control-Allow-Origin': 'origin-list'},
        beforeSend: function(){
        },
        error: function(Error){
            console.log("error petición ajax");
        },
        success: function(data){
            if(data == '0'){
                console.log("No hay transacciones");
            }else{
                EstadosTransacciones = data;
            }
        }
    });
}

function MensajesVendedor(Estado, Titulo){
    //Notificaciones para el Vendedor
    Detalle = "";
    switch(Estado){
        case 1://Ingreso
            Detalle = "Está en el estado de INGRESO"; break;
        case 2://Vinculado
            Detalle = "Está en el estado VINCULADO"; break;
        case 3://Aceptado por comprador
            Detalle = "El comprador aceptó la transacción"; break;
        case 4://Revision de pago
            Detalle = "Estamos revisando el pago"; break;
        case 5://Pago correcto
            Detalle = "Pago correcto puedes enviar el producto"; break;
        case 6://Pago no correcto
            Detalle = "Pago no correcto, no envies el producto aun"; break;
        case 7://Envio a JUMP
            Detalle = "Producto en camino para su revisión"; break;
        case 8://Revision de producto
            Detalle = "Estamos revisando el producto"; break;
        case 9://Envio al comprador
            Detalle = "Producto correcto, enviamos el producto al comprador"; break;
        case 10://Pago al vendedor
            Detalle = "Te hemos pagado"; break;
        case 11://Producto invalido
            Detalle = "El producto no cumple con las reglas establecidas por JUMP"; break;
        case 12://Producto recibido
            Detalle = "El comprador recibio su producto"; break;
    }
    showAndroidToast(Titulo, Detalle);
}

function MensajesComprador(Estado, Titulo){
    //Notificaciones para el Comprador
    Detalle = "";
    switch(Estado){
        case 1://Ingreso
            Detalle = "Está en el estado de INGRESO"; break;
        case 2://Vinculado
            Detalle = "Está en el estado VINCULADO"; break;
        case 3://Aceptado por comprador
            Detalle = "Has aceptado la transacción"; break;
        case 4://Revision de pago
            Detalle = "Estamos revisando el pago"; break;
        case 5://Pago correcto
            Detalle = "Pago correcto, revisaremos el producto"; break;
        case 6://Pago no correcto
            Detalle = "Pago no correcto, completa el pago"; break;
        case 7://Envio a JUMP
            Detalle = "Producto en camino para su revisión"; break;
        case 8://Revision de producto
            Detalle = "Estamos revisando el producto"; break;
        case 9://Envio al comprador
            Detalle = "Producto correcto, te enviamos el producto"; break;
        case 10://Pago al vendedor
            Detalle = "Le pagamos al vendedor"; break;
        case 11://Producto invalido
            Detalle = "El producto no cumple con las reglas establecidas por JUMP"; break;
        case 12://Producto recibido
            Detalle = "Confirmaste que recibiste el producto"; break;
    }
    showAndroidToast(Titulo, Detalle);
}

//Inserta una nueva transaccion
function InsertTransaccion(IDTransaccion, IDVendedor, Estado){
    var insert = {};
    insert['Transacciones/Cli_' + IDVendedor + '/' + IDTransaccion] = Estado;
    firebase.database().ref().update(insert);
}

//Actualizar el estado de una transaccion
function UpdateTransaccion(IDTransaccion, IDVendedor, estado){
    var updates = {};
    updates['Transacciones/Cli_' + IDVendedor + '/' + IDTransaccion] = estado;
    firebase.database().ref().update(updates);
}

function showAndroidToast(Titulo, Mensaje) {
    try {
        Android.showToast(Titulo, Mensaje);
    } catch (error) {
        console.log(Titulo);
        console.log(Mensaje);
        console.log("No se esta ejecutando desde Android");
        //NotificationJS();
    }
}