$(document).ready(function(){
    cargarComboLinea("#cbolinea","todos");
    cargarComboMarca("#cbomarca","todos");
});

$("#cbolinea").change(function(){
    var codigoLinea = $("#cbolinea").val();
    cargarComboCategoria("#cbocategoria", "todos", codigoLinea);
});
        

