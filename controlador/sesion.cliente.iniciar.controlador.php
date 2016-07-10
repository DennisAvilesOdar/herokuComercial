<?php

require_once '../negocio/Sesioncliente.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    //echo '<pre>';
    //print_r($_POST); //mostrar los datos que llegan por el metodo post
    //echo '</pre>';
    
    $email = $_POST["txtcliente"];
    $clave = $_POST["txtclave"];
    
    if ( isset(  $_POST["chkrecordar"]  )  ) {
        $recordar = $_POST["chkrecordar"];
    }else{
        $recordar = "N";
    }
    
    $objSesion = new Sesioncliente();
    $objSesion->setEmail($email);
    $objSesion->setClave($clave);
    $objSesion->setRecordarUsuario($recordar);
    
    $resultado = $objSesion->iniciarSesion();
    
    switch ($resultado) {

        case 1: //Usuario activo, si puede ingresar
            header("location:../vista/principal.cliente.vista.php");
            break;
        
        default:
            Funciones::mensaje("El usuario o la contraseña son incorrectos", "e", "../vista/index.php", 5);
            break;
    }
    
    
} catch (Exception $exc) {
    Funciones::mensaje($exc->getMessage(), "e");
}



