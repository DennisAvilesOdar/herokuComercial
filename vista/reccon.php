<?php
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
                    <h1 class="text-bold text-black" style="font-size: 20px;">Recuperar Contraseña</h1>
                </section>
                <section class="content">
		    <!-- INICIO del formulario modal -->
                    <small>
		    <form id="frmpaso1">
			<div class="modal fade" id="myPaso1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
                              <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="titulomodal1">Título de la ventana</h4>
			      </div>
			      <div class="modal-body">
                                <p> Correo electronico <font color = "red">*</font>
                                    <div class="form-group has-feedback">
                                        <input type="email" name="txtcorreomodal" id="txtcorreomodal" class="form-control input-sm" placeholder="" required="">
                                        <span class="glyphicon glyphicon-inbox form-control-feedback"></span>
                                    </div>
                                </p>
				<p><font color = "red">* Campos obligatorios</font></p>
			      </div>
			      <div class="modal-footer">
                                <button type="submit" class="btn btn-danger" aria-hidden="true"><i class="fa fa-inbox"></i> Siguiente </button>
				<button type="button" class="btn btn-default" data-dismiss="modal" id="btncerrar1"><i class="fa fa-close"></i> Cancelar</button>
			      </div>
			    </div>
			  </div>
			</div>
		    </form>
                    </small>
                    
                    <small>
		    <form id="frmpaso2">
			<div class="modal fade" id="myPaso2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titulomodal2">Título de la ventana</h4>
			      </div>
			      <div class="modal-body">
				  <div class="row">
				    <div class="col-xs-4">
                                        <p> Codigo <font color = "red">*</font>
                                            <div class="form-group has-feedback">
                                                <input type="text" name="txtcodigoseguridad" id="txtcodigoseguridad" class="form-control input-sm" placeholder="" required="">
                                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                            </div>
					</p>
				    </div>
				  </div>
				  <p><font color = "red">* Campos obligatorios</font></p>
			      </div>
			      <div class="modal-footer">
				  <button type="submit" class="btn btn-danger" aria-hidden="true"><i class="fa fa-lock"></i> Comprobar </button>
				  <button type="button" class="btn btn-default" data-dismiss="modal" id="btncerrar2"><i class="fa fa-close"></i> Cancelar </button>
			      </div>
			    </div>
			  </div>
			</div>
		    </form>
                    </small>
                    
                    <small>
		    <form id="frmpaso3">
			<div class="modal fade" id="myPaso3" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titulomodal3">Título de la ventana</h4>
			      </div>
			      <div class="modal-body">
                                <p> Nueva Contraseña <font color = "red">*</font>
                                    <div class="form-group has-feedback">
                                        <input type="password" name="txtnuevopass" id="txtnuevopass" class="form-control input-sm" placeholder="" required="">
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                    </div>
                                </p>
                                <p> Confirmar Contraseña <font color = "red">*</font>
                                    <div class="form-group has-feedback">
                                        <input type="password" name="txtconfirmarpass" id="txtconfirmarpass" class="form-control input-sm" placeholder="" required="">
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                    </div>
                                </p>
				  <p><font color = "red">* Campos obligatorios</font></p>
			      </div>
			      <div class="modal-footer">
				  <button type="submit" class="btn btn-danger" aria-hidden="true"><i class="fa fa-lock"></i> Restablecer </button>
				  <button type="button" class="btn btn-default" data-dismiss="modal" id="btncerrar3"><i class="fa fa-close"></i> Cancelar </button>
			      </div>
			    </div>
			  </div>
			</div>
		    </form>
                    </small>
		    <!-- FIN del formulario modal -->
                    <input type="hidden" data-toggle="modal" data-target="#myPaso1" id="btnpaso1">
                    <input type="hidden" data-toggle="modal" data-target="#myPaso2" id="btnpaso2">
                    <input type="hidden" data-toggle="modal" data-target="#myPaso3" id="btnpaso3">
                </section>
            </div>
        </div><!-- ./wrapper -->
	<?php
	    include 'scripts.vista.php';
	?>
	
	<!--JS-->
        <script src="js/recuperar.pass.js" type="text/javascript"></script>
    </body>
</html>