<?php

require_once '../negocio/Linea.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_codigo_linea"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objLinea = new Linea();
    $codigoLinea = $_POST["p_codigo_linea"];
    $resultado = $objLinea->leerDatos($codigoLinea);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


