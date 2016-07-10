<?php

require_once '../negocio/Personal.clase.php';
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
    $objPersonal = new Personal();
    $objPersonal->setDni( $datosFormularioArray["txtdni"] );
    $objPersonal->setApellido_paterno( $datosFormularioArray["txtapellidopaterno"] );
    $objPersonal->setApellido_materno( $datosFormularioArray["txtapellidomaterno"] );
    $objPersonal->setNombres( $datosFormularioArray["txtnombre"] );
    $objPersonal->setDireccion( $datosFormularioArray["txtdireccion"] );
    $objPersonal->setTelefono_fijo( $datosFormularioArray["txtfijo"] );
    $objPersonal->setTelefono_movil1( $datosFormularioArray["txtmovil1"] );
    $objPersonal->setTelefono_movil2( $datosFormularioArray["txtmovil2"] );
    $objPersonal->setEmail( $datosFormularioArray["txtcorreo"] );
    $objPersonal->setCodigo_cargo( $datosFormularioArray["cbocargomodal"] );
    $objPersonal->setCodigo_area( $datosFormularioArray["cboareamodal"] );
    
    if ($datosFormularioArray["txttipooperacion"]=="agregar"){
        $resultado = $objPersonal->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }else{
        $resultado = $objPersonal->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


