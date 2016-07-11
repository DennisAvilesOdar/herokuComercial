<?php

require_once '../datos/Conexion.clase.php';

class Cesta extends Conexion {
private $numero_carrito;
private $codigo_cliente;
private $codigoArticulo;
private $porcentaje_igv;
private $total;
private $cantidad;

function getCodigoArticulo() {
    return $this->codigoArticulo;
}

function setCodigoArticulo($codigoArticulo) {
    $this->codigoArticulo = $codigoArticulo;
}

function getCantidad() {
    return $this->cantidad;
}

function setCantidad($cantidad) {
    $this->cantidad = $cantidad;
}

    
function getNumero_carrito() {
    return $this->numero_carrito;
}

function getCodigo_cliente() {
    return $this->codigo_cliente;
}

function getPorcentaje_igv() {
    return $this->porcentaje_igv;
}

function getTotal() {
    return $this->total;
}

function setNumero_carrito($numero_carrito) {
    $this->numero_carrito = $numero_carrito;
}

function setCodigo_cliente($codigo_cliente) {
    $this->codigo_cliente = $codigo_cliente;
}

function setPorcentaje_igv($porcentaje_igv) {
    $this->porcentaje_igv = $porcentaje_igv;
}

function setTotal($total) {
    $this->total = $total;
}


    
    
    public function listar( $p_codigoCliente) {
        try {
            $sql = "select * from f_listar_cesta(:p_codigoCliente)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigoCliente", $p_codigoCliente);
            
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function eliminar($p_codigoArticulo,  $p_codigoCliente){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from carrito_detalle where codigo_articulo = :p_codigoArticulo and
                     codigo_cliente = :p_codigoCliente";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigoArticulo", $p_codigoArticulo);
            $sentencia->bindParam(":p_codigoCliente", $p_codigoCliente);
            $sentencia->execute();
            
            $this->dblink->commit();
            
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
        return false;
    }
    
    
     public function leerDatos($p_codigoArticulo, $p_codigoCliente) {
        try {
            $sql = "
                    SELECT 
  articulo.codigo_articulo, 
  articulo.nombre, 
  carrito_detalle.cantidad
FROM 
  public.articulo, 
  public.carrito_detalle
WHERE 
  articulo.codigo_articulo = carrito_detalle.codigo_articulo
  and 
  carrito_detalle.codigo_cliente = :p_codigo_cliente and   articulo.codigo_articulo = :p_codigo_articulo";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_articulo", $p_codigoArticulo);
            $sentencia->bindParam(":p_codigo_cliente", $p_codigoCliente);
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
           $sql = "select * from carrito where codigo_cliente = :p_codigoCliente";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigoCliente", $this->getCodigo_cliente());
            
            $sentencia->execute();
                 $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);             
                
                $sql = "
                      INSERT INTO carrito_detalle(
            codigo_articulo, numero_carrito, cantidad, codigo_cliente)
            VALUES (:p_codigo_articulo, :p_numero_carrito, :p_cantidad, :p_codigo_cliente);";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_articulo", $this->getCodigoArticulo());
                $sentencia->bindParam(":p_numero_carrito", $resultado["numero_carrito"]);
                $sentencia->bindParam(":p_cantidad", $this->getCantidad());
                $sentencia->bindParam(":p_codigo_cliente", $this->getCodigo_cliente());
                $sentencia->execute();                
//Terminar la transacción
                $this->dblink->commit();
                
                
                return true;   
           
                    
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
    
    
    
    public function editar() {
        $this->dblink->beginTransaction();
        
        try {
           $sql = " 

update carrito_detalle set cantidad = :p_cantidad
WHERE 
codigo_cliente = :p_codigo_cliente and   codigo_articulo = :p_codigo_articulo
               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_cantidad", $this->getCantidad());
            $sentencia->bindParam(":p_codigo_cliente", $this->getCodigo_cliente());
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
    
    
    public function cargarDatosArticulo($p_nombreArticulo) {
        try {
            $sql = "select  
                        codigo_articulo, 
                        nombre, 
                        precio_venta 
                    from 
                        articulo 
                    where 
                        lower(nombre) like :p_nombreArticulo";
            
            $sentencia = $this->dblink->prepare($sql);
            $valorBusqueda = '%' . strtolower($p_nombreArticulo) . '%';
            $sentencia->bindParam(":p_nombreArticulo", $valorBusqueda);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function articulosPorLinea(){
        try {
            $sql = "
                select 
                        l.descripcion as linea,
                        count(a.*) as cantidad
                from
                        articulo a inner join categoria c on (a.codigo_categoria = c.codigo_categoria)
                        inner join linea l on (l.codigo_linea = c.codigo_linea)
                group by
                        l.descripcion
                order by
                        1
                ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function articuloVenta(){
        try {
            $sql = "
                SELECT 
                    a.nombre as nombre, 
                    sum(vd.cantidad) as cantidad, 
                    sum(vd.importe) as importe
                  FROM 
                    articulo a inner join venta_detalle vd on (a.codigo_articulo=vd.codigo_articulo)
                    inner join venta v on (vd.numero_venta = v.numero_venta)
                  WHERE
                    v.estado = 'E'
                  GROUP BY
                    a.nombre
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function reporte(){
        try {
            $sql = '
                select 
                        pais,
                        sum(case when mes = 1 then (importe) else 0 end) as Enero,
                        sum(case when mes = 2 then (importe) else 0 end) as Febrero,
                        sum(case when mes = 3 then (importe) else 0 end) as Marzo,
                        sum(case when mes = 4 then (importe) else 0 end) as Abril,
                        sum(case when mes = 5 then (importe) else 0 end) as Mayo,
                        sum(case when mes = 6 then (importe) else 0 end) as Junio,
                        sum(case when mes = 7 then (importe) else 0 end) as Julio,
                        sum(case when mes = 8 then (importe) else 0 end) as Agosto,
                        sum(case when mes = 9 then (importe) else 0 end) as Setiembre,
                        sum(case when mes = 10 then (importe) else 0 end) as Octubre,
                        sum(case when mes = 11 then (importe) else 0 end) as Nombriembre,
                        sum(case when mes = 12 then (importe) else 0 end) as Diciembre,
                        sum(importe) as total

                from
                (
                        SELECT 
                          extract(month from orders."OrderDate") as mes, 
                          order_details."UnitPrice" * order_details."Quantity" as importe,
                          orders."ShipCountry" as pais
                        FROM 
                          public.orders, 
                          public.order_details
                        WHERE 
                          orders."OrderID" = order_details."OrderID"

                ) as ordenes
                group by
                  pais
                order by
                 pais asc
                ';
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
}


//
//
//$sql = "select * from f_generar_correlativo('carrito') as nc";
//            $sentencia = $this->dblink->prepare($sql);
//            $sentencia->execute();
//            $resultado = $sentencia->fetch();
//            
//            if ($sentencia->rowCount()){
//                $nuevoCodigoCarrito= $resultado["nc"];
//                $this->setNumero_carrito($nuevoCodigoCarrito);
//                $sql = "
//                     INSERT INTO carrito(
//            numero_carrito, codigo_cliente)
//            VALUES (:p_numero_carrito, :p_codigo_cliente);";
//                
//                //Preparar la sentencia
//                $sentencia = $this->dblink->prepare($sql);
//                
//                //Asignar un valor a cada parametro
//                $sentencia->bindParam(":p_numero_carrito", $this->getNumero_carrito());
//                $sentencia->bindParam(":p_codigo_cliente", $this->getCodigo_cliente());
//                
//                //Ejecutar la sentencia preparada
//                $sentencia->execute();
//                //Actualizar el correlativo en +1
//                $sql = "update correlativo set numero = numero + 1 where tabla = 'carrito'";
//                $sentencia = $this->dblink->prepare($sql);
//                $sentencia->execute();
//                $this->dblink->commit();
//                return true; //significa que todo se ha ejecutado correctamente
//                
//            }else{
//                throw new Exception("No se ha configurado el correlativo para la tabla carrito");
//            }