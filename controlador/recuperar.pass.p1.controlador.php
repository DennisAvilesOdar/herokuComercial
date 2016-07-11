<?php

require_once '../util/phpmailer/PHPMailerAutoload.php';
require_once '../util/funciones/Funciones.clase.php';
require_once '../negocio/Usuario.clase.php';

if ((! isset($_POST["p_correo"]))){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

$correo = $_POST["p_correo"];

$num_caracteres = "6"; // asignamos el número de caracteres que va a tener la nueva contraseña 
$codigo_seguridad = substr(md5(rand()),0,$num_caracteres); // generamos una nueva contraseña de forma aleatoria

$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPAuth = true;

//datos del correo
$mail->Username = "diegoperales_9@hotmail.com";
$mail->Host = "smtp-mail.outlook.com";
$mail->SMTPSecure = 'TLS';
$mail->Port = 587;
$mail->Password = "28dediciembre";

$mail->From = "amithsuo10gn@hotmail.com";
$mail->FromName = "Adrian Garcia";

$mail->Timeout = 30;

$body = "El usuario ".$correo." ha sulicitado el restablecimiento de Contraseña.";
$body .= "Su codigo de Seguridad es: ".$codigo_seguridad;

$mail->AddAddress($correo);
$mail->Subject = "Restablecer Contraseña";
$mail->Body = $body;

//esto es por si el que recibe no admite texto HTML en ese caso se usa texto plano
$mail->AltBody = "Mensaje de prueba mandado con phpmailer en formato solo texto";

$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

$exito = $mail->Send();

if(!$exito){
    Funciones::imprimeJSON(500, "Problemas enviando correo electrónico".$mail->ErrorInfo, "");
} else {
    try {
        $obj = new Usuario();
        $resultado = $obj->codigoSeguridad($correo, md5($codigo_seguridad));
        if($resultado ==true){
            Funciones::imprimeJSON(200, "Correo enviado correctamente", "");
        }
    } catch (Exception $exc) {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }
}