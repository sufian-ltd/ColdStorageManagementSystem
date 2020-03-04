<?php
session_start();
if (isset($_SESSION['USER']) != "Farmer") {
    header('Location: index.php');
    exit();
}
?>
<?php
    include "database/DBStorage.php";
    $dbStorage = new DBStorage();
?>
<?php
    $storageRes=$dbStorage->getStorages();
?>
<?php
    if(isset($_POST['search']) ) {
        $division=$_POST['division'];
        $key=$_POST['key'];
        if($division!="none" && $key=="")
            $storageRes = $dbStorage->searchByDivision($division);
        else if($division=="none" && $key!="")
            $storageRes=$dbStorage->searchByKey($key);
        else if($division!="none" && $key!="")
            $storageRes=$dbStorage->searchByKeyAndDivision($division,$key);
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Farmer Panel</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body style="font-family: serif;">
<?php include "includes/farmer-navbar.php";?>    
    <div class="container" align="center" style="min-height: 450px;">   
        <form action="farmer-find-storage.php" method="post" style="width: 400px">
        <br/>
        <br/>
            <div class="form-group">
                <select class="form-control" required="true" name="division" id="division">
                    <option value="none">Select Division</option>  
                    <option value="Dhaka">Dhaka</option>
                    <option value="Chittagong">Chittagong</option>
                    <option value="Sylhet">Sylhet</option>
                    <option value="Khulna">Khulna</option>
                    <option value="Barisal">Barisal</option>
                    <option value="Rajshahi">Rajshahi</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="key" id="key" placeholder="Search......"/>
            </div>
            <div class="form-group">
                <button style="width: 400px" type="submit" class="btn btn-danger" name="search"><i class="glyphicon glyphicon-save"></i>Search</button>
            </div>
        </form>
        <br>
        <table class="table">
            <tr align="center">
                <th>Storage ID</th>
                <th>Storage Name</th>
                <th>Storage Type</th>
                <th>Total Capacity</th>
                <th>Available Capacity</th>
                <th>Division</th>
                <th>District</th>
                <th>Thana</th>
                <th>Lcation</th>
                <th>Action</th>
            </tr>
            <?php foreach ($storageRes as $values) { ?>
            <tr>
                <td><?php echo $values['id'] ?></td>
                <td><?php echo $values['name'] ?></td>
                <td><?php echo $values['type'] ?></td>
                <td><?php echo $values['totalcapacity'] ?></td>
                <td><?php echo $values['availablecapacity'] ?></td>
                <td><?php echo $values['division'] ?></td>
                <td><?php echo $values['district'] ?></td>
                <td><?php echo $values['thana'] ?></td>
                <td><?php echo $values['location'] ?></td>
                <td>
                    <?php echo "<a class='btn btn-danger' href='farmer-view-storage-offer.php?action=viewOffer&storageid=" . $values['id'] . "'><i class='glyphicon glyphicon-save'></i>View Offer</a>"; ?>
                </td>
                <td>
                    <?php echo "<a class='btn btn-danger' href='farmer-request-storage.php?action=farmerRequestStorage&storageid=" . $values['id'] . "'><i class='glyphicon glyphicon-save'></i>Send Request</a>"; ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <br><br>
<?php include "includes/footer.php" ?>
</body>
</html>