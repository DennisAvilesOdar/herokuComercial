$(document).ready(function(){
    cargarComboArea("#cboarea","todos");
    cargarComboArea("#cboareamodal","seleccione");
    listar();
});

$("#cboarea").change(function(){
    var codigoArea = $("#cboarea").val();
    cargarComboCargo("#cbocargo", "todos", codigoArea);
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
        "../controlador/contacto.listar.controlador.php",
        {
            codigo_area: codigoArea,
            codigo_cargo: codigoCargo
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
            html += '<th>NOMBRE DEL CONTACTO</th>';
            html += '<th>TELEFONO</th>';
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
                html += '<td align="center">'+item.codigo+'</td>';
                html += '<td>'+item.nombre+'</td>';
                html += '<td>'+item.telefono+'</td>';
                html += '<td>'+item.email+'</td>';
                html += '<td>'+item.area+'</td>';
                html += '<td>'+item.cargo+'</td>';
		html += '<td align="center">';
		html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.codigo + ')"><i class="fa fa-pencil"></i></button>';
		html += '&nbsp;&nbsp;';
		html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.codigo + ')"><i class="fa fa-close"></i></button>';
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


function eliminar(codigoArticulo){
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
                    "../controlador/articulo.eliminar.controlador.php",
                    {
                        codigoArticulo: codigoArticulo
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
                    "../controlador/contacto.agregar.editar.controlador.php",
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
    
    $("#txtcodigo").val("");
    $("#txtnombre").val("");
    $("#txtprecio").val("");
    $("#cbolineamodal").val("");
    $("#cbocategoriamodal").val("");
    $("#cbomarcamodal").val("");
    
    $("#titulomodal").text("Agregar nuevo articulo");
    
});


$("#myModal").on("shown.bs.modal", function(){
    $("#txtnombre").focus();
});


function leerDatos( codigoArticulo ){
    
    $.post
        (
            "../controlador/articulo.leer.datos.controlador.php",
            {
                p_codigoArticulo: codigoArticulo
            }
        ).done(function(resultado){
            var datosJSON = resultado;
            if (datosJSON.estado === 200){
                
                $.each(datosJSON.datos, function(i,item) {
                    $("#txtcodigo").val( item.codigo_articulo );
                    $("#txtnombre").val( item.nombre );
                    $("#txtprecio").val( item.precio_venta );
                    $("#cbolineamodal").val( item.codigo_linea );
                    $("#cbomarcamodal").val( item.codigo_marca );
                    
                    //Ejecuta el evento change para llenar las categorías que pertenecen a la linea seleccionada
                    $("#cbolineamodal").change();
                    
                    $("#myModal").on("shown.bs.modal", function(){
                        $("#cbocategoriamodal").val( item.codigo_categoria );
                    });
                    
                    $("#txttipooperacion").val("editar");
                    
                });
                
            }else{
                swal("Mensaje del sistema", resultado , "warning");
            }
        })
    
}

