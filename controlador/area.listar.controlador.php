<?php

require_once '../negocio/Area.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objArea = new Area();
    $resultado = $objArea->listarArea();
    Funciones::imprimeJSON(200, "", $resultado);
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}