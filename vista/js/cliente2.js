$(document).ready(function(){
    cargarComboDepartamento("#cbodepartamentomodal","seleccione");
});

$("#cbodepartamentomodal").change(function(){
    var codigoDepartamento = $("#cbodepartamentomodal").val();
    cargarComboProvincia("#cboprovinciamodal", "todos", codigoDepartamento);
});
$("#cboprovinciamodal").change(function(){
    var codigoDepartamento = $("#cbodepartamentomodal").val();
    var codigoProvincia = $("#cboprovinciamodal").val();
    cargarComboDistrito("#cbodistritomodal", "todos", codigoDepartamento, codigoProvincia);
});

$("#frmgrabar").submit(function(evento){
    evento.preventDefault();
    
    swal({
		title: "Confirme",
		text: "¿Esta seguro de grabar los datos ingresados?",
		
		showCancelButton: true,
		confirmButtonColor: '#3d9205',
		confirmButtonText: 'Si',
		cancelButtonText: "No",
		closeOnConfirm: false,
		closeOnCancel: true,
                imageUrl: "../imagenes/pregunta.png"
	},
	function(isConfirm){ 

            if (isConfirm){ //el usuario hizo clic en el boton SI     
                
                //procedo a grabar
                
                $.post(
                    "../controlador/cliente2.agregar.editar.controlador.php",
                    {
                        p_datosFormulario: $("#frmgrabar").serialize()
                    }
                  ).done(function(resultado){                    
		      var datosJSON = resultado;

                      if (datosJSON.estado===200){
			  swal("Exito", datosJSON.mensaje, "success");
                          $("#btncerrar").click(); //Cerrar la ventana 
                          listar(); //actualizar la lista
                      }else{
                          swal("Mensaje del sistema", resultado , "warning");
                      }

                  }).fail(function(error){
			var datosJSON = $.parseJSON( error.responseText );
			swal("Error", datosJSON.mensaje , "error");
                  }) ;
                
            }
	});    
});


$("#btnagregar").click(function(){
    $("#txttipooperacion").val("agregar");
    $("#txtpaterno").val("");
    $("#txtmaterno").val("");
    $("#txtnombre").val("");
    $("#txtDNI").val("");
    $("#txtdireccion").val("");
    $("#txtcorreo").val("");
    $("#txtclave").val("");
    $("#cbodepartamentomodal").val("");
    $("#cboprovinciamodal").val("");
    $("#cbodistritomodal").val("");
    
    $("#titulomodal").text("Agregar nuevo cliente");
    
});


$("#myModal").on("shown.bs.modal", function(){
    $("#txtpaterno").focus();
});


