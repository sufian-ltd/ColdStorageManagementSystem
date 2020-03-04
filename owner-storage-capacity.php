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
$dbStorage = new DBStorage();
$dbProducts = new DBProducts();
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'viewStorageCapacity') {
    $storageid = $_GET['storageid'];
    $storageRes=$dbStorage->getStorageById($storageid);
    $storageProductRes=$dbProducts->getStorageProduct($storageid);
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
<body style="font-family: serif;">
<?php include "includes/owner-navbar.php";?>
<div class="container" style="min-height: 400px;">
    <br/><br/>
    <a style="font-family: serif;background-color: #002636;color: white" class="btn container">The requested Storage Information</a>
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
        </tr>
<!--        --><?php //foreach ($storageRes as $values) { ?>
	    <tr>
	        <td><?php echo $storageRes['id'] ?></td>
	        <td><?php echo $storageRes['name'] ?></td>
	        <td><?php echo $storageRes['type'] ?></td>
	        <td><?php echo $storageRes['totalcapacity'] ?></td>
	        <td><?php echo $storageRes['availablecapacity'] ?></td>
            <td><?php echo $storageRes['division'] ?></td>
            <td><?php echo $storageRes['district'] ?></td>
            <td><?php echo $storageRes['thana'] ?></td>
            <td><?php echo $storageRes['location'] ?></td>
	    </tr>
<!--		--><?php //} ?>
    </table>
    <br/>
    <a style="font-family: serif;background-color: #002636;color: white" class="btn container">The requested Storage Products Information</a>
    <table class="table">
        <tr align="center">
            <th>ID</th>
            <th>Storage ID</th>
            <th>Product Type</th>
            <th>Total Capacity</th>
            <th>Available Capacity</th>
            <th>Price(1day/1ton)</th>
        </tr>
        <?php foreach ($storageProductRes as $values) { ?>
            <tr>
                <td><?php echo $values['id'] ?></td>
                <td><?php echo $values['storageid'] ?></td>
                <td><?php echo $values['product'] ?></td>
                <td><?php echo $values['totalcapacity'] ?></td>
                <td><?php echo $values['availablecapacity'] ?></td>
                <td><?php echo $values['price'] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
<br/>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>
