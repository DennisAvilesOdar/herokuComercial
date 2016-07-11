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

            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                       &nbsp;    
                    &nbsp; 
                          &nbsp; 
                    <h1 class="text-bold text-black" style="font-size: 20px;">Lista de articulos disponibles</h1>
                   &nbsp; 
                      &nbsp; 
                         &nbsp; 
                </section>

                <section class="content">
		    <!-- INICIO del formulario modal -->
		
                     <small>
                                        
		    <form id="frmarticulo">
			<div class="modal fade" id="myModalCA" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                              <p>__</p>
			    <div class="modal-content  col-xs-12 ">
			      <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titulomodal">Añadir producto a la cesta</h4>
			      </div>
			      <div class="modal-body">
		<input type="hidden" name="txttipooperacion" id="txttipooperacion" class="form-control">		  
				  
                
                 <div class="row">
                                      <p></p>
                                        <div class="col-xs-4">
                                            <p> Código del artículo:   </div>
                                        <div class="col-xs-2">
                                            <input type="text" name="txtcodigomodal" id="txtcodigomodal" class="form-control input-sm" placeholder="" readonly="">
					
				    </div>
				  </div>
                                
                                           &nbsp; 
                                  
                                  <!--<div class="row">
                                      
                                   <div class="col-xs-3">
                                  <p>Nombre</p> <input type="text" name="txtnombre" id="txtnombre" class="form-control input-sm text-center text-bold" placeholder="" readonly="">
                                   </div>
                                   </div>-->
                                           
                                 <div class="row">
                                      <p></p>
                                        <div class="col-xs-4">
                                            <p> Nombre del artículo:   </div>
                                        <div class="col-xs-8">
                                            <input type="text" name="txtnombremodal" id="txtnombremodal" class="form-control input-sm" placeholder="" readonly="">
					
				    </div>
				  </div>
                                  
                                   &nbsp; 
				  <div class="row">
                                      <p></p>
                                        <div class="col-xs-4">
                                            <p> Cantidad:  <font color = "red"> *</font> </p> </div>
                                        <div class="col-xs-2">
                                            <input type="text" name="txtcantidadmodal" id="txtcantidadmodal" class="form-control input-sm" placeholder="1">
					
				    </div>
				  </div>
				  
				  <p>
				      <font color = "red">* Campos obligatorios</font>
				  </p>
			      </div>
			      <div class="modal-footer">
				  <button type="submit" class="btn btn-success" aria-hidden="true"><i class="fa fa-save"></i> Añadir</button>
				  <button type="button" class="btn btn-default" data-dismiss="modal" id="btncerrar"><i class="fa fa-close"></i> Cerrar</button>
			      </div>
			    </div>
			  </div>
			</div>
		    </form>
			</small>  
                                        
                    
                    
                    
                    
		    <!-- FIN del formulario modal -->

                    <div class="row">
                        <div class="col-xs-3">
                            <select id="cbolinea" class="form-control input-sm"></select>
                        </div>
                        <div class="col-xs-3">
                            <select id="cbocategoria" class="form-control input-sm"></select>
                        </div>
                        <div class="col-xs-3">
                            <select id="cbomarca" class="form-control input-sm"></select>
                        </div>
                        <div class="col-xs-3">
                        
                            
               <button type="button" class="btn btn-primary btn-sm" id="btncesta">Ver cesta</button>
                                
                        
                        
                        
                        </div>
                    </div>
                    <p>
                        <div class="box box-success">
                            <div class="box-body">
                                <div id="listado">
                                    
                                </div>
                            </div>
                        </div>
                    </p>
                </section>
            </div>
        </div><!-- ./wrapper -->
	<?php
	    include 'scripts.vista.php';
	?>
	
	<!--JS-->
	<script src="js/cargar-combos.js" type="text/javascript"></script>
        <script src="js/articuloCliente.js" type="text/javascript"></script>

    </body>
</html>