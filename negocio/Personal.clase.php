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

}
