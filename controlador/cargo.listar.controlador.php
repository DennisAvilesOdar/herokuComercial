<?php

require_once '../negocio/Cargo.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objCargo = new Cargo();
    $resultado = $objCargo->listarCargo();
    Funciones::imprimeJSON(200, "", $resultado);
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}