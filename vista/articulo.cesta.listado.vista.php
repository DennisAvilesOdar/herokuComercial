<?php
    require_once 'sesion.validar.vista.php';
    
    require_once '../util/funciones/definiciones.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo C_NOMBRE_SOFTWARE; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	
        <?php
	    include 'estilos.vista.php';
            
              ?>

    </head>
    <body class="skin-green layout-top-nav">
        <!-- Site wrapper -->
        <div class="wrapper">

            <?php
                include 'cabecera.vista.php';
            ?>

            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
             

		<small>
                    <section>
                        
                        <small>
                                        
		    <form id="frmcesta">
			<div class="modal fade" id="myModalE" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                              <p>__</p>
			    <div class="modal-content  col-xs-12 ">
			      <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titulomodal">Cambiar cantidad de artículos</h4>
			      </div>
			      <div class="modal-body">
		<input type="hidden" name="txttipooperacion" id="txttipooperacion" class="form-control">		  
				  
                
                 <div class="row">
                                      <p></p>
                                        <div class="col-xs-4">
                                            <p> Código del artículo:   </div>
                                        <div class="col-xs-2">
                                            <input type="text" name="txtcodigo" id="txtcodigo" class="form-control input-sm" placeholder="" readonly="">
					
				    </div>
				  </div>
                                
                                           &nbsp; 
                              
                                           
                                 <div class="row">
                                      <p></p>
                                        <div class="col-xs-4">
                                            <p> Nombre del artículo:   </div>
                                        <div class="col-xs-8">
                                            <input type="text" name="txtnombre" id="txtnombre" class="form-control input-sm" placeholder="" readonly="">
					
				    </div>
				  </div>
                                  
                                   &nbsp; 
				  <div class="row">
                                      <p></p>
                                        <div class="col-xs-4">
                                            <p> Cantidad:  <font color = "red"> *</font> </p> </div>
                                        <div class="col-xs-2">
					    <input type="text" name="txtcantidad" id="txtcantidad" class="form-control input-sm" placeholder="" required="">
					
				    </div>
				  </div>
				  
				  <p>
				      <font color = "red">* Campos obligatorios</font>
				  </p>
			      </div>
			      <div class="modal-footer">
				  <button type="submit" class="btn btn-success" aria-hidden="true"><i class="fa fa-save"></i> Grabar</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal" id="btncerrar"><i class="fa fa-close"></i> Cerrar</button>
			      </div>
			    </div>
			  </div>
			</div>
		    </form>
			</small>  
                        
                           
                        
                    <div class="row">
                        
                        <form class="form-inline">
                            
                        </form>
                                                     
                                
                                    
                                    
                                        
                                    
                                    
                     <form id="frmcompra">
                         <section class="content-header">
                    <h1 class="text-bold text-black" style="font-size: 20px;">Artículos de la cesta</h1>
                      &nbsp;
            
                      
                      <div class="box box-success">
                        <div class="box-body">
                              <div class="row">
                                  <div class="col-xs-3">
                                      <div class="form-group">
                                        <p>Nº compra:</p>
                                        <input type="text" class="form-control input-sm" readonly="" id="txtnro" name="txtnro"/>
                                      </div>
                                  </div>

                                  <div class="col-xs-3">
                                      <div class="form-group">
                                        <p>Tipo comprobante:</p>
                                        
                                        <select class="form-control input-sm" id="cbotipocomp" name="cbotipocomp" required="">
                                        </select>
                                      </div>
                                  </div>

                                  <div class="col-xs-3">
                                      <div class="form-group">
                                        <p>Serie:</p>
					    <select class="form-control input-sm" id="cboserie" name="cboserie" required="">
					    </select>
                                      </div>
                                  </div>

                                  <div class="col-xs-3">
                                      <div class="form-group">
                                        <p>Nº Documento</p>
                                        <input type="text" class="form-control input-sm" id="txtnrodoc" name="txtnrodoc" required=""/>
                                      </div>
                                  </div>

                             </div><!-- /row -->
                              
                               <div class="row">
                        
                    <div class="form-group">
                        <div class="col-xs-2">
                       <p>Fecha de venta: </p>
                        
                                        <input type="date" class="form-control input-sm" id="txtfech" name="txtfech" readonly="" value="<?php echo date('Y-m-d'); ?>"/>
                                     
                        </div>
                        <div class="col-xs-1">
                         <p>IGV: </p>          
                         <input type="text" class="form-control input-sm" id="txtigv" name="txtigv" readonly="">
                    </div>
                    </div>
                      
                    </div>                        <!-- /row -->
                          </div>
                    </div>
                          
                      
                    <ol class="breadcrumb">
                        <button type="button" class="btn btn-danger btn-sm" id="btnregresarc">Regresar</button>
                       
                        <button type="submit" class="btn btn-primary btn-sm">Realizar la Compra</button>
                       &nbsp;
                       <!-- <button type="submit" class="btn btn-primary btn-sm">Registrar la compra</button>
                    --></ol>
                              
                                
                </section>
                          
              &nbsp;                   
                            
                
                              
                    
                   <div class="box box-success">
                            <div class="box-body">
                                        
                        
                        <table  class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>CÓDIGO</th>
                                                <th>ARTÍCULO</th>
                                                <th style="text-align: left">PRECIO</th>
                                                <th style="text-align: left">CANTIDAD</th>
                                                <th style="text-align: left">IMPORTE</th>
                                                <th style="text-align: left">OPCIONES</th>
                                               
                                            </tr>
                                        </thead>
                                        
                                        <tbody id="listadocesta">
                                            
                                        </tbody>
                                            
                                        
                                        
                                    </table>
                        
                               
                                </div>
                            </div>
               
        <div class="box box-success">
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-xs-3">
                                      <div class="input-group">
                                        <span class="input-group-addon">SUB.TOTAL:</span>
                                        <input type="text" class="form-control text-right text-bold" id="txtimportesubtotal" name="txtimportesubtotal" readonly="" style="width: 100px;" />
                                      </div>
                                  </div>
                                  <div class="col-xs-3">
                                      <div class="input-group">
                                        <span class="input-group-addon">IGV:</span>
                                        <input type="text" class="form-control text-right text-bold" id="txtimporteigv" name="txtimporteigv" readonly="" style="width: 100px;"/>
                                      </div>
                                  </div>
                                  <div class="col-xs-3">
                                      <div class="input-group">
                                        <span class="input-group-addon">NETO A PAGAR:</span>
                                        <input type="text" class="form-control text-right text-bold" id="txtimporteneto" name="txtimporteneto" readonly="" style="width: 100px;"/>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>                
    </form>        
                  
                </section>
                
		</small>
            </div>
        </div><!-- ./wrapper -->
	<?php
	    include 'scripts.vista.php';
	?>
	
	<!--JS-->
        <script src="js/cesta.js" type="text/javascript"></script>
        <script src="js/cargar-combos.venta.js" type="text/javascript"></script>
        <script src="js/compra.js" type="text/javascript"></script>

    </body>
</html>

<!--


<small>
                                        
		    <form id="frmgrabar">
			<div class="modal fade" id="myModalE" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titulomodal">Cambiar cantidad de artículos</h4>
			      </div>
			      <div class="modal-body">
				  
				  <div class="row">
				    <div class="col-xs-3">
					<p>
                                        
                                            Código artículo  </p>
                                             
                                           <input type="text" name="txtcodigo" id="txtcodigo" class="form-control input-sm text-center text-bold" placeholder="" readonly="">
                                   
				    </div>
				  </div>
                                
                                           &nbsp; 
                                  <p>Nombre del Artículo </p>
                                  <input type="text" name="txtnombre" id="txtnombre" class="form-control input-sm text-center text-bold" placeholder="" readonly="">
                         
                                  
				  <div class="row">
				    <div class="col-xs-6">
                                        <p> 
                                        </p>
                                        <p>
					    Cantidad 
                                             
                                            <font color = "red">*</font> </p>
					    <input type="text" name="txtcantidad" id="txtcantidad" class="form-control input-sm" placeholder="" required="">
					
				    </div>
				  </div>
				  
				  <p>
				      <font color = "red">* Campos obligatorios</font>
				  </p>
			      </div>
			      <div class="modal-footer">
				  <button type="submit" class="btn btn-success" aria-hidden="true"><i class="fa fa-save"></i> Grabar</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal" id="btncerrar"><i class="fa fa-close"></i> Cerrar</button>
			      </div>
			    </div>
			  </div>
			</div>
		    </form>
			</small>