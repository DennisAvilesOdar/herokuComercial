<?php

require_once '../negocio/Cesta.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_datosFormulario"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

$datosFormulario = $_POST["p_datosFormulario"];

//Convertir todos los datos que llegan concatenados a un array
parse_str($datosFormulario, $datosFormularioArray);



//quitar
//print_r($datosFormularioArray);
//exit();

try {
    $objArticulo = new Cesta();
    $cogigoCliente = 1;
    $objArticulo->setCodigo_cliente($cogigoCliente);
    $objArticulo->setCodigoArticulo( $datosFormularioArray["txtcodigo"] );
    $objArticulo->setCantidad( $datosFormularioArray["txtcantidad"] );
    
    
//    if ($datosFormularioArray["txttipooperacion"]=="agregar"){
//        $resultado = $objArticulo->agregar();
//        if ($resultado==true){
//            Funciones::imprimeJSON(200, "Grabado correctamente", "");
//        }
//    }else{
//        $objArticulo->setCodigoArticulo( $datosFormularioArray["txtcodigo"] );
//        
 $resultado = $objArticulo->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
//        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
