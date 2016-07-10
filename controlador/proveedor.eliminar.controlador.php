<?php

    require_once '../negocio/Proveedor.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    if (! isset($_POST["p_ruc_proveedor"])){
	Funciones::imprimeJSON(500, "Faltan parametros", "");
	exit();
    }
    
    try {
        $objProveedor = new Proveedor();
        $rucProveedor = $_POST["p_ruc_proveedor"];
        $resultado = $objProveedor->eliminar($rucProveedor);
        if ($resultado == true){
            //Eliminó correctamente
            Funciones::imprimeJSON(200, "El registro se ha eleiminado satisfactoriamente", "");
        }
    } catch (Exception $exc) {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }

    