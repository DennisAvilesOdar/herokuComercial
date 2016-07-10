$(document).ready(function(){
    cargarComboArea("#cboarea","todos");
    cargarComboArea("#cboareamodal","seleccione");
    listar();
});

$("#cboarea").change(function(){
    var codigoarea = $("#cboarea").val();
    cargarComboCargo("#cbocargo", "todos", codigoarea);
    listar();
});

$("#cbocargo").change(function(){
    listar();
});

$("#cboareamodal").change(function(){
    var codigoArea = $("#cboareamodal").val();
    cargarComboCargo("#cbocargomodal", "todos", codigoArea);
});

function listar(){
    var codigoArea = $("#cboarea").val();
    if (codigoArea === null){
        codigoArea = 0;
    }
    
    var codigoCargo = $("#cbocargo").val();
    if (codigoCargo === null){
        codigoCargo = 0;
    }
    
    $.post
    (
        "../controlador/personal.listar.controlador.php",
        {
            codigoArea: codigoArea,
            codigoCargo: codigoCargo
        }
    ).done(function(resultado){
        var datosJSON = resultado;
        
        if (datosJSON.estado===200){
            var html = "";

            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>DNI</th>';
            html += '<th>PERSONAL</th>';
            html += '<th>DIRECCION</th>';
            html += '<th>TELEF</th>';
            html += '<th>CEL1</th>';
            html += '<th>CEL2</th>';
            html += '<th>EMAIL</th>';
            html += '<th>AREA</th>';
            html += '<th>CARGO</th>';
	    html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function(i,item) {
                html += '<tr>';
                html += '<td align="center">'+item.dni+'</td>';
                html += '<td>'+item.nombre+'</td>';
                html += '<td>'+item.direccion+'</td>';
                html += '<td>'+item.telefono+'</td>';
                html += '<td>'+item.movil1+'</td>';
                html += '<td>'+item.movil2+'</td>';
                html += '<td>'+item.correo+'</td>';
                html += '<td>'+item.area+'</td>';
                html += '<td>'+item.cargo+'</td>';
		html += '<td align="center">';
		html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.dni + ')"><i class="fa fa-pencil"></i></button>';
		html += '&nbsp;&nbsp;';
		html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.dni + ')"><i class="fa fa-close"></i></button>';
		html += '</td>';
                html += '</tr>';
            });

            html += '</tbody>';
            html += '</table>';
            html += '</small>';
            
            $("#listado").html(html);
            
            $('#tabla-listado').dataTable({
                "aaSorting": [[1, "asc"]]
            });
            
            
            
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
        
    }).fail(function(error){
        var datosJSON = $.parseJSON( error.responseText );
        swal("Error", datosJSON.mensaje , "error"); 
    });
    
}

$("#btnagregar").click(function(){
    $("#txttipooperacion").val("agregar");
    $("#txtdni").val("");
    $("#txtapellidopaterno").val("");
    $("#txtapellidomaterno").val("");
    $("#txtnombre").val("");
    $("#txtdireccion").val("");
    $("#txtfijo").val("");
    $("#txtmovil1").val("");
    $("#txtmovil2").val("");
    $("#txtcorreo").val("");
    $("#cboareamodal").val("");
    $("#titulomodal").text("Agregar nuevo Proveedor");
});

$("#myModal").on("shown.bs.modal", function(){
    $("#txtdni").focus();
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
                    "../controlador/personal.agregar.editar.controlador.php",
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

function leerDatos(dni){
    
    $.post
        (
            "../controlador/personal.leer.datos.controlador.php",
            {
                p_dni: dni
            }
        ).done(function(resultado){
            var datosJSON = resultado;
            if (datosJSON.estado === 200){
                
                $.each(datosJSON.datos, function(i,item) {
                    $("#txtdni").val( item.dni );
                    $("#txtapellidopaterno").val( item.apellido_paterno );
                    $("#txtapellidomaterno").val( item.apellido_materno );
                    $("#txtnombre").val( item.nombres );
                    $("#txtdireccion").val( item.direccion );
                    $("#txtfijo").val( item.telefono_fijo );
                    $("#txtmovil1").val( item.telefono_movil1 );
                    $("#txtmovil2").val( item.telefono_movil2 );
                    $("#txtcorreo").val( item.email );
                    $("#cboareamodal").val( item.codigo_cargo );
                    $("#txttipooperacion").val("editar");
                    
                    $("#cboareamodal").change();
                    
                    $("#myModal").on("shown.bs.modal", function(){
                        $("#cbocargomodal").val( item.codigo_area );
                    });
                });
                
            }else{
                swal("Mensaje del sistema", resultado , "warning");
            }
        })
    
}


function eliminar(dni){
   swal({
            title: "Confirme",
            text: "¿Esta seguro de eliminar el registro seleccionado?",

            showCancelButton: true,
            confirmButtonColor: '#d93f1f',
            confirmButtonText: 'Si',
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true,
            imageUrl: "../imagenes/eliminar.png"
	},
	function(isConfirm){
            if (isConfirm){
                $.post(
                    "../controlador/personal.eliminar.controlador.php",
                    {
                        p_dni: dni
                    }
                    ).done(function(resultado){
                        var datosJSON = resultado;   
                        if (datosJSON.estado===200){ //ok
                            listar();
                            swal("Exito", datosJSON.mensaje , "success");
                        }

                    }).fail(function(error){
                        var datosJSON = $.parseJSON( error.responseText );
                        swal("Error", datosJSON.mensaje , "error");
                    });
                
            }
	});
   
}