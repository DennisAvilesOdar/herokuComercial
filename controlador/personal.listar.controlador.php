<?php

require_once '../negocio/Personal.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    
    if ( !isset( $_POST["codigoCargo"] )){
        Funciones::imprimeJSON(500, "Faltan parametros", "");
        exit;
    }
    $codigoArea = $_POST["codigoArea"];
    $codigoCargo = $_POST["codigoCargo"];
    
    $objPersonal = new Personal();
    $resultado = $objPersonal->listar($codigoArea, $codigoCargo);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
    
} catch (Exception $exc) {
    //Funciones::mensaje($exc->getMessage(), "e");
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

