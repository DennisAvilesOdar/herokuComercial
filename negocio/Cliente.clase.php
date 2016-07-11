<?php

require_once '../datos/Conexion.clase.php';

class Cliente extends Conexion {
        
    private $codigo_cliente;
    private $apellido_paterno;
    private $apellido_materno;
    private $nombres;
    private $nro_documento_identidad;
    private $direccion;
    private $telefono_fijo;
    private $telefono_movil1;
    private $telefono_movil2;
    private $email;
    private $direccion_web;
    private $codigo_departamento;
    private $codigo_provincia;
    private $codigo_distrito;
    private $clave;
    
    function getClave() {
        return $this->clave;
    }

    function setClave($clave) {
        $this->clave = $clave;
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

    function getNro_documento_identidad() {
        return $this->nro_documento_identidad;
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

    function getDireccion_web() {
        return $this->direccion_web;
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

    function setNro_documento_identidad($nro_documento_identidad) {
        $this->nro_documento_identidad = $nro_documento_identidad;
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

    function setDireccion_web($direccion_web) {
        $this->direccion_web = $direccion_web;
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

    public function listar( $p_codigo_departamento, $p_codigo_provincia, $p_codigo_distrito) {
        try {
            $sql = "select * from f_listar_cliente(:p_codigo_departamento,:p_codigo_provincia,:p_codigo_distrito)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_departamento", $p_codigo_departamento);
            $sentencia->bindParam(":p_codigo_provincia", $p_codigo_provincia);
            $sentencia->bindParam(":p_codigo_distrito", $p_codigo_distrito);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function cargarDatosCliente($nombre) {
        try {
            $sql = "
		select 
		    codigo_cliente, 
		    (apellido_paterno || ' ' || apellido_materno || ', ' || nombres) as nombre_completo, 
		    direccion, 
		    telefono_fijo, 
		    coalesce(telefono_movil1, '-')  as movil1,
		    coalesce(telefono_movil2, '')  as movil2
		from 
		    cliente 
		where 
		    lower(apellido_paterno || ' ' || apellido_materno || ' ' || nombres) like :p_nombre";
            $sentencia = $this->dblink->prepare($sql);
            $nombre = '%'.  strtolower($nombre).'%';
            $sentencia->bindParam(":p_nombre", $nombre);
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
                                        telefono_fijo, 
                                        telefono_movil1, 
                                        telefono_movil2, 
                                        email, 
                                        direccion_web, 
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
                                        :p_nro_documento_identidad, 
                                        :p_direccion, 
                                        :p_telefono_fijo, 
                                        :p_telefono_movil1, 
                                        :p_telefono_movil2, 
                                        :p_email, 
                                        :p_direccion_web, 
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
                $sentencia->bindParam(":p_nro_documento_identidad", $this->getNro_documento_identidad());
                $sentencia->bindParam(":p_direccion", $this->getDireccion());
                $sentencia->bindParam(":p_telefono_fijo", $this->getTelefono_fijo());
                $sentencia->bindParam(":p_telefono_movil1", $this->getTelefono_movil1());
                $sentencia->bindParam(":p_telefono_movil2", $this->getTelefono_movil2());
                $sentencia->bindParam(":p_email", $this->getEmail());
                $sentencia->bindParam(":p_direccion_web", $this->getDireccion_web());
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
    
    public function leerDatos($p_codigoCliente) {
        try {
            $sql = "
                    SELECT 
                            codigo_cliente, 
                            apellido_paterno, 
                            apellido_materno, 
                            nombres, 
                            nro_documento_identidad, 
                            direccion, 
                            telefono_fijo, 
                            telefono_movil1, 
                            telefono_movil2, 
                            email, 
                            direccion_web, 
                            codigo_departamento, 
                            codigo_provincia, 
                            codigo_distrito,
                            clave
                        FROM cliente
                        where codigo_cliente = :p_codigo_cliente
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_cliente", $p_codigoCliente);
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
                    UPDATE cliente SET 
                                    codigo_cliente = :p_codigo_cliente,
                                    apellido_paterno = :p_apellido_paterno, 
                                    apellido_materno = :p_apellido_materno, 
                                    nombres = :p_nombres, 
                                    nro_documento_identidad = :p_nro_documento_identidad, 
                                    direccion = :p_direccion, 
                                    telefono_fijo = :p_telefono_fijo, 
                                    telefono_movil1 = :p_telefono_movil1, 
                                    telefono_movil2 = :p_telefono_movil2, 
                                    email = :p_email, 
                                    direccion_web = :p_direccion_web, 
                                    codigo_departamento = :p_codigo_departamento, 
                                    codigo_provincia = :p_codigo_provincia, 
                                    codigo_distrito = :p_codigo_distrito,
                                    clave = :p_clave
                     WHERE codigo_cliente = :p_codigo_cliente
               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_codigo_cliente", $this->getCodigo_cliente());
            $sentencia->bindParam(":p_apellido_paterno", $this->getApellido_paterno());
            $sentencia->bindParam(":p_apellido_materno", $this->getApellido_materno());
            $sentencia->bindParam(":p_nombres", $this->getNombres());
            $sentencia->bindParam(":p_nro_documento_identidad", $this->getNro_documento_identidad());
            $sentencia->bindParam(":p_direccion", $this->getDireccion());
            $sentencia->bindParam(":p_telefono_fijo", $this->getTelefono_fijo());
            $sentencia->bindParam(":p_telefono_movil1", $this->getTelefono_movil1());
            $sentencia->bindParam(":p_telefono_movil2", $this->getTelefono_movil2());
            $sentencia->bindParam(":p_email", $this->getEmail());
            $sentencia->bindParam(":p_direccion_web", $this->getDireccion_web());
            $sentencia->bindParam(":p_codigo_departamento", $this->getCodigo_departamento());
            $sentencia->bindParam(":p_codigo_provincia", $this->getCodigo_provincia());
            $sentencia->bindParam(":p_codigo_distrito", $this->getCodigo_distrito());
            $sentencia->bindParam(":p_clave", $this->getClave());

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
}
