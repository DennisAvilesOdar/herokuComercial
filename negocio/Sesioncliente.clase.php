<?php

require '../datos/Conexion.clase.php';

class Sesioncliente extends Conexion{
    
    private $email;
    private $clave;
    private $recordarUsuario;
    
    function getEmail() {
        return $this->email;
    }

    function getClave() {
        return $this->clave;
    }

    function getRecordarUsuario() {
        return $this->recordarUsuario;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setRecordarUsuario($recordarUsuario) {
        $this->recordarUsuario = $recordarUsuario;
    }
    
    public function iniciarSesion() {
        try {
            $sql = "
                       SELECT 
                            apellido_paterno, 
                            apellido_materno, 
                            nombres, 
                            clave
                        FROM cliente
                        where email = :p_email
                ";
            
            
            //Creamos una sentencia
            $sentencia = $this->dblink->prepare($sql);
            
            //Vincular el parametro1 p_email con el valor del atribito usuario;
            $sentencia->bindParam(":p_email", $this->getEmail());
            
            //ejecutar la sentencia
            $sentencia->execute();
            
            //Capturar el resultado que devuelve la sentencia
            $resultado = $sentencia->fetch();
            
            if ($resultado["clave"] ==  md5( $this->getClave() ) ){
                    //Usuario activo, Si puede ingresar a la app
                    session_name("sistemacomercial1");
                    session_start();
                    
                    $_SESSION["s_nombre_cliente"] = $resultado["apellido_paterno"]." ".$resultado["apellido_materno"].", ".$resultado["nombres"];
                    
                    if ($this->getRecordarUsuario()=="S"){
                        //El usuario ha marcado el Check
                        setcookie("loginusuario", $this->getEmail(), 0, "/");
                    }else{
                        setcookie("loginusuario", "", 0, "/");
                    }
                    
                    return 1;
                                    
            }else{
                //La clave ingresada por el usuario es diferente a la que esta grabada en la BD
                return 2;
            }
        
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }


}
