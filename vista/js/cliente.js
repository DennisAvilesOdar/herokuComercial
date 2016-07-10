$(document).ready(function(){
    cargarComboDepartamento("#cbodepartamento","todos");
    cargarComboDepartamento("#cbodepartamentomodal","seleccione");
    listar();
});

$("#cbodepartamento").change(function(){
    var codigoDepartamento = $("#cbodepartamento").val();
    cargarComboProvincia("#cboprovincia", "todos", codigoDepartamento);
    listar();
});

$("#cboprovincia").change(function(){
    var codigoDepartamento = $("#cbodepartamento").val();
    var codigoProvincia = $("#cboprovincia").val();
    cargarComboDistrito("#cbodistrito", "todos", codigoDepartamento,codigoProvincia);
    listar();
});
        
$("#cboprovincia").change(function(){
    listar();
});

$("#cbodistrito").change(function(){
    listar();
});

$("#cbodepartamentomodal").change(function(){
    var codigoDepartamento = $("#cbodepartamentomodal").val();
    cargarComboProvincia("#cbocategoriamodal", "todos", codigoDepartamento);
});
$("#cboprovinciamodal").change(function(){
    var codigoDepartamento = $("#cbodepartamentomodal").val();
    var codigoProvincia = $("#cboprovinciamodal").val();
    cargarComboDistrito("#cbodistritomodal", "todos", codigoDepartamento,codigoProvincia);
});

function listar(){
    var codigoDepartamento = $("#cbodepartamento").val();
    if (codigoDepartamento === null){
        codigoDepartamento = 0;
    }
    
    var codigoProvincia = $("#cboprovincia").val();
    if (codigoProvincia === null){
        codigoProvincia = 0;
    }
    
    var codigoDistrito = $("#cbodistrito").val();
    if (codigoDistrito === null){
        codigoDistrito = 0;
    }
    
    $.post
    (
        "../controlador/cliente.listar.controlador.php",
        {
            codigoDepartamento: codigoDepartamento,
            codigoProvincia: codigoProvincia,
            codigoDistrito: codigoDistrito
        }
    ).done(function(resultado){
        var datosJSON = resultado;
        
        if (datosJSON.estado===200){
            var html = "";

            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>CODIGO</th>';
            html += '<th>CLIENTE</th>';
            html += '<th>DNI</th>';
            html += '<th>DIR</th>';
            html += '<th>TELE</th>';
            html += '<th>CEL1</th>';
            html += '<th>CEL2</th>';
            html += '<th>EMAIL</th>';
            html += '<th>WEB</th>';
            html += '<th>DEPART</th>';
            html += '<th>PROV</th>';
            html += '<th>DIST</th>';
	    html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function(i,item) {
                html += '<tr>';
                html += '<td align="center">'+item.codigo+'</td>';
                html += '<td>'+item.nombre+'</td>';
                html += '<td>'+item.dni+'</td>';
                html += '<td>'+item.direccion+'</td>';
                html += '<td>'+item.telefono+'</td>';
                html += '<td>'+item.movil1+'</td>';
                html += '<td>'+item.movil2+'</td>';
                html += '<td>'+item.correo+'</td>';
                html += '<td>'+item.pagina_web+'</td>';
                html += '<td>'+item.departamento+'</td>';
                html += '<td>'+item.provincia+'</td>';
                html += '<td>'+item.distrito+'</td>';
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