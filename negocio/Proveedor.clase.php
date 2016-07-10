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
    
}
