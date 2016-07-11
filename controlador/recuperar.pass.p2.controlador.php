<?php

require_once '../negocio/Usuario.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if ((! isset($_POST["p_usuario"])) || (! isset($_POST["p_codigo"]))){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $usuario = $_POST["p_usuario"];
    $codigoseguridad = md5($_POST["p_codigo"]);
    
    $obj = new Usuario();
    $obj->setUsuario($usuario);
    $obj->setCodigoSeguridad($codigoseguridad);
    
    $resultado = $obj->confirmarCodigoSeguridad();
    
    switch ($resultado) {
        case 1: //Usuario activo, si puede ingresar
            Funciones::imprimeJSON(200, "Codigo de Seguridad correcto", $resultado);
            break;
        
        default:
            Funciones::imprimeJSON(200, "Codigo de Seguridad incorrecto", $resultado);
            break;
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}