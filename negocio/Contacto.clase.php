<?php

require_once '../datos/Conexion.clase.php';

class Contacto extends Conexion {
    private $dni_contacto;
    private $apellidos;
    private $nombres;
    private $telefono;
    private $email;
    private $codigo_area;
    private $codigo_cargo;
    
    function getDni_contacto() {
        return $this->dni_contacto;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getEmail() {
        return $this->email;
    }

    function getCodigo_area() {
        return $this->codigo_area;
    }

    function getCodigo_cargo() {
        return $this->codigo_cargo;
    }

    function setDni_contacto($dni_contacto) {
        $this->dni_contacto = $dni_contacto;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setCodigo_area($codigo_area) {
        $this->codigo_area = $codigo_area;
    }

    function setCodigo_cargo($codigo_cargo) {
        $this->codigo_cargo = $codigo_cargo;
    }
        
    public function listar( $p_codigo_area, $p_codigo_cargo) {
        try {
            $sql = "select * from f_listar_contacto(:p_codigo_area, :p_codigo_cargo)";
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
    
    public function cargarListaDatos(){
        try {
            $sql = "select * from area";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll();
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
            
    }
    
    public function eliminar( $p_codigoArticulo ){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from articulo where codigo_articulo = :p_codigoArticulo";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigoArticulo", $p_codigoArticulo);
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
            $sql = "select dni_contacto from contacto where dni_contacto = :p_dni_contacto";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_dni_contacto", $this->getDni_contacto());
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                if ($this->getDni_contacto() == $resultado["dni_contacto"]){
                    Funciones::imprimeJSON(500, "DNI YA EXISTE", "");
                }else{
                    $sql = "
                            INSERT INTO public.contacto(
                                    dni_contacto, 
                                    apellidos, 
                                    nombres, 
                                    telefono, 
                                    email, 
                                    codigo_area, 
                                    codigo_cargo)
                            VALUES (
                                    :p_dni_contacto, 
                                    :p_apellidos, 
                                    :p_nombres, 
                                    :p_telefono, 
                                    :p_email, 
                                    :p_codigo_area, 
                                    :p_codigo_cargo
                            );
                        ";

                    //Preparar la sentencia
                    $sentencia = $this->dblink->prepare($sql);

                    //Asignar un valor a cada parametro
                    $sentencia->bindParam(":p_dni_contacto", $this->getDni_contacto());
                    $sentencia->bindParam(":p_apellidos", $this->getApellidos());
                    $sentencia->bindParam(":p_nombres", $this->getNombres());
                    $sentencia->bindParam(":p_telefono", $this->getTelefono());
                    $sentencia->bindParam(":p_email", $this->getEmail());
                    $sentencia->bindParam(":p_codigo_area", $this->getCodigo_area());
                    $sentencia->bindParam(":p_codigo_cargo", $this->getCodigo_cargo());

                    //Ejecutar la sentencia preparada
                    $sentencia->execute();
                    
                    $this->dblink->commit();
                
                    return true; //significa que todo se ha ejecutado correctamente
                }                
            }
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
    
    
    public function leerDatos($p_codigoArticulo) {
        try {
            $sql = "
                    select
                            a.*,
                            c.codigo_linea
                    from
                            articulo a 
                            inner join categoria c on ( a.codigo_categoria = c.codigo_categoria )
                    where
                            a.codigo_articulo = :p_codigo_articulo
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_articulo", $p_codigoArticulo);
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
                    update articulo set
                        nombre              = :p_nombre,
                        precio_venta        = :p_precio_venta,
                        codigo_categoria    = :p_codigo_categoria,
                        codigo_marca        = :p_codigo_marca
                    where
                        codigo_articulo     = :p_codigo_articulo
               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_nombre", $this->getNombre());
            $sentencia->bindParam(":p_precio_venta", $this->getPrecioVenta());
            $sentencia->bindParam(":p_codigo_categoria", $this->getCodigoCategoria());
            $sentencia->bindParam(":p_codigo_marca", $this->getCodigoMarca());
            $sentencia->bindParam(":p_codigo_articulo", $this->getCodigoArticulo());

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


