<?php

session_name("sistemacomercial1");
session_start();

require_once '../negocio/Compra.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_datosFormulario"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

$datosFormulario = $_POST["p_datosFormulario"];
$datosJSONDetalle = $_POST["p_datosJSONDetalle"];

//Convertir todos los datos que llegan concatenados a un array
parse_str($datosFormulario, $datosFormularioArray);

echo '<pre>';
print_r($datosJSONDetalle);
echo '</pre>';
echo '<pre>';
print_r($datosFormularioArray);
echo '</pre>';
exit();

try {
$objVenta = new Compra();
    $objVenta->setCodigoTipoComprobante( $datosFormularioArray["cbotipocomp"]);
    $objVenta->setNumeroSerie( $datosFormularioArray["cboserie"]);
    $objVenta->setNumero_documento( $datosFormularioArray["txtnrodoc"]);
    $objVenta->setFechaCompra( $datosFormularioArray["txtfech"]);
    $objVenta->setPorcentajeIGV( $datosFormularioArray["txtigv"]);
    $objVenta->setSubTotal( $datosFormularioArray["txtimportesubtotal"]);
    $objVenta->setIgv( $datosFormularioArray["txtimporteigv"]);
    $objVenta->setTotal( $datosFormularioArray["txtimporteneto"]);
    $clien=1;
    $objVenta->setCodigoCliente($clien);
    
    
    //Enviar los datos del detalle en formato JSON
    $objVenta->setCompraDetalle( $datosJSONDetalle );
    
    $resultado = $objVenta->agregar();
    
    if ($resultado == true){
        Funciones::imprimeJSON(200, "Su ha sido registrada correctamente", "");
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}



