<?php

require_once '../negocio/Categoria.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_datosFormulario"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

$datosFormulario = $_POST["p_datosFormulario"];

//Convertir todos los datos que llegan concatenados a un array
parse_str($datosFormulario, $datosFormularioArray);




//print_r($datosFormularioArray);
//exit();

try {
    $objCategoria = new Categoria();
    $objCategoria->setDescripcion( $datosFormularioArray["txtnombre"] );
    $objCategoria->setCodigoLinea( $datosFormularioArray["cbolineamodal"] );
    
    if ($datosFormularioArray["txttipooperacion"]=="agregar"){
        $resultado = $objCategoria->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }else{
        $objCategoria->setCodigoCategoria( $datosFormularioArray["txtcodigo"] );
        
        $resultado = $objCategoria->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
