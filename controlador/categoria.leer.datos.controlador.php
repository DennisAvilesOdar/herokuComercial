<?php

require_once '../negocio/Categoria.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_codigo_categoria"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objCategoria = new Categoria();
    $codigoCategoria = $_POST["p_codigo_categoria"];
    $resultado = $objCategoria->leerDatos($codigoCategoria);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


