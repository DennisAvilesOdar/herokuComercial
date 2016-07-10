<?php

session_name("sistemacomercial1");
session_start();

if (! isset( $_SESSION["s_nombre_cliente"] ) ){
    //Esto se cumple cuando el usuario no ha iniciado sesión
    header("location:index.cliente.php");
    exit;
}

//Capturando los datos del usuario que ha iniciado sesión
$nombreCliente = ucwords( strtolower($_SESSION["s_nombre_cliente"]) );



