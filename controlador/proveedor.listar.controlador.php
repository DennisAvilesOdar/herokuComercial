<?php

require_once '../negocio/Proveedor.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objProveedor = new Proveedor();
    $resultado = $objProveedor->listar();
    Funciones::imprimeJSON(200, "", $resultado);
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}