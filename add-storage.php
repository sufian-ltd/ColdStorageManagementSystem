<?php
session_start();
if (isset($_SESSION['USER']) != "Owner") {
    header('Location: index.php');
    exit();
}
?>
<?php
include "database/DBStorage.php";
$msg = "";
$dbStorage=new DBStorage();
?>
<?php
if (isset($_POST['action'])=="cancel") {
    header('Location: owner-storage.php');
    exit();
}
?>
<?php
    if (isset($_POST['add'])) {
        $userId=$_SESSION['userId'];
        $name = $_POST['name'];
        $type = $_POST['type'];
        $totalcapacity = $_POST['totalcapacity'];
        $availablecapacity = $totalcapacity;
        $division=$_POST['division'];
        $district=$_POST['district'];
        $thana=$_POST['thana'];
        $location=$_POST['location'];
        $latitude=$_POST['latitude'];
        $longitude=$_POST['longitude'];
        echo $latitude;
        echo $longitude;
        if($dbStorage->addStorage($userId,$name, $type,$totalcapacity, $availablecapacity,
            $division,$district,$thana,$location,$latitude,$longitude)){
            header('Location: owner-storage.php');
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body style="font-family: serif;color: white; background-color: #002636;">
<?php //include "includes/owner-navbar.php";?>
    <br/>
    <div class="container" align="center" style="min-height: 450px;">
        <h2>Cold Storage Management System</h2>
        <hr/>
        <form action="add-storage.php" method="post" style="width: 400px">
            <h3><i class='glyphicon glyphicon-plus'></i> Add New Storage</h3>
            <br/>
            <input type="hidden" name="latitude" id="latId">
            <input type="hidden" name="longitude" id="lonId">
            <div class="form-group">
                <input type="text" class="form-control" required="true" name="name" id="name" placeholder="Storage Name :"/>
            </div>
            <div class="form-group">
                <select class="form-control" name="type" id="type">
                    <option value="AC">AC</option>
                    <option value="Non-AC">Non-AC</option>
                </select>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" required="true" name="totalcapacity" id="totalcapacity" placeholder="Total Capacity :"/>
            </div>
            <div class="form-group">
                <select class="form-control" required="true" name="division" id="division">
                    <option value="none">Select Division</option>  
                    <option value="Dhaka">Dhaka</option>
                    <option value="Chittagong">Chittagong</option>*
                    <option value="Sylhet">Sylhet</option>
                    <option value="Khulna">Khulna</option>
                    <option value="Barisal">Barisal</option>
                    <option value="Rajshahi">Rajshahi</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" required="true" name="district" id="district" placeholder="District :"/>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" required="true" name="thana" id="thana" placeholder="Thana :"/>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" required="true" name="location" id="location" placeholder="Location : "/>
            </div>
            <div class="form-group">
                <a href="owner-storage.php?action=cancel" style="width: 120px;margin-right: 16px;" class="btn btn-danger"><i class='glyphicon glyphicon-step-backward'></i> Cancel</a>
                <a style="width: 120px;margin-right: 16px;" class="btn btn-success" onclick="getLocation()"><i class='glyphicon glyphicon-map-marker'></i> Save Position</a>
                <button style="width: 120px" type="submit" class="btn btn-primary" name="add"><i class='glyphicon glyphicon-fast-forward'></i> Save</button>
            </div>
        </form>
    </div>
<?php //include "includes/footer.php" ?>
</body>
</html>
<script>

    var latId = document.getElementById("latId");
    var lonId = document.getElementById("lonId");

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        }
    }

    function showPosition(position) {
        var lat=position.coords.latitude;
        var lon=position.coords.longitude;

        latId.value=lat;
        lonId.value=lon;
    }

</script>