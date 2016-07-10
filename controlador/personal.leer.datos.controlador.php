<?php

require_once '../negocio/Personal.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_dni"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objPersonal = new Personal();
    $dni = $_POST["p_dni"];
    $resultado = $objPersonal->leerDatos($dni);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


