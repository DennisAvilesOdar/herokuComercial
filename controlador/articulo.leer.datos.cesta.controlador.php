<?php

require_once '../negocio/Cesta.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_codigoArticulo"])){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objArti = new Cesta();
    $codigoArticulo = $_POST["p_codigoArticulo"];
    $codigoCliente = 1;
    $resultado = $objArti->leerDatos($codigoArticulo, $codigoCliente);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


