<?php

require_once '../negocio/Contacto.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    
    if ( !isset( $_POST["codigo_cargo"] )){
        Funciones::imprimeJSON(500, "Faltan parametros", "");
        exit;
    }
    $codigo_area = $_POST["codigo_area"];
    $codigo_cargo = $_POST["codigo_cargo"];
    
    $objContacto = new Contacto();
    $resultado = $objContacto->listar($codigo_area, $codigo_cargo);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
    
} catch (Exception $exc) {
    //Funciones::mensaje($exc->getMessage(), "e");
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

