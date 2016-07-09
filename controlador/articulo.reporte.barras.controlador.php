<?php
require_once '../negocio/Articulo.clase.php';
$objArticulo = new Articulo();
$resultado = $objArticulo->articuloVenta();

//echo '<pre>';
//print_r($resultado);
//echo '</pre>';

$datosBarras ="['Articulos', 'Cantidad Vendida', 'Importe Vendido']";

for ($i=0; $i<count($resultado); $i++){
    $datosBarras .= ",['". $resultado[$i]["nombre"] ."', '". $resultado[$i]["cantidad"] ."', '". $resultado[$i]["importe"] ."']";
}

?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          <?php
          echo $datosBarras;
          ?>
        ]);

        var options = {
          width: 900,
          chart: {
            title: 'Nearby galaxies',
            subtitle: 'distance on the left, brightness on the right'
          },
          series: {
            0: { axis: 'distance' }, // Bind series 0 to an axis named 'distance'.
            1: { axis: 'brightness' } // Bind series 1 to an axis named 'brightness'.
          },
          axes: {
            y: {
              distance: {label: 'Cantidad vendido'}, // Left y-axis.
              brightness: {side: 'right', label: 'Importe Vendido'} // Right y-axis.
            }
          }
        };

      var chart = new google.charts.Bar(document.getElementById('dual_y_div'));
      chart.draw(data, options);
    };
    </script>
  </head>
  <body>
    <div id="dual_y_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>
