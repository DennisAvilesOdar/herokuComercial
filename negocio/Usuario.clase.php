<?php

require_once '../datos/Conexion.clase.php';

class Usuario extends Conexion{
    
    private $codigoUsuario;
    private $dni_usuario;
    private $clave;
    
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
                    usuario.estado
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
}
