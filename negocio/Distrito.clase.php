<?php

require_once '../datos/Conexion.clase.php';

class Distrito extends Conexion{
    private $codigoDistrito;
    private $nombre;
    private $codigoProvincia;
    private $codigoDepartamento;
    
    function getCodigoDistrito() {
        return $this->codigoDistrito;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCodigoProvincia() {
        return $this->codigoProvincia;
    }

    function getCodigoDepartamento() {
        return $this->codigoDepartamento;
    }

    function setCodigoDistrito($codigoDistrito) {
        $this->codigoDistrito = $codigoDistrito;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCodigoProvincia($codigoProvincia) {
        $this->codigoProvincia = $codigoProvincia;
    }

    function setCodigoDepartamento($codigoDepartamento) {
        $this->codigoDepartamento = $codigoDepartamento;
    }
    
    public function cargarListaDatos($p_codigo_departamento,$p_codigo_provincia){
	try {
            $sql = " select * from distrito where codigo_provincia = :p_codigo_provincia and codigo_departamento = :p_codigo_departamento order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_provincia", $p_codigo_provincia);
            $sentencia->bindParam(":p_codigo_departamento", $p_codigo_departamento);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

}
