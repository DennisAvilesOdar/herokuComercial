<?php

    //require_once 'sesion.validar.controlador.php';

    require_once '../negocio/Provincia.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
        $codigoDepartamento = $_POST["codigoDepartamento"];
        
	$objProvincia = new Provincia();
        $resultado = $objProvincia->cargarListaDatos($codigoDepartamento);
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
