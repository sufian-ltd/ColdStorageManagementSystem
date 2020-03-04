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
include "database/DBStorageOffer.php";
include "database/DBRequest.php";
$msg = "";
$dbStorage = new DBStorage();
$dbProducts = new DBProducts();
$dbStorageOffer = new DBStorageOffer();
$dbRequest=new DBRequest();
$requestRes=$dbRequest->getStorageRequestByOwnerId($_SESSION['userId']);
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'rejectRequest') {
    $id = $_GET['id'];
    $dbRequest->deleteRequest($id);
    $requestRes=$dbRequest->getStorageRequestByOwnerId($_SESSION['userId']);
}
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'acceptRequest') {
    $id = $_GET['id'];
    $dbRequest->acceptRequest($id);
    $requestRes=$dbRequest->getStorageRequestByOwnerId($_SESSION['userId']);
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
<body style="font-family: serif;">
<?php include "includes/owner-navbar.php";?>
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
            <th>Status</th>
            <th>Action</th>
            <th>Action</th>
            <th>Action</th>
            <th>Action</th>
        </tr>
        <?php foreach ($requestRes as $values) { ?>
	    <tr>
            <td><?php echo $values['ownerId'] ?></td>
            <td><?php echo $values['storageid'] ?></td>
            <td><?php echo $values['storagename'] ?></td>
            <td><?php echo $values['product'] ?></td>
            <td><?php echo $values['farmerid'] ?></td>
            <td><?php echo $values['capacity'] ?></td>
            <td><?php echo $values['status'] ?></td>
            <td>
                <?php echo "<a class='btn btn-success' href='owner-view-farmer.php?action=viewFarmer&farmerid=" . $values['farmerid'] . "&storageid=" . $values['storageid'] . "'><i class='glyphicon glyphicon-save'></i>View Farmer</a>"; ?>
            </td>
            <td>
                <?php echo "<a class='btn btn-success' href='owner-storage-capacity.php?action=viewStorageCapacity&ownerId=" . $values['ownerId'] . "&storageid=" . $values['storageid'] . "'><i class='glyphicon glyphicon-save'></i>Storage Capacity</a>"; ?>
            </td>
            <td>
                <?php echo "<a class='btn btn-success' href='storage-request.php?action=rejectRequest&id=" . $values['id'] . "&ownerId=" . $values['ownerId'] . "&farmerid=" . $values['farmerid'] . "&storageid=" . $values['storageid'] . "'><i class='glyphicon glyphicon-save'></i>Reject Request</a>"; ?>
            </td>
            <td>
                <?php echo "<a class='btn btn-primary' href='storage-request.php?action=acceptRequest&id=" . $values['id'] . "&ownerId=" . $values['ownerId'] . "&farmerid=" . $values['farmerid'] . "&storageid=" . $values['storageid'] . "'><i class='glyphicon glyphicon-save'></i>Accept Request</a>"; ?>
            </td>
	    </tr>
        <?php } ?>
    </table>
</div>
<br/>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>
