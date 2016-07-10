<?php

require_once '../negocio/Contacto.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_dni_contacto"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objContacto = new Contacto();
    $dniContacto = $_POST["p_dni_contacto"];
    $resultado = $objContacto->leerDatos($dniContacto);
    Funciones::imprimeJSON(200, "", $resultado);
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


