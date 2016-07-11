<?php

    //require_once 'sesion.validar.controlador.php';

    require_once '../negocio/Personal.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
	$objPersonal = new Personal();
        $resultado = $objPersonal->cargarListaDatos();
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
