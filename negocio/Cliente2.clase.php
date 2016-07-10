<?php

require_once '../datos/Conexion.clase.php';

class Cliente2 extends Conexion{
    
    private $codigo_cliente;
    private $apellido_paterno;
    private $apellido_materno;
    private $nombres;
    private $dni;
    private $direccion;
    private $email;
    private $codigo_departamento;
    private $codigo_provincia;
    private $codigo_distrito;
    private $clave;
    
    function getDni() {
        return $this->dni;
    }

    function setDni($dni) {
        $this->dni = $dni;
    }

        
    function getCodigo_cliente() {
        return $this->codigo_cliente;
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

    function getEmail() {
        return $this->email;
    }

    function getCodigo_departamento() {
        return $this->codigo_departamento;
    }

    function getCodigo_provincia() {
        return $this->codigo_provincia;
    }

    function getCodigo_distrito() {
        return $this->codigo_distrito;
    }

    function getClave() {
        return $this->clave;
    }

    function setCodigo_cliente($codigo_cliente) {
        $this->codigo_cliente = $codigo_cliente;
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

    function setEmail($email) {
        $this->email = $email;
    }

    function setCodigo_departamento($codigo_departamento) {
        $this->codigo_departamento = $codigo_departamento;
    }

    function setCodigo_provincia($codigo_provincia) {
        $this->codigo_provincia = $codigo_provincia;
    }

    function setCodigo_distrito($codigo_distrito) {
        $this->codigo_distrito = $codigo_distrito;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }


     public function agregar() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = "select * from f_generar_correlativo('cliente') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoCliente = $resultado["nc"];
                $this->setCodigo_cliente($nuevoCodigoCliente);
                
                $sql = "
                        INSERT INTO cliente
                                (
                                        codigo_cliente, 
                                        apellido_paterno, 
                                        apellido_materno, 
                                        nombres,
                                        nro_documento_identidad,
                                        direccion, 
                                        email, 
                                        codigo_departamento, 
                                        codigo_provincia, 
                                        codigo_distrito,
                                        clave
                                )
                            VALUES 
                                (
                                        :p_codigo_cliente, 
                                        :p_apellido_paterno, 
                                        :p_apellido_materno, 
                                        :p_nombres,
                                        :p_dni,
                                        :p_direccion, 
                                        :p_email, 
                                        :p_codigo_departamento, 
                                        :p_codigo_provincia, 
                                        :p_codigo_distrito,
                                        :p_clave
                                )
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_cliente", $this->getCodigo_cliente());
                $sentencia->bindParam(":p_apellido_paterno", $this->getApellido_paterno());
                $sentencia->bindParam(":p_apellido_materno", $this->getApellido_materno());
                $sentencia->bindParam(":p_nombres", $this->getNombres());
                $sentencia->bindParam(":p_dni", $this->getDni());
                $sentencia->bindParam(":p_direccion", $this->getDireccion());
                $sentencia->bindParam(":p_email", $this->getEmail());
                $sentencia->bindParam(":p_codigo_departamento", $this->getCodigo_departamento());
                $sentencia->bindParam(":p_codigo_provincia", $this->getCodigo_provincia());
                $sentencia->bindParam(":p_codigo_distrito", $this->getCodigo_distrito());
                $sentencia->bindParam(":p_clave", $this->getClave());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'cliente'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla cliente");
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
}
