<?php
require_once '../negocio/Articulo.clase.php';
$objArticulo = new Articulo();
$resultado = $objArticulo->articulosPorLinea();

//echo '<pre>';
//print_r($resultado);
//echo '</pre>';


$datosGrafico = "['Linea', 'Cantidad de articulos por dia']";

for ($i=0; $i<count($resultado);$i++){
    $datosGrafico .= ",['". $resultado[$i]["linea"] ."', ".$resultado[$i]["cantidad"]."]";
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
