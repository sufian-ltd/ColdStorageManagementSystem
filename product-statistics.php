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
?>
<?php $storageRes=$dbStorage->getStorageByUserId($_SESSION['userId']); ?>
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
<div class="container-fluid" style="min-height: 400px;">
    <br>
    <div class="row">
        <?php foreach ($storageRes as $values) { ?>
            <div class="col-md-4">
                <?php
                $stId=$values['id'];
                $name=$values['name'];
                $loc=$values['location'];
                $productRes=$dbProducts->getStorageProduct($values['id']);
                $dataPoints = array();
                foreach ($productRes as $pro) {
                    $result=($pro['availablecapacity']*100)/2000;
                    array_push($dataPoints, array('label'=> $pro['product'], 'y'=> $result));
                }
                ?>
                <div id="<?php echo $stId; ?>" style="width: 100%;height: 300px;margin-bottom: 40px;"></div>
                <script>
                    var chart = new CanvasJS.Chart("<?php echo $stId; ?>", {
                        animationEnabled: true,
                        title: {
                            text: "<?php echo "Name:".$name." "; echo "  Location:".$loc?>"
                        },
                        //subtitles: [{
                        //    text: "<?php //echo $loc; ?>//"
                        //}],
                        data: [{
                            type: "pie",
                            yValueFormatString: "#,##0.00\"%\"",
                            indexLabel: "{label} ({y})",
                            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                        }]
                    });
                    chart.render();
                </script>
            </div>
        <?php } ?>
    </div>
</div>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>
