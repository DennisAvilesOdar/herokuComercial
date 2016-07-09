<?php

require_once '../datos/Conexion.clase.php';

class Marca extends Conexion {
    private $codigoMarca;
    private $descripcion;
    
    function getCodigoMarca() {
        return $this->codigoMarca;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setCodigoMarca($codigoMarca) {
        $this->codigoMarca = $codigoMarca;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    
    public function listarMarca(){
        try {
            $sql = "select * from marca order by 1 asc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function leerDatos($codigoMarca) {
        try {
            $sql = "
                    select
                            *
                    from
                            marca
                    where
                            codigo_marca = :p_codigo_marca
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_marca", $codigoMarca);
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
                    UPDATE public.marca
                        SET descripcion=:p_descripcion
                      WHERE codigo_marca=:p_codigo_marca
               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_descripcion", $this->getDescripcion());
            $sentencia->bindParam(":p_codigo_marca", $this->getCodigoMarca());

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
            $sql = "select * from f_generar_correlativo('marca') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoMarca = $resultado["nc"];
                $this->setCodigoMarca($nuevoCodigoMarca);
                
                $sql = "
                        INSERT INTO public.marca(
                                codigo_marca, 
                                descripcion)
                        VALUES (
                                :p_codigo_marca, 
                                :p_descripcion
                        );


                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_marca", $this->getCodigoMarca());
                $sentencia->bindParam(":p_descripcion", $this->getDescripcion());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'marca'";
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
    
    public function cargarListaDatos() {
	try {
            $sql = " select * from marca order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function eliminar($codigoMarca){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from marca where codigo_marca = :p_codigo_marca";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_marca", $codigoMarca);
            $sentencia->execute();
            
            $this->dblink->commit();
            
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
        return false;
    }
    
}
