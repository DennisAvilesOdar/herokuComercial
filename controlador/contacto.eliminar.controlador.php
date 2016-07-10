<?php

    require_once '../negocio/Contacto.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    if (! isset($_POST["dniContacto"])){
	Funciones::imprimeJSON(500, "Faltan parametros", "");
	exit();
    }
    
    try {
        $objContacto = new Contacto();
        $dniContacto = $_POST["dniContacto"];
        $resultado = $objContacto->eliminar($dniContacto);
        if ($resultado == true){
            //Eliminó correctamente
            Funciones::imprimeJSON(200, "El registro se ha eleiminado satisfactoriamente", "");
        }
    } catch (Exception $exc) {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }

    