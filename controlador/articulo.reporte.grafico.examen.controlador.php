<?php

try {
    require_once '../negocio/Articulo.clase.php';
    $objArticulo = new Articulo();
    $resultado = $objArticulo->reporte();

//    echo '<pre>';
//    print_r($resultado);
//    echo '</pre>';
    
    $htmlDatosReporte = '<table border="0" cellpadding="3" cellspacing="0">';
    
    $htmlDatosReporte .= '<thead>';

        $htmlDatosReporte .= '<tr>';
            $htmlDatosReporte .= '<td colspan="6" class="titulo-reporte">REPORTE</td>';
        $htmlDatosReporte .= '</tr>';

        $htmlDatosReporte .= '<tr>';
            $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">Pais</td>';
            $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">Enero</td>';
            $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">Febrero</td>';
            $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">Marzo</td>';
            $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">Abril</td>';
            $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">Mayo</td>';
            $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">Junio</td>';
            $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">Julio</td>';
            $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">Agosto</td>';
            $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">Setiembre</td>';
            $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">Octubre</td>';
            $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">Novimebre</td>';
            $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">Diciembre</td>';
            $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">Total</td>';
        $htmlDatosReporte .= '</tr>';
    $htmlDatosReporte .= '</thead>';


    $htmlDatosReporte .= '<tbody>';
        //aqui se imprime el detalle del reporte (los datos)
        for ($i = 0; $i < count($resultado); $i++) {
            $htmlDatosReporte .= '<tr>';
                $htmlDatosReporte .= '<td>'.$resultado[$i]["pais"].'</td>';
                $htmlDatosReporte .= '<td>'.$resultado[$i]["enero"].'</td>';
                $htmlDatosReporte .= '<td>'.$resultado[$i]["febrero"].'</td>';
                $htmlDatosReporte .= '<td>'.$resultado[$i]["marzo"].'</td>';
                $htmlDatosReporte .= '<td>'.$resultado[$i]["abril"].'</td>';
                $htmlDatosReporte .= '<td>'.$resultado[$i]["mayo"].'</td>';
                $htmlDatosReporte .= '<td>'.$resultado[$i]["junio"].'</td>';
                $htmlDatosReporte .= '<td>'.$resultado[$i]["julio"].'</td>';
                $htmlDatosReporte .= '<td>'.$resultado[$i]["agosto"].'</td>';
                $htmlDatosReporte .= '<td>'.$resultado[$i]["setiembre"].'</td>';
                $htmlDatosReporte .= '<td>'.$resultado[$i]["octubre"].'</td>';
                $htmlDatosReporte .= '<td>'.$resultado[$i]["nombriembre"].'</td>';
                $htmlDatosReporte .= '<td>'.$resultado[$i]["diciembre"].'</td>';
                $htmlDatosReporte .= '<td>'.$resultado[$i]["total"].'</td>';
                
            $htmlDatosReporte .= '</tr>';
        }
    $htmlDatosReporte .= '</tbody>';
        
    
    $htmlDatosReporte .= '</table>';
    
    $htmlDatosReporte .='<iframe frameborder = "0" scrolling="no" style="width: 900px; height: 500px;" src="articulo.reporte.grafico.controlador.php"></iframe>';
    
    $htmlReporte = Funciones::generarHTMLReporte( $htmlDatosReporte );
    
    echo $htmlReporte;
    
    
    
} catch (Exception $exc) {
    Funciones::mensaje($exc->getMessage(), "e");
}





$datosGrafico = "['Linea', 'Cantidad de articulos por dia']";

for ($i=0; $i<count($resultado);$i++){
    $datosGrafico .= ",['". $resultado[$i]["pais"] ."', ".$resultado[$i]["total"]."]";
}


?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          <?php
          echo $datosGrafico;
          ?>
        ]);

        var options = {
          title: 'Cantidad de articulos por linea',
          is3D: true
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>
