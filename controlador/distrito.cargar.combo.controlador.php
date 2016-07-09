<?php

    //require_once 'sesion.validar.controlador.php';

    require_once '../negocio/Distrito.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
        $codigoDepartamento = $_POST["p_codigo_departamento"];
        $codigoProvincia = $_POST["p_codigo_provincia"];
        
	$objDistrito = new Distrito();
        $resultado = $objDistrito->cargarListaDatos($codigoDepartamento, $codigoProvincia);
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
