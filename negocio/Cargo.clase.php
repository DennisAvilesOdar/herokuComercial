<?php

require_once '../datos/Conexion.clase.php';

class Cargo extends Conexion{
    private $codigoCargo;
    private $descripcion;
    
    function getCodigoCargo() {
        return $this->codigoCargo;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setCodigoCargo($codigoCargo) {
        $this->codigoCargo = $codigoCargo;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function listarCargo(){
        try {
            $sql="select * from cargo";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function leerDatos($codigoCargo) {
        try {
            $sql = "
                    select
                            *
                    from
                            cargo
                    where
                            codigo_cargo = :p_codigo_cargo
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_cargo", $codigoCargo);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function editar() {
        $this->dblink->beginTransaction();
        
        try {
           $sql = "     
                    UPDATE public.cargo
                        SET descripcion=:p_descripcion
                      WHERE codigo_cargo=:p_codigo_cargo;
               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_descripcion", $this->getDescripcion());
            $sentencia->bindParam(":p_codigo_cargo", $this->getCodigoCargo());

            //Ejecutar la sentencia preparada
            $sentencia->execute();
            
            
            $this->dblink->commit();
                
            return true;
            
        } catch (Exception $exc) {
           $this->dblink->rollBack();
           throw $exc;
        }
        
        return false;
            
    }
    
    public function agregar() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = "select * from f_generar_correlativo('cargo') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoCargo = $resultado["nc"];
                $this->setCodigoCargo($nuevoCodigoCargo);
                
                $sql = "
                        INSERT INTO public.cargo(
                                codigo_cargo, descripcion)
                        VALUES (:p_codigo_cargo, :p_descripcion);

                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_cargo", $this->getCodigoCargo());
                $sentencia->bindParam(":p_descripcion", $this->getDescripcion());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'cargo'";
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
    
    public function eliminar($codigoCargo){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from cargo where codigo_cargo = :p_codigo_cargo";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_cargo", $codigoCargo);
            $sentencia->execute();
            
            $this->dblink->commit();
            
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
        return false;
    }
    
    public function cargarListaDatos($p_codigo_cargo){
	try {
            $sql = " select * from cargo where codigo_cargo = :p_codigo_cargo";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_cargo", $p_codigo_cargo);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
}
