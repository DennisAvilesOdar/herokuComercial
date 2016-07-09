<?php

require_once '../negocio/Categoria.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    
    $codigoLinea = $_POST["codigoLinea"];
    
    $objCategoria = new Categoria();
    $resultado = $objCategoria->listar($codigoLinea);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
    
} catch (Exception $exc) {
    //Funciones::mensaje($exc->getMessage(), "e");
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

