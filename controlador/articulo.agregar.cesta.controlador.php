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



////quitar
//print_r($datosFormularioArray);
//exit();


try {
    $objArticulo = new Cesta();
    $codigoC = 1;
    $objArticulo->setCodigo_cliente($codigoC);
    
    $objArticulo->setCodigoArticulo( $datosFormularioArray["txtcodigomodal"] );
    $objArticulo->setCantidad( $datosFormularioArray["txtcantidadmodal"] );
        
        $resultado = $objArticulo->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }

    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
