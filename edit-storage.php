<?php
session_start();
if (isset($_SESSION['USER']) != "Owner") {
    header('Location: index.php');
    exit();
}
?>
<?php
include "database/DBStorageOffer.php";
include "database/DBStorage.php";
$dbStorage = new DBStorage();
$msg="";
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = $_GET['id'];
    $result=$dbStorage->getStorageById($id);
}
?>

<?php
if (isset($_POST['update'])) {
    $total=0;
    $available=0;
    $id=$_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $totalcapacity = $_POST['totalcapacity'];
    $district=$_POST['district'];
    $thana=$_POST['thana'];
    $location=$_POST['location'];
    $totalcapacitybefore=$_POST['totalcapacitybefore'];
    $availablecapacitybefore=$_POST['availablecapacitybefore'];
    $latitude=$_POST['latitude'];
    $longitude=$_POST['longitude'];
    if($totalcapacitybefore<$totalcapacity){
        $total=$totalcapacity;
        $available=$availablecapacitybefore+($totalcapacity-$totalcapacitybefore);
        $msg="";
    }
    else if($totalcapacity<=$totalcapacitybefore){
        if(($totalcapacitybefore-$totalcapacity)<=$availablecapacitybefore){
            $total=$totalcapacity;
            $available=$availablecapacitybefore-($totalcapacitybefore-$totalcapacity);
            $msg="";
        }
        else{
            $msg="Your storage available capacity can not be decreased...!!!!!!!";
            $result=$dbStorage->getStorageById($id);
        }
    }
    if($msg==""){
        if($dbStorage->editStorage($id,$name, $type,$total, $available,$district,$thana,
            $location,$latitude,$longitude)){
            header('Location: owner-storage.php');
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Owner Panel</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body style="font-family: serif;color: white; background-color: #002636;">
<div class="container" align="center" style="min-height: 450px;">
    <br/>
    <h2>Cold Storage Management System</h2>
    <hr/>
    <?php
    if ($msg != "") {
        echo '<div style="width: 400px;" class="alert alert-danger">' . $msg . '</div>';
    }
    ?>
        <div align="center" class="">
            <form action="edit-storage.php" method="post" style="width: 400px">
            <h3><i class='glyphicon glyphicon-book'></i> Edit Your Storage</h3>
            <input type="hidden" name="id" value="<?php echo $result['id'] ?>" />
            <input type="hidden" name="latitude" id="latId" value="<?php echo $result['latitude']; ?>">
            <input type="hidden" name="longitude" id="lonId" value="<?php echo $result['longitude']; ?>">
            <input type="hidden" name="totalcapacitybefore" value="<?php echo $result['totalcapacity'] ?>" />
            <input type="hidden" name="availablecapacitybefore" value="<?php echo $result['availablecapacity'] ?>"/>
            <br/>
            <div class="form-group">
                <input type="text" class="form-control" required="true" name="name" id="name" value="<?php echo $result['name'] ?>" />
            </div>
            <div class="form-group">
                <select class="form-control" name="type" id="type">
                    <option value="AC">AC</option>
                    <option value="Non-AC">Non-AC</option>
                </select>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" required="true" name="totalcapacity" id="totalcapacity" value="<?php echo $result['totalcapacity']; ?>" placeholder="Total Capacity : "/>
            </div>
            <div class="form-group">
                <input type="text" readonly="true" class="form-control" required="true" id="availablecapacity" value="Available Capacity : <?php echo $result['availablecapacity']; ?>"/>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" required="true" name="district" id="district" value="<?php echo $result['district']; ?>" placeholder="District : "/>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" required="true" name="thana" id="thana" placeholder="Thana :" value="<?php echo $result['thana']; ?>"/>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" required="true" name="location" id="location" placeholder="Location : " value="<?php echo $result['location']; ?>"/>
            </div>
                <div class="form-group">
                    <a href="owner-storage.php?action=cancel" style="width: 120px;margin-right: 16px;" class="btn btn-danger"><i class='glyphicon glyphicon-step-backward'></i> Cancel</a>
                    <a style="width: 120px;margin-right: 16px;" class="btn btn-success" onclick="getLocation()"><i class='glyphicon glyphicon-map-marker'></i> Save Position</a>
                    <button style="width: 120px" type="submit" class="btn btn-primary" name="update"><i class='glyphicon glyphicon-fast-forward'></i> Save Changes</button>
                </div>
            </form>
        </div>
    <br>
</div>
<br><br>
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