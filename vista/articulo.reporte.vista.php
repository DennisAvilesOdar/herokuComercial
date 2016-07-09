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
                    <h1 class="text-bold text-black" style="font-size: 20px;">Reporte de artículos</h1>
                </section>

                <section class="content">
                    <form action="../controlador/articulo.reporte.controlador.php" method="post" target="_blank">
                        <div class="row">
                            <div class="col-xs-3">
                                <select id="cbolinea" name="cbolinea" class="form-control input-sm"></select>
                            </div>
                            <div class="col-xs-3">
                                <select id="cbocategoria" name="cbocategoria" class="form-control input-sm"></select>
                            </div>
                            <div class="col-xs-3">
                                <select id="cbomarca" name="cbomarca" class="form-control input-sm"></select>
                            </div>
                            <div class="col-xs-3">
                                <button type="submit" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal" id="btnagregar"><i class="fa fa-copy"></i> Mostrar reporte</button>
                            </div>
                        </div>
                        
                        <br>
			<div class="row">
                            <div class="col-xs-12 form-inline">
				Formato de salida:&nbsp;
				<div class="radio">
                                    <label>
                                        <input type="radio" name="tipo_reporte" id="tipo_reporte" value="1" checked="" >
                                      HTML
                                    </label>
                                </div>
                                &nbsp;&nbsp;
                                <div class="radio">
                                    <label>
                                      <input type="radio" name="tipo_reporte" id="tipo_reporte" value="2">
                                      PDF
                                    </label>
                                </div>
                                &nbsp;&nbsp;
                                <div class="radio">
                                    <label>
                                      <input type="radio" name="tipo_reporte" id="tipo_reporte" value="3">
                                      Excel
                                    </label>
                                </div>
				
                                
                            </div>
                        </div>
                        
                    </form>
                </section>
            </div>
        </div><!-- ./wrapper -->
	<?php
	    include 'scripts.vista.php';
	?>
	
	<!--JS-->
	<script src="js/cargar-combos.js" type="text/javascript"></script>
        <script src="js/articulo-reporte.js" type="text/javascript"></script>

    </body>
</html>