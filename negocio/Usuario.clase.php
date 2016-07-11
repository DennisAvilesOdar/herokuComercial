<?php

require_once '../datos/Conexion.clase.php';

class Usuario extends Conexion{
    
    public function listarUsuario(){
        try {
            $sql = "
                SELECT 
                    usuario.codigo_usuario,
                    usuario.dni_usuario,
                    (personal.apellido_paterno||' '||personal.apellido_materno||' ,'||personal.nombres) as nombre_completo,
                    usuario.estado
                  FROM 
                    public.usuario, 
                    public.personal
                  WHERE 
                    personal.dni = usuario.dni_usuario;
                ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
}
