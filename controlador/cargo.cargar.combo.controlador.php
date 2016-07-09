<?php

    //require_once 'sesion.validar.controlador.php';

    require_once '../negocio/Cargo.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
        $p_codigo_area = $_POST["p_codigo_area"];
        
	$objCargo = new Cargo();
        $resultado = $objCargo->cargarListaDatos($p_codigo_area);
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
