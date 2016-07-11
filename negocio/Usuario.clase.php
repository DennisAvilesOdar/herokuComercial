<?php

require_once '../datos/Conexion.clase.php';

class Usuario extends Conexion{
    
    private $codigoUsuario;
    private $dni_usuario;
    private $clave;
    private $usuario;
    private $correo;
    private $codigoSeguridad;
    
    function getUsuario() {
        return $this->usuario;
    }

    function getCorreo() {
        return $this->correo;
    }

    function getCodigoSeguridad() {
        return $this->codigoSeguridad;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }

    function setCodigoSeguridad($codigoSeguridad) {
        $this->codigoSeguridad = $codigoSeguridad;
    }
    
    function getClave() {
        return $this->clave;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function getCodigoUsuario() {
        return $this->codigoUsuario;
    }

    function getDni_usuario() {
        return $this->dni_usuario;
    }

    function setCodigoUsuario($codigoUsuario) {
        $this->codigoUsuario = $codigoUsuario;
    }

    function setDni_usuario($dni_usuario) {
        $this->dni_usuario = $dni_usuario;
    }

        
    public function listarUsuario(){
        try {
            $sql = "
                SELECT 
                    usuario.codigo_usuario,
                    usuario.dni_usuario,
                    (personal.apellido_paterno||' '||personal.apellido_materno||' ,'||personal.nombres) as nombre_completo,
                    (case when usuario.estado = 'A' then 'Activo' else 'Inactivo' end) as estado
                  FROM 
                    public.usuario, 
                    public.personal
                  WHERE 
                    personal.dni = usuario.dni_usuario;
                ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    
    public function agregar() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = "select * from f_generar_correlativo('usuario') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigousuario = $resultado["nc"];
                $this->setCodigoUsuario($nuevoCodigousuario);
                
                $sql = "
                        INSERT INTO public.usuario(
                                codigo_usuario, 
                                dni_usuario, 
                                clave)
                        VALUES (
                                :p_codigo_usuario, 
                                :p_dni_usuario, 
                                :p_clave);
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_usuario", $this->getCodigoUsuario());
                $sentencia->bindParam(":p_dni_usuario", $this->getDni_usuario());
                $sentencia->bindParam(":p_clave", $this->getClave());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'usuario'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla linea");
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
    public function cambiarClave() {
        $this->dblink->beginTransaction();
        try {
            $sql = "update cliente set clave = :p_pass where email = :p_usuario";
            $sentencia = $this->dblink->prepare($sql);
            
            $sentencia->bindParam(":p_pass", $this->getClave());
            $sentencia->bindParam(":p_usuario", $this->getUsuario());
            $sentencia->execute();
            
            $this->dblink->commit();
            
            return true;
            
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
    }
    
    public function buscarUsuario() {
        try {
            $sql = " SELECT email, estado FROM cliente WHERE email = :p_usuario";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_usuario", $this->getUsuario());
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($resultado["email"] ==  $this->getUsuario()){
                if ($resultado["estado"] == "I"){
                    //Usuario inactivo, NO puede ingresar a la app
                    return 0;
                }else{
                    //Usuario activo, procede a restablecer
                    return 1;
                }
            }else{
                //El usuario o correo no esta grabado en la BD
                return 2;
            }
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function codigoSeguridad($usuario, $codigoseguridad) {
        $this->dblink->beginTransaction();
        try {
            $sql = "update cliente set codigoseguridad = :p_codigoseguridad where email = :p_usuario";
            $sentencia = $this->dblink->prepare($sql);
            
            $sentencia->bindParam(":p_codigoseguridad", $codigoseguridad);
            $sentencia->bindParam(":p_usuario", $usuario);
            $sentencia->execute();
            
            $this->dblink->commit();
            
            return true;
            
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
    }
    
    public function confirmarCodigoSeguridad() {
        try {
            $sql = "SELECT email FROM cliente WHERE email = :p_usuario and codigoseguridad = :p_codigoseguridad";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_usuario", $this->getUsuario());
            $sentencia->bindParam(":p_codigoseguridad", $this->getCodigoSeguridad());
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($resultado["email"] ==  $this->getUsuario()){
                //Codigo de seguridad correcto, procede a restablecer
                return 1;
            }else{
                //Codigo de seguridad incorrecto
                return 2;
            }
        } catch (Exception $exc) {
            throw $exc;
        }
    }
}
