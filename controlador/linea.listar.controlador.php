<?php

require_once '../negocio/Linea.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objLinea = new Linea();
    $resultado = $objLinea->listar();
    Funciones::imprimeJSON(200, "", $resultado);
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}