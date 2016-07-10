<?php

require_once '../negocio/Cliente2.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_datosFormulario"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

$datosFormulario = $_POST["p_datosFormulario"];

//Convertir todos los datos que llegan concatenados a un array
parse_str($datosFormulario, $datosFormularioArray);

//echo '<pre>';
//print_r($datosFormularioArray);
//echo '</pre>';


try {
    $objCliente = new Cliente2();
    $objCliente->setApellido_paterno( $datosFormularioArray["txtpaterno"] );
    $objCliente->setApellido_materno( $datosFormularioArray["txtmaterno"] );
    $objCliente->setNombres( $datosFormularioArray["txtnombre"] );
    $objCliente->setDni( $datosFormularioArray["txtDNI"] );
    $objCliente->setDireccion( $datosFormularioArray["txtdireccion"] );
    $objCliente->setEmail( $datosFormularioArray["txtcorreo"] );
    $objCliente->setCodigo_departamento( $datosFormularioArray["cbodepartamentomodal"] );
    $objCliente->setCodigo_provincia( $datosFormularioArray["cboprovinciamodal"] );
    $objCliente->setCodigo_distrito( $datosFormularioArray["cbodistritomodal"] );
    $cl = ( $datosFormularioArray["txtclave"] );
    $clmd5 = md5($cl);
    $objCliente->setClave($clmd5);
    
    if ($datosFormularioArray["txttipooperacion"]=="agregar"){
        $resultado = $objCliente->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }else{
        $objCliente->setCodigo_cliente( $datosFormularioArray["txtcodigo"] );
        
        $resultado = $objCliente->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

