<?php

require_once '../negocio/Marca.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objMarca = new Marca();
    $resultado = $objMarca->listarMarca();
    Funciones::imprimeJSON(200, "", $resultado);
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}