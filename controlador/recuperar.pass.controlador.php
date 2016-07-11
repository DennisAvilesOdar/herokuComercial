<?php

require_once '../negocio/Usuario.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if ((! isset($_POST["p_usuario"]))){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    
    $usuario = $_POST["p_usuario"];
    
    $obj = new Usuario();
    $obj->setUsuario($usuario);
    
    $resultado = $obj->buscarUsuario();
    
    switch ($resultado) {
        case 0: //Usuario inactivo, no puede ingresar
            Funciones::imprimeJSON(200, "Usuario inactivo", $resultado);
            break;
        case 1: //Usuario activo, si puede ingresar
            Funciones::imprimeJSON(200, "Usuario activo", $resultado);
            break;
        
        default:
            Funciones::imprimeJSON(200, "El usuario o correo incorrecto(s)", $resultado);
            break;
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}