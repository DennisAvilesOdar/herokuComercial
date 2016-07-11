<?php

require_once '../datos/Conexion.clase.php';

class Compra extends Conexion {
 
       private $numeroCompra;
       private $codigoTipoComprobante;
       private $numeroSerie; 
       private $numero_documento;
       private $fechaCompra;
       private $porcentajeIGV;
       private $subTotal;
       private $igv; 
       private $total;
       private $codigoCliente;
       private $estado;
       private $compraDetalle ;
       function getNumeroCompra() {
           return $this->numeroCompra;
       }
       function getCodigoCliente() {
           return $this->codigoCliente;
       }

       function setCodigoCliente($codigoCliente) {
           $this->codigoCliente = $codigoCliente;
       }

              function getCodigoTipoComprobante() {
           return $this->codigoTipoComprobante;
       }

    
       function getNumeroSerie() {
           return $this->numeroSerie;
       }

       function getNumero_documento() {
           return $this->numero_documento;
       }

       function getFechaCompra() {
           return $this->fechaCompra;
       }

       function getPorcentajeIGV() {
           return $this->porcentajeIGV;
       }

       function getSubTotal() {
           return $this->subTotal;
       }

       function getIgv() {
           return $this->igv;
       }

       function getTotal() {
           return $this->total;
       }

       function getEstado() {
           return $this->estado;
       }

       function getCompraDetalle() {
           return $this->compraDetalle;
       }

       function setNumeroCompra($numeroCompra) {
           $this->numeroCompra = $numeroCompra;
       }

       function setCodigoTipoComprobante($codigoTipoComprobante) {
           $this->codigoTipoComprobante = $codigoTipoComprobante;
       }

    

       function setNumeroSerie($numeroSerie) {
           $this->numeroSerie = $numeroSerie;
       }

       function setNumero_documento($numero_documento) {
           $this->numero_documento = $numero_documento;
       }

       function setFechaCompra($fechaCompra) {
           $this->fechaCompra = $fechaCompra;
       }

       function setPorcentajeIGV($porcentajeIGV) {
           $this->porcentajeIGV = $porcentajeIGV;
       }

       function setSubTotal($subTotal) {
           $this->subTotal = $subTotal;
       }

       function setIgv($igv) {
           $this->igv = $igv;
       }

       function setTotal($total) {
           $this->total = $total;
       }

      
       function setEstado($estado) {
           $this->estado = $estado;
       }

       function setCompraDetalle($compraDetalle) {
           $this->compraDetalle = $compraDetalle;
       }

       
       
       public function agregar() {
        $this->dblink->beginTransaction();
        try {
            $sql = "select * from f_generar_correlativo('compra_cliente') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoNumeroCompra = $resultado["nc"];
                $this->setNumeroCompra($nuevoNumeroCompra);
                
                
                $sql = "
                       INSERT INTO compra_cliente(numero_compra, codigo_tipo_comprobante, 
                       numero_serie, numero_documento, 
            fecha_compra, porcentaje_igv, sub_total, igv, total, codigo_cliente)
    
VALUES (:p_numero_compra, :p_codigo_tipo_comprobante, :p_numero_serie, :p_numero_documento, 
            :p_fecha_compra, :p_porcentaje_igv, :p_sub_total, :p_igv, :p_total, :p_codigo_cliente);

                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_numero_compra", $this->getNumeroCompra());
                $sentencia->bindParam(":p_codigo_tipo_comprobante", $this->getCodigoTipoComprobante());
                $sentencia->bindParam(":p_numero_serie", $this->getNumeroSerie());
                $sentencia->bindParam(":p_numero_documento", $this->getNumero_documento());
                $sentencia->bindParam(":p_fecha_compra", $this->getFechaCompra());
                $sentencia->bindParam(":p_porcentaje_igv", $this->getPorcentajeIgv());
                $sentencia->bindParam(":p_sub_total", $this->getSubTotal());
                $sentencia->bindParam(":p_igv", $this->getIgv());
                $sentencia->bindParam(":p_total", $this->getTotal());
                $sentencia->bindParam(":p_codigo_cliente", $this->getCodigoCliente());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                /*INSERTAR EN LA TABLA VENTA_DETALLE*/
                $detalleCompraArray = json_decode( $this->getCompraDetalle()); //Convertir de formato JSON a formato array
                    
                $item = 0;
                
                foreach ($detalleCompraArray as $key => $value) { //permite recorrer el array
                    
                    $sql = "select stock, nombre from articulo where codigo_articulo = :p_codigo_articulo";
                    $sentencia = $this->dblink->prepare($sql);
                    $sentencia->bindParam(":p_codigo_articulo", $value->codigoArticulo);
		    $sentencia->execute();
                    $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
                    if ($resultado["stock"] < $value->cantidad){
                        throw new Exception("No hay stock suficiente" . "\n" . "Artículo: " . $value->codigoArticulo . " - " . $resultado["nombre"] . "\n" . "Stock actual: " . $resultado["stock"] . "\n" . "Cantidad de venta: " . $value->cantidad);
                    }
                    

                    $sql = "
                           INSERT INTO compra_detalle_cliente(
            numero_compra, codigo_articulo, item, cantidad, precio, descuento)
    VALUES (
    :p_numero_compra, :p_codigo_articulo, :p_item, :p_cantidad, :p_precio, :p_descuento);";
                    
                    
                    //Preparar la sentencia
                    $sentencia = $this->dblink->prepare($sql);
                    
                    $item++;
                    
                    //Asignar un valor a cada parametro
                    $sentencia->bindParam(":p_numero_compra", $this->getNumeroCompra());
                                       
                    $sentencia->bindParam(":p_codigo_articulo", $value->codigoArticulo);
                    $sentencia->bindParam(":p_item", $item);
                    $sentencia->bindParam(":p_cantidad", $value->cantidad);
                    $sentencia->bindParam(":p_precio", $value->precio);
                    $descuento = 0;
                    $sentencia->bindParam(":p_descuento", $descuento);
              
                    //Ejecutar la sentencia preparada
                    $sentencia->execute();
                    
                 $sql = "DELETE FROM carrito_detalle WHERE codigo_cliente = :p_codigo_c";
                 $sentencia = $this->dblink->prepare($sql);
                 $sentencia->bindParam(":p_codigo_c", $this->getCodigoCliente());
                 $sentencia->execute();                      
                    /*ACTUALIZAR EL STOCK DE CADA ARTICULO VENDIDO*/
                    $sql = "update articulo 
                            set stock = stock + :p_cantidad 
                            where codigo_articulo = :p_codigo_articulo";
                    
                    $sentencia = $this->dblink->prepare($sql);
                    $sentencia->bindParam(":p_codigo_articulo", $value->codigoArticulo);
                    $sentencia->bindParam(":p_cantidad", $value->cantidad);
                    $sentencia->execute();
                    /*ACTUALIZAR EL STOCK DE CADA ARTICULO VENDIDO*/
                    
                
                }
                /*INSERTAR EN LA TABLA VENTA_DETALLE*/
                
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'compra_cliente'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                // actualizar ek correlativo segun el tipo de documento y la serie
                $sql = "update serie_comprobante set numero_documento = numero_documento + 1 
                        where codigo_tipo_comprobante = :p_codigo_tipo_comprobante and numero_serie = :p_numero_serie";
                    $sentencia = $this->dblink->prepare($sql);
                    $sentencia->bindParam(":p_codigo_tipo_comprobante", $this->getCodigoTipoComprobante());
                    $sentencia->bindParam(":p_numero_serie", $this->getNumeroSerie());
                    $sentencia->execute();                
//Terminar la transacción
                    
                 
                
                $this->dblink->commit();
                
                
                return true;
                
                
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
        
    }
    
    
    
    
    
    
    
    
    
    public function listar($fecha1, $fecha2, $tipo) {
        try {
            $sql = "select * from f_listar_compra1(:p_fecha1, :p_fecha2, :p_tipo)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_fecha1", $fecha1);
            $sentencia->bindParam(":p_fecha2", $fecha2);
            $sentencia->bindParam(":p_tipo", $tipo);
            $sentencia->execute();

            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function anular($numeroCompra) {
        $this->dblink->beginTransaction();
        try {
            $sql = "update compra set estado = 'A' where numero_compra = :p_numero_compra";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_numero_compra", $numeroCompra);
            $sentencia->execute();
            
            $sql = "select codigo_articulo, cantidad from compra_detalle where numero_compra = :p_numero_compra";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_numero_compra", $numeroCompra);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            for ($i = 0; $i < count($resultado); $i++) {
                $sql = "update articulo set stock = stock - :p_cantidad where codigo_articulo = :p_codigo_articulo";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_cantidad", $resultado[$i]["cantidad"]);
                $sentencia->bindParam(":p_codigo_articulo", $resultado[$i]["codigo_articulo"]);
                $sentencia->execute();
            }
            
            //Terminar la transacción
            $this->dblink->commit();
            
            return true;
                    
        } catch (Exception $exc) {
            throw $exc;
        }
    }

}
