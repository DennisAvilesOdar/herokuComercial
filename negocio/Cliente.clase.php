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
}
