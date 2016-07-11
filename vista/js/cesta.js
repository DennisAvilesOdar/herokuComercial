$(document).ready(function(){
    listar();
    calcularTotalesArt();
    obtenerPorcentajeIGV();
});


$("#btnregresarc").click(function(){
    document.location.href = "articulo.cliente.vista.php";
    // calcularTotales();
});

function calcularTotalesArt(){
    var subTotal = 0;
    var igv = 0;
    var neto = 0;
    
    $("#listadocesta tr").each(function(){
    var importe = $(this).find("td").eq(4).html();
        
   //var importe = 12;
        
       // alert(importe);
        neto = neto  + parseFloat(importe);
    });
    
    var porcentajeIGV = 18; //Remplazar por el valor de la caja de texto txtigv
    
    subTotal = neto / (1 + (porcentajeIGV / 100));
    igv = neto - subTotal;
    
    //Mostrar los totales
    $("#txtimporteneto").val(neto.toFixed(2));
    $("#txtimportesubtotal").val(subTotal.toFixed(2));
    $("#txtimporteigv").val(igv.toFixed(2));
    
}
function obtenerPorcentajeIGV(){
    $.post
        (
            "../controlador/configuracion.controlador.php",
            {
                p_codigo_parametro: 1  // 1 = IGV
            }
        ).done(function(resultado){
            var datosJSON = resultado;
            if (datosJSON.estado === 200){
                var valorObtenido = datosJSON.datos;
                $("#txtigv").val(valorObtenido);
            }else{
                swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
            var datosJSON = $.parseJSON( error.responseText );
            swal("Error", datosJSON.mensaje , "error");
        });
}

function listar(){
    var codigoCliente = 1;
    
    $.post
    (
        "../controlador/cesta.listar.controlador.php",
        {
            codigoCliente: codigoCliente         
        }
    ).done(function(resultado){
        var datosJSON = resultado;
        
        if (datosJSON.estado===200){
            var html = "";

            html += '<small>';
            html += '<table class="table table-bordered table-striped">';

            $.each(datosJSON.datos, function(i,item) {
                
                html += '<tr>';
                html += '<td align="center">'+item.codigo+'</td>';
                html += '<td>'+item.nombre+'</td>';
                html += '<td>'+item.precio+'</td>';
                html += '<td>'+item.cantidad+'</td>';
                html += '<td>'+item.total+'</td>';
                html += '<td align="center">';
		html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModalE" onclick="leerDatos(' + item.codigo + ')"><i class="fa fa-pencil"></i></button>';
		html += '&nbsp;&nbsp;';
		html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.codigo + ')"><i class="fa fa-close"></i></button>';
		html += '</td>';
                html += '</tr>';
                
            });

          
            html += '</table>';
            html += '</small>';
            
            $("#listadocesta").html(html);
            

            calcularTotalesArt();
            
            
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
                    "../controlador/articulo.cesta.eliminar.controlador.php",
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
                    "../controlador/articulo.cesta.eliminar.controlador.php",
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


$("#frmcesta").submit(function(evento){
    evento.preventDefault();
    
    swal({
		title: "Confirme",
		text: "¿Esta seguro de cambiar la cantidad del artículo?",
		
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
                    "../controlador/articulo.cesta.cantidad.controlador.php",
                    {
                        p_datosFormulario: $("#frmcesta").serialize()
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
            "../controlador/articulo.leer.datos.cesta.controlador.php",
            {
                p_codigoArticulo: codigoArticulo
            }
        ).done(function(resultado){
            var datosJSON = resultado;
            if (datosJSON.estado === 200){
                
                $.each(datosJSON.datos, function(i,item) {
                    $("#txtcodigo").val( item.codigo_articulo );
                    $("#txtnombre").val( item.nombre );                
                    $("#txttipooperacion").val("editar");
                     $("#txtcantidad").val(item.cantidad);   
   
    
                });
                
            }else{
                swal("Mensaje del sistema", resultado , "warning");
            }
        })
    
}

