<?php
    include "database/DBStorage.php";
    include "database/DBProducts.php";
    $msg = "";
    $dbStorage = new DBStorage();
    $dbProducts = new DBProducts();
    $productRes=$dbProducts->getStorageProduct(1);
    $dataPoints = array();
    foreach ($productRes as $pro) {
        $result=($pro['availablecapacity']*100)/2000;
        array_push($dataPoints, array('label'=> $pro['product'], 'y'=> $result));
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <script>
        window.onload = function() {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "Usage Share of Desktop Browsers"
                },
                subtitles: [{
                    text: "November 2017"
                }],
                data: [{
                    type: "pie",
                    yValueFormatString: "#,##0.00\"%\"",
                    indexLabel: "{label} ({y})",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>