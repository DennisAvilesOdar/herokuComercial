$(document).ready(function(){
    $("#btnpaso1").click();
});

$("#btnpaso1").click(function(){
    $("#txtcorreomodal").val("");
    $("#titulomodal1").text("Recupere su Contraseña");
});

$("#myPaso1").on("shown.bs.modal", function(){
    $("#txtcorreomodal").focus();
});

$("#frmpaso1").submit(function(evento){
    evento.preventDefault();
    
    var $usuario = $("#txtcorreomodal").val();
    
    $.post(
    "../controlador/recuperar.pass.controlador.php",
    {
        p_usuario: $usuario
    }
    ).done(function(resultado){
        var datosJSON = resultado;
        
        if (datosJSON.estado===200){
            if (datosJSON.datos ===1){
                enviarCodigoSeguridadCorreo();
            } else {
                swal("Mensaje del sistema", datosJSON.mensaje , "warning");
            }
        }else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
        var datosJSON = $.parseJSON( error.responseText );
        swal("Error", datosJSON.mensaje , "error");
    });
});

function enviarCodigoSeguridadCorreo(){
    var $correo = $("#txtcorreomodal").val();
    
    $.post(
        "../controlador/recuperar.pass.p1.controlador.php",
        {
            p_correo: $correo
        }
    ).done(function(resultado){
        var datosJSON = resultado;
        
        if (datosJSON.estado===200){
            swal("Exito", datosJSON.mensaje, "success");
            $("#btncerrar1").click();
            $("#btnpaso2").click();
        }else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
        var datosJSON = $.parseJSON( error.responseText );
        swal("Error", datosJSON.mensaje , "error");
    });
}

$("#btnpaso2").click(function(){
    $("#txtcodigoseguridad").val("");
    $("#titulomodal2").text("Codigo de Seguridad");
});

$("#myPaso2").on("shown.bs.modal", function(){
    $("#txtcodigoseguridad").focus();
});

$("#frmpaso2").submit(function(evento){
    evento.preventDefault();
    
    var $usuario = $("#txtcorreomodal").val();
    var $codigoSeguridad = $("#txtcodigoseguridad").val();
    
    $.post(
    "../controlador/recuperar.pass.p2.controlador.php",
    {
        p_usuario: $usuario,
        p_codigo: $codigoSeguridad
    }
    ).done(function(resultado){
        var datosJSON = resultado;
        
        if (datosJSON.estado===200){
            if (datosJSON.datos ===1){
                swal("Exito", datosJSON.mensaje, "success");
                $("#btncerrar2").click();
                $("#btnpaso3").click();
            } else {
                swal("Mensaje del sistema", datosJSON.mensaje , "warning");
            }
        }else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
        var datosJSON = $.parseJSON( error.responseText );
        swal("Error", datosJSON.mensaje , "error");
    });
});

$("#btnpaso3").click(function(){
    $("#txtnuevopass").val("");
    $("#txtconfirmarpass").val("");
    $("#titulomodal3").text("Nueva Contraseña");
});

$("#myPaso3").on("shown.bs.modal", function(){
    $("#txtnuevopass").focus();
});

$("#frmpaso3").submit(function(evento){
    evento.preventDefault();
    
    var $usuario = $("#txtcorreomodal").val();
    var $nuevopass = $("#txtnuevopass").val();
    var $nuevopass2 = $("#txtconfirmarpass").val();
    
    if($nuevopass === $nuevopass2){
        $.post(
        "../controlador/recuperar.pass.p3.controlador.php",
        {
            p_usuario: $usuario,
            p_pass: $nuevopass
        }
        ).done(function(resultado){
            var datosJSON = resultado;
            
            if (datosJSON.estado===200){
                swal("Exito", datosJSON.mensaje, "success");
                $("#btncerrar3").click();
            }else{
                swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
            var datosJSON = $.parseJSON( error.responseText );
            swal("Error", datosJSON.mensaje , "error");
        });
    } else {
        swal("Mensaje del sistema", "Error en la verificacion de Contraseña. Ingrese nuevamente", "warning");
        $("#txtnuevopass").val("");
        $("#txtconfirmarpass").val("");
    }
});