<?php

require_once '../datos/Conexion.clase.php';

class Proveedor extends Conexion{
    
    private $ruc_proveedor;
    private $razon_social;
    private $direccion;
    private $telefono;
    private $representante_legal;
    private $dni_contacto;
    
    function getRuc_proveedor() {
        return $this->ruc_proveedor;
    }

    function getRazon_social() {
        return $this->razon_social;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getRepresentante_legal() {
        return $this->representante_legal;
    }

    function getDni_contacto() {
        return $this->dni_contacto;
    }

    function setRuc_proveedor($ruc_proveedor) {
        $this->ruc_proveedor = $ruc_proveedor;
    }

    function setRazon_social($razon_social) {
        $this->razon_social = $razon_social;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setRepresentante_legal($representante_legal) {
        $this->representante_legal = $representante_legal;
    }

    function setDni_contacto($dni_contacto) {
        $this->dni_contacto = $dni_contacto;
    }

    public function listar() {
        try {
            $sql = "select * from proveedor";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function leerDatos($rucProveedor) {
        try {
            $sql = "select * from proveedor where ruc_proveedor = :p_ruc_proveedor";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindparam(":p_ruc_proveedor",$rucProveedor);
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
                    UPDATE public.proveedor
                        SET  razon_social=:p_razon_social, direccion=:p_direccion, telefono=:p_telefono, representante_legal=:p_legal
                      WHERE ruc_proveedor = :p_ruc_proveedor;
               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_razon_social", $this->getRazon_social());
            $sentencia->bindParam(":p_direccion", $this->getDireccion());
            $sentencia->bindParam(":p_telefono", $this->getTelefono());
            $sentencia->bindParam(":p_legal", $this->getRepresentante_legal());
            $sentencia->bindParam(":p_ruc_proveedor", $this->getRuc_proveedor());

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
                    $sql = "
                        INSERT INTO public.proveedor(
                            ruc_proveedor, 
                            razon_social, 
                            direccion, 
                            telefono, 
                            representante_legal)
                        VALUES (
                            :p_ruc_proveedor, 
                            :p_razon_social, 
                            :p_direccion, 
                            :p_telefono, 
                            :p_representante_legal
                        );
                        ";

                    //Preparar la sentencia
                    $sentencia = $this->dblink->prepare($sql);

                    //Asignar un valor a cada parametro
                    $sentencia->bindParam(":p_ruc_proveedor", $this->getRuc_proveedor());
                    $sentencia->bindParam(":p_razon_social", $this->getRazon_social());
                    $sentencia->bindParam(":p_direccion", $this->getDireccion());
                    $sentencia->bindParam(":p_telefono", $this->getTelefono());
                    $sentencia->bindParam(":p_representante_legal", $this->getRepresentante_legal());
                    //Ejecutar la sentencia preparada
                    $sentencia->execute();

                    $this->dblink->commit();
                
                    return true; //significa que todo se ha ejecutado correctamente
                }                
         catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
    
    public function eliminar($rucProveedor){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from proveedor where ruc_proveedor = :p_ruc_proveedor";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_ruc_proveedor", $rucProveedor);
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
