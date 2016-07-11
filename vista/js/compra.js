$(document).ready(function(){
    cargarComboTC("#cbotipocomp", "seleccione");
    obtenerPorcentajeIGV();
});

$("#cbotipocomp").change(function(){
    var tipoComprobante = $("#cbotipocomp").val();
    cargarComboSerie("#cboserie", "seleccione", tipoComprobante );
});


function obtenerNumeroComprobante(){
    var tipoComprobante = $("#cbotipocomp").val();
    var serie = $("#cboserie").val();
    
    $.post
        (
           "../controlador/serie.comprobante.obtener.numero.controlador.php",
            {
                p_tipoComprobante: tipoComprobante,
                p_serie: serie
            }
        ).done(function(resultado){
            var datosJSON = resultado;
            if (datosJSON.estado === 200){
                var numeroComprobante = datosJSON.datos.numero;
                $("#txtnrodoc").val(numeroComprobante);
            }else{
                swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
            var datosJSON = $.parseJSON( error.responseText );
            swal("Error", datosJSON.mensaje , "error");
        });
    
}

$("#cboserie").change(function(){
    obtenerNumeroComprobante();
});

    
//    if ($("#txtstock").val() < $("#txtcantidad").val())  {
//    swal("Verifique", "no tiene stock suficiente", "warning");
//       // $("#txtarticulo").focus();
//        return 0;
//    }
//    
    
    //Limpiar los controles y enfocar a la caja de texto txtarticulo


//
//$("#txtcantidad").keypress(function(evento){
//    if (evento.which === 13){ //Significa que el usuario ha presionado la tecla ENTER
//        evento.preventDefault();
//        $("#btnagregar").click();
//    }else{
//        return validarNumeros(evento);
//    }
//});






var arrayDetalle = new Array(); //permite almacenar todos los articulos agregados en el detalle de la venta

$("#frmcompra").submit(function(evento){
    evento.preventDefault();
    
    swal({
		title: "Confirme",
		text: "¿Esta seguro de grabar la venta?",
		
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
                
                /*CAPTURAR TODOS LOS DATOS NECESARIOS PARA GRABAR EN EL VENTA_DETALLE*/
                
                /*limpiar el array*/
                arrayDetalle.splice(0, arrayDetalle.length);
                /*limpiar el array*/
                
                /*RECORREMOS CADA FILA DE LA TABLA DONDE ESTAN LOS ARTICULOS VENDIDOS*/
                $("#listadocesta tr").each(function(){
                    var codigoArticulo = $(this).find("td").eq(0).html();
                    var precio = $(this).find("td").eq(2).html();
                    var cantidad = $(this).find("td").eq(3).html();
                    var importe = $(this).find("td").eq(4).html();
                    
                    var objDetalle = new Object(); //Crear un objeto para almacenar los datos
                    
                    /*declaramos y asignamos los valores a los atributos*/
                    objDetalle.codigoArticulo = codigoArticulo;
                    objDetalle.cantidad  = cantidad;
                    objDetalle.precio    = precio;
                    objDetalle.importe   = importe;
                    /*declaramos y asignamos los valores a los atributos*/
                    
                    arrayDetalle.push(objDetalle); //agregar el objeto objDetalle al array arrayDetalle
                    
                });
                
                /*RECORREMOS CADA FILA DE LA TABLA DONDE ESTAN LOS ARTICULOS VENDIDOS*/
                
                //Convertimos el array "arrayDetalle" a formato de JSON
                var jsonDetalle = JSON.stringify(arrayDetalle);
                
                //alert(jsonDetalle);
                //return 0;
                
    
                /*CAPTURAR TODOS LOS DATOS NECESARIOS PARA GRABAR EN EL VENTA_DETALLE*/
                
                $.post(
                    "../controlador/compra.cliente.agregar.controlador.php",
                    {
                        p_datosFormulario: $("#frmcompra").serialize(),
                        p_datosJSONDetalle: jsonDetalle
                    }
                  ).done(function(resultado){                    
		      var datosJSON = resultado;

                      if (datosJSON.estado===200){
			  
                         // swal("Exito", datosJSON.mensaje, "success");
                          //document.location.href = "venta.listado.vista.php"
                          //$("#btncerrar").click(); //Cerrar la ventana 
                         // listar(); //actualizar la lista
                     swal({
                    title: "Exito",
                    text: datosJSON.mensaje,
                    type: "success",
                    showCancelButton: false,
                    //confirmButtonColor: '#3d9205',
                    confirmButtonText: 'Ok',
                    closeOnConfirm: true
                },
                function(){
                    document.location.href="articulo.cliente.vista.php";
                });
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