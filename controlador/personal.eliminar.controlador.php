<?php

    require_once '../negocio/Personal.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    if (! isset($_POST["p_dni"])){
	Funciones::imprimeJSON(500, "Faltan parametros", "");
	exit();
    }
    
    try {
        $objPersonal = new Personal();
        $dni = $_POST["p_dni"];
        $resultado = $objPersonal->eliminar($dni);
        if ($resultado == true){
            //Eliminó correctamente
            Funciones::imprimeJSON(200, "El registro se ha eleiminado satisfactoriamente", "");
        }
    } catch (Exception $exc) {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }

    