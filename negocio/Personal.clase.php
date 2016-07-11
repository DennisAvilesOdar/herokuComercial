<?php

require_once '../datos/Conexion.clase.php';

class Personal extends Conexion{
    private $dni;
    private $apellido_paterno;
    private $apellido_materno;
    private $nombres;
    private $direccion;
    private $telefono_fijo;
    private $telefono_movil1;
    private $telefono_movil2;
    private $email;
    private $codigo_cargo;
    private $codigo_area;
    private $dni_jefe;
    
    function getDni() {
        return $this->dni;
    }

    function getApellido_paterno() {
        return $this->apellido_paterno;
    }

    function getApellido_materno() {
        return $this->apellido_materno;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getTelefono_fijo() {
        return $this->telefono_fijo;
    }

    function getTelefono_movil1() {
        return $this->telefono_movil1;
    }

    function getTelefono_movil2() {
        return $this->telefono_movil2;
    }

    function getEmail() {
        return $this->email;
    }

    function getCodigo_cargo() {
        return $this->codigo_cargo;
    }

    function getCodigo_area() {
        return $this->codigo_area;
    }

    function getDni_jefe() {
        return $this->dni_jefe;
    }

    function setDni($dni) {
        $this->dni = $dni;
    }

    function setApellido_paterno($apellido_paterno) {
        $this->apellido_paterno = $apellido_paterno;
    }

    function setApellido_materno($apellido_materno) {
        $this->apellido_materno = $apellido_materno;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setTelefono_fijo($telefono_fijo) {
        $this->telefono_fijo = $telefono_fijo;
    }

    function setTelefono_movil1($telefono_movil1) {
        $this->telefono_movil1 = $telefono_movil1;
    }

    function setTelefono_movil2($telefono_movil2) {
        $this->telefono_movil2 = $telefono_movil2;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setCodigo_cargo($codigo_cargo) {
        $this->codigo_cargo = $codigo_cargo;
    }

    function setCodigo_area($codigo_area) {
        $this->codigo_area = $codigo_area;
    }

    function setDni_jefe($dni_jefe) {
        $this->dni_jefe = $dni_jefe;
    }
    
    public function listar( $p_codigo_area, $p_codigo_cargo) {
        try {
            $sql = "select * from f_listar_personal(:p_codigo_area,:p_codigo_cargo)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_area", $p_codigo_area);
            $sentencia->bindParam(":p_codigo_cargo", $p_codigo_cargo);
            $sentencia->execute();            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function leerDatos($dni) {
        try {
            $sql = "select * from personal where dni = :p_dni";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindparam(":p_dni",$dni);
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
                    UPDATE public.personal
                        SET  apellido_paterno=:p_paterno, apellido_materno=:p_materno, nombres=:p_nombre, direccion=:p_direccion, 
                            telefono_fijo=:p_fijo, telefono_movil1=:p_1, telefono_movil2=:p_2, email=:p_correo, 
                            codigo_cargo=:p_cargo, codigo_area=:p_area, dni_jefe=null
                      WHERE dni=:p_dni
               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_paterno", $this->getApellido_paterno());
            $sentencia->bindParam(":p_materno", $this->getApellido_materno());
            $sentencia->bindParam(":p_nombre", $this->getNombres());
            $sentencia->bindParam(":p_direccion", $this->getDireccion());
            $sentencia->bindParam(":p_fijo", $this->getTelefono_fijo());
            $sentencia->bindParam(":p_1", $this->getTelefono_movil1());
            $sentencia->bindParam(":p_2", $this->getTelefono_movil2());
            $sentencia->bindParam(":p_correo", $this->getEmail());
            $sentencia->bindParam(":p_cargo", $this->getCodigo_cargo());
            $sentencia->bindParam(":p_area", $this->getCodigo_area());
            $sentencia->bindParam(":p_dni", $this->getDni());

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
                        INSERT INTO public.personal(
                                dni, 
                                apellido_paterno, 
                                apellido_materno, 
                                nombres, 
                                direccion, 
                                telefono_fijo, 
                                telefono_movil1, 
                                telefono_movil2, 
                                email, 
                                codigo_cargo, 
                                codigo_area, 
                                dni_jefe)
                        VALUES (
                                :p_dni, 
                                :p_apellido_paterno, 
                                :p_apellido_materno, 
                                :p_nombres, 
                                :p_direccion, 
                                :p_telefono_fijo, 
                                :p_telefono_movil1, 
                                :p_telefono_movil2, 
                                :p_email, 
                                :p_codigo_cargo, 
                                :p_codigo_area, 
                                null)
                        ;
                        ";

                    //Preparar la sentencia
                    $sentencia = $this->dblink->prepare($sql);

                    //Asignar un valor a cada parametro
                    $sentencia->bindParam(":p_dni", $this->getDni());
                    $sentencia->bindParam(":p_apellido_paterno", $this->getApellido_paterno());
                    $sentencia->bindParam(":p_apellido_materno", $this->getApellido_materno());
                    $sentencia->bindParam(":p_nombres", $this->getNombres());
                    $sentencia->bindParam(":p_direccion", $this->getDireccion());
                    $sentencia->bindParam(":p_telefono_fijo", $this->getTelefono_fijo());
                    $sentencia->bindParam(":p_telefono_movil1", $this->getTelefono_movil1());
                    $sentencia->bindParam(":p_telefono_movil2", $this->getTelefono_movil2());
                    $sentencia->bindParam(":p_email", $this->getEmail());
                    $sentencia->bindParam(":p_codigo_cargo", $this->getCodigo_cargo());
                    $sentencia->bindParam(":p_codigo_area", $this->getCodigo_area());
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
    
    public function eliminar($dni){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from personal where dni = :p_dni";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_dni", $dni);
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
            $sql = "select dni from personal order by 1";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll();
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
            
    }
    
}
