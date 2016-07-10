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