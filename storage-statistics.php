<?php
session_start();
if (isset($_SESSION['USER']) != "Owner") {
    header('Location: index.php');
    exit();
}
?>
<?php
include "database/DBStorage.php";
include "database/DBProducts.php";
include "database/DBUser.php";
$msg = "";
$dbStorage = new DBStorage();
$dbProducts = new DBProducts();
$dbUser=new DBUser();
$storageRes=$dbStorage->getStorageByUserId($_SESSION['userId']);
$dataPoints = array();
foreach($storageRes as $row){
    $result=($row['availablecapacity']*100)/$row['totalcapacity'];
    array_push($dataPoints, array("y"=> $result, "label"=> $row['name']));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Owner Panel</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</head>
<body style="font-family: serif;">
<?php include "includes/owner-navbar.php";?>
<div class="container" style="min-height: 400px;">
    <br/><br>
    <div id="chartContainer"></div>
</div>
<br/><br><br><br>
<?php include "includes/footer.php" ?>
</body>
<script>
    window.onload = function() {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "dark1", // "light1", "light2", "dark1", "dark2"
            title:{
                text: "Your Storage Statistics Followed By Available Capacity"
            },
            axisY: {
                title: "Available Capacity",
                prefix: "",
                suffix:  ""
            },
            data: [{
                type: "bar",
                yValueFormatString: "Available #,##0",
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelFontWeight: "bolder",
                indexLabelFontColor: "white",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    }
</script>
</html>
