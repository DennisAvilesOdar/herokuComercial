<?php

    //require_once 'sesion.validar.controlador.php';

    require_once '../negocio/Distrito.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
        $codigoDepartamento = $_POST["codigoDepartamento"];
        $codigoProvincia = $_POST["codigoProvincia"];
        
	$objDistrito = new Distrito();
        $resultado = $objDistrito->cargarListaDatos($codigoDepartamento, $codigoProvincia);
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
