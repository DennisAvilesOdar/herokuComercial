<?php

require_once '../negocio/Marca.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_codigo_marca"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objMarca = new Marca();
    $codigoMarca = $_POST["p_codigo_marca"];
    $resultado = $objMarca->leerDatos($codigoMarca);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


