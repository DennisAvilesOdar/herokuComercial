<?php

require_once '../datos/Conexion.clase.php';

class Linea extends Conexion {
    
    private $codigoLinea;
    private $descripcion;
    
    function getCodigoLinea() {
        return $this->codigoLinea;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setCodigoLinea($codigoLinea) {
        $this->codigoLinea = $codigoLinea;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function listar(){
        try {
            $sql = "select * from linea";
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
            $sql = "select * from f_generar_correlativo('linea') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoLinea = $resultado["nc"];
                $this->setCodigoLinea($nuevoCodigoLinea);
                
                $sql = "
                        INSERT INTO public.linea(codigo_linea, descripcion)
                        VALUES (:p_codigo_linea, :p_descripcion);
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_linea", $this->getCodigoLinea());
                $sentencia->bindParam(":p_descripcion", $this->getDescripcion());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'linea'";
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
    
    public function editar() {
        $this->dblink->beginTransaction();
        
        try {
           $sql = "     
                    UPDATE linea
                       SET  descripcion = :p_descripcion
                     WHERE codigo_linea = :p_codigo_linea
               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_descripcion", $this->getDescripcion());
            $sentencia->bindParam(":p_codigo_linea", $this->getCodigoLinea());

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
    
    public function leerDatos($codigoLinea) {
        try {
            $sql = "select * from linea where codigo_linea = :p_codigo_linea";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindparam(":p_codigo_linea",$codigoLinea);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function eliminar($codigoLinea){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from linea where codigo_linea = :p_codigo_linea";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_linea", $codigoLinea);
            $sentencia->execute();
            
            $this->dblink->commit();
            
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
        return false;
    }
    
    public function cargarListaDatos(){
        try {
            $sql = "select * from linea order by 1";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll();
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
            
    }
    
}
