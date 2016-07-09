<?php

require_once '../datos/Conexion.clase.php';

class Provincia extends Conexion{
    private $codigoProvincia;
    private $nombre;
    private $codigoDepartamento;
    
    function getCodigoProvincia() {
        return $this->codigoProvincia;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCodigoDepartamento() {
        return $this->codigoDepartamento;
    }

    function setCodigoProvincia($codigoProvincia) {
        $this->codigoProvincia = $codigoProvincia;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCodigoDepartamento($codigoDepartamento) {
        $this->codigoDepartamento = $codigoDepartamento;
    }
    
    public function cargarListaDatos($p_codigo_departamento){
	try {
            $sql = " select * from provincia where codigo_departamento = :p_codigo_departamento order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_departamento", $p_codigo_departamento);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

}
