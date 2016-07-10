<?php

require_once '../negocio/Proveedor.clase.php';
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
    $objProveedor = new Proveedor();
    $objProveedor->setRuc_proveedor( $datosFormularioArray["txtruc"] );
    $objProveedor->setRazon_social( $datosFormularioArray["txtrazon"] );
    $objProveedor->setDireccion( $datosFormularioArray["txtdireccion"] );
    $objProveedor->setTelefono( $datosFormularioArray["txttelefono"] );
    $objProveedor->setRepresentante_legal( $datosFormularioArray["txtlegal"] );
    
    
    if ($datosFormularioArray["txttipooperacion"]=="agregar"){
        $resultado = $objProveedor->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }else{
        $resultado = $objProveedor->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
