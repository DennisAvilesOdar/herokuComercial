<?php

    require_once '../negocio/Cesta.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    if (! isset($_POST["codigoArticulo"])){
	Funciones::imprimeJSON(500, "Faltan parametros", "");
	exit();
    }
    
    try {
        $objArti = new Cesta();
        $codigoArticulo = $_POST["codigoArticulo"];
        $codigoCliente = 1;
        $resultado = $objArti->eliminar($codigoArticulo, $codigoCliente);
        if ($resultado == true){
            //Eliminó correctamente
            Funciones::imprimeJSON(200, "El registro se ha eleiminado satisfactoriamente", "");
        }
    } catch (Exception $exc) {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }

    