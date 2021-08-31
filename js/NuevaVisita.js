//ObtenerIPUsuario();

//var Host = "https://www.jumpgt.com/";
var Host = "http://localhost/";

function ObtenerIPUsuario(){
    fetch('https://api.ipify.org/?format=json')
        .then(results => results.json())
        .then(data => GuardarIP(data.ip));
}

function GuardarIP(IPUser){
    var URLactual = window.location.href; //URL Actual
    //URLactual = URLactual.replace('https://www.jumpgt.com/', '');
    //console.log(Host);
    
    $.ajax({
        type: "POST",
        url: Host + "JUMP/app/GuardarVisita.php",
        //url: "https://www.jumpgt.com/JUMP/app/GuardarVisita.php",
        data: {'IPUser': IPUser, 'URLactual': URLactual},
        dataType: "html",
        beforeSend: function(){
        },
        error: function(){
            console.log("error petición ajax");
        },
        success: function(data){
            if(data == "1"){
                console.log("Visita guardada exitosamente");
            }else{
                console.log("La visita no se pudo guardar");
            }
        }
    });
}