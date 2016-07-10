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
                <section class="content-header">
                    <h1 class="text-bold text-black" style="font-size: 20px;">Mantenimiento de personal</h1>
                </section>

                <section class="content">
		    <!-- INICIO del formulario modal -->
		    <small>
		    <form id="frmgrabar">
			<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titulomodal">Título de la ventana</h4>
			      </div>
			      <div class="modal-body">
				  <input type="hidden" name="txttipooperacion" id="txttipooperacion" class="form-control">
                                  <p>DNI <font color = "red">*</font>
				  	<input type="text" name="txtdni" id="txtdni" class="form-control input-sm" placeholder="" required=""><p>          
                                  <p>Apellido Paterno <font color = "red">*</font>
				  	<input type="text" name="txtapellidopaterno" id="txtapellidopaterno" class="form-control input-sm" placeholder="" required=""><p>          
				  <p>Apellido Materno <font color = "red">*</font>
				  	<input type="text" name="txtapellidomaterno" id="txtapellidomaterno" class="form-control input-sm" placeholder="" required=""><p>          
				  <p>Nombre <font color = "red">*</font>
				  	<input type="text" name="txtnombre" id="txtnombre" class="form-control input-sm" placeholder="" required=""><p>          
				  <p>Direccion <font color = "red">*</font>
				  	<input type="text" name="txtdireccion" id="txtdireccion" class="form-control input-sm" placeholder="" required=""><p>          
				  <p>Telefono Fijo <font color = "red">*</font>
				  	<input type="text" name="txtfijo" id="txtfijo" class="form-control input-sm" placeholder="" required=""><p>          
				  <p>Celular 1 <font color = "red">*</font>
				  	<input type="text" name="txtmovil1" id="txtmovil1" class="form-control input-sm" placeholder="" required=""><p>          
				  <p>Celular 2 <font color = "red">*</font>
				  	<input type="text" name="txtmovil2" id="txtmovil2" class="form-control input-sm" placeholder="" required=""><p>          
				  <p>Email <font color = "red">*</font>
				  	<input type="email" name="txtcorreo" id="txtcorreo" class="form-control input-sm" placeholder="" required=""><p>                    
				  <p>
				      Area <font color = "red">*</font>
				      <select class="form-control input-sm" name="cboareamodal" id="cboareamodal" required="" >

				      </select>
				  </p>
				  <p>
				      Cargo <font color = "red">*</font>
				      <select class="form-control input-sm" name="cbocargomodal" id="cbocargomodal" required="" >

				      </select>
				  </p>
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
		    <!-- FIN del formulario modal -->

                    <div class="row">
                        <div class="col-xs-3">
                            <select id="cboarea" class="form-control input-sm"></select>
                        </div>
                        <div class="col-xs-3">
                            <select id="cbocargo" class="form-control input-sm"></select>
                        </div>
                        <div class="col-xs-3">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal" id="btnagregar"><i class="fa fa-copy"></i> Agregar nuevo personal</button>
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
        <script src="js/personal.js" type="text/javascript"></script>

    </body>
</html>