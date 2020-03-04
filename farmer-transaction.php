<?php
session_start();
if (isset($_SESSION['USER']) != "Farmer") {
    header('Location: index.php');
    exit();
}
?>
<?php
include "database/DBStorage.php";
include "database/DBProducts.php";
include "database/DBStorageOffer.php";
include "database/DBRequest.php";
$msg = "";
$dbStorage = new DBStorage();
$dbProducts = new DBProducts();
$dbStorageOffer = new DBStorageOffer();
$dbRequest=new DBRequest();
$requestRes=$dbRequest->getStorageRequestByFarmerId($_SESSION['userId'],'checkout');
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
<div class="container" style="min-height: 400px;">
    <br/><br/>
    <table class="table">
        <tr align="center">
        	<th>Owner ID</th>
            <th>Storage ID</th>
            <th>Storage Name</th>
            <th>Product Type</th>
            <th>Farmer Id</th>
            <th>Product Weight</th>
        </tr>
        <?php foreach ($requestRes as $values) { ?>
	    <tr>
            <td><?php echo $values['ownerId'] ?></td>
            <td><?php echo $values['storageid'] ?></td>
            <td><?php echo $values['storagename'] ?></td>
            <td><?php echo $values['product'] ?></td>
            <td><?php echo $values['farmerid'] ?></td>
            <td><?php echo $values['capacity'] ?></td>
	    </tr>
        <?php } ?>
    </table>
</div>
<br/>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>
