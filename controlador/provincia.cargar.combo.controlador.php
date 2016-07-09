<?php

    //require_once 'sesion.validar.controlador.php';

    require_once '../negocio/Provincia.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
        $codigoDep = $_POST["p_codigo_departamento"];
        
	$objProvincia = new Provincia();
        $resultado = $objProvincia->cargarListaDatos($codigoDep);
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
