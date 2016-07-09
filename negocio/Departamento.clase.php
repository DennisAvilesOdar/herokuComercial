<?php

require_once '../datos/Conexion.clase.php';

class Departamento extends Conexion{
    private $codigo_departamento;
    private $nombre;
    
    function getCodigo_departamento() {
        return $this->codigo_departamento;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setCodigo_departamento($codigo_departamento) {
        $this->codigo_departamento = $codigo_departamento;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function cargarListaDatos(){
        try {
            $sql = "select * from departamento order by 1";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll();
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
            
    }
    
}
