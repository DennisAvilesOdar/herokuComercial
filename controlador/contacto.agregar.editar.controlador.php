<?php

require_once '../negocio/Contacto.clase.php';
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
    $objContacto = new Contacto();
    $objContacto->setApellidos( $datosFormularioArray["txtapellido"] );
    $objContacto->setNombres( $datosFormularioArray["txtnombre"] );
    $objContacto->setTelefono( $datosFormularioArray["txttelefono"] );
    $objContacto->setEmail( $datosFormularioArray["txtemail"] );
    $objContacto->setCodigo_area( $datosFormularioArray["cboareamodal"] );
    $objContacto->setCodigo_cargo( $datosFormularioArray["cbocargomodal"] );
    
    if ($datosFormularioArray["txttipooperacion"]=="agregar"){
        $resultado = $objContacto->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }else{
        $objArticulo->setCodigoArticulo( $datosFormularioArray["txtcodigo"] );
        
        $resultado = $objArticulo->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
