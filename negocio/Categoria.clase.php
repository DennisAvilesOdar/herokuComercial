<?php

require_once '../datos/Conexion.clase.php';

class Categoria extends Conexion {
    private $codigoCategoria;
    private $descripcion;
    private $codigoLinea;
    
    function getCodigoCategoria() {
        return $this->codigoCategoria;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getCodigoLinea() {
        return $this->codigoLinea;
    }

    function setCodigoCategoria($codigoCategoria) {
        $this->codigoCategoria = $codigoCategoria;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setCodigoLinea($codigoLinea) {
        $this->codigoLinea = $codigoLinea;
    }

    public function listar($p_codigoLinea){
        try {
            $sql = "select * from f_listar_categoria(:p_codigoLinea)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindparam(":p_codigoLinea", $p_codigoLinea);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }


    public function cargarListaDatos($p_codigoLinea){
	try {
            $sql = " select * from categoria where codigo_linea = :p_codigoLinea order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigoLinea", $p_codigoLinea);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function leerDatos($codigoCategoria) {
        try {
            $sql = "
                    select
                            *
                    from
                            categoria
                    where
                            codigo_categoria = :p_codigo_categoria
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_categoria", $codigoCategoria);
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
                    UPDATE public.categoria
                        SET descripcion = :p_descripcion, codigo_linea = :p_codigo_linea
                      WHERE codigo_categoria = :p_codigo_categoria;

               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_descripcion", $this->getDescripcion());
            $sentencia->bindParam(":p_codigo_linea", $this->getCodigoLinea());
            $sentencia->bindParam(":p_codigo_categoria", $this->getCodigoCategoria());

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
            $sql = "select * from f_generar_correlativo('categoria') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoCategoria = $resultado["nc"];
                $this->setCodigoCategoria($nuevoCodigoCategoria);
                
                $sql = "
                        INSERT INTO public.categoria(
                                codigo_categoria, 
                                descripcion, 
                                codigo_linea)
                        VALUES (
                                :p_codigo_categoria, 
                                :p_descripcion, 
                                :p_codigo_linea
                        );
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_categoria", $this->getCodigoCategoria());
                $sentencia->bindParam(":p_descripcion", $this->getDescripcion());
                $sentencia->bindParam(":p_codigo_linea", $this->getCodigoLinea());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'categoria'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla artículo");
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
    
    public function eliminar( $p_codigo_categoria ){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from categoria where codigo_categoria = :p_codigo_categoria";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_categoria", $p_codigo_categoria);
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
