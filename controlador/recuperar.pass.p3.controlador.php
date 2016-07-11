<?php

require_once '../negocio/Usuario.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if ((! isset($_POST["p_usuario"])) || (! isset($_POST["p_pass"]))){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $usuario = $_POST["p_usuario"];
    $clavemd5 = md5($_POST["p_pass"]);
    
    $obj = new Usuario();
    $obj->setClave($clavemd5);
    $obj->setUsuario($usuario);
    $resultado = $obj->cambiarClave();
    
    if($resultado ==true){
        Funciones::imprimeJSON(200, "Contraseña cambiada correctamente", "");
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}