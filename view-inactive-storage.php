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
$dbStorage = new DBStorage();
$storageRes=$dbStorage->getInactiveStorageByUserId($_SESSION['userId']);
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'active') {
    $id = $_GET['id'];
    $dbStorage->makeActiveStorage($id);
    $storageRes=$dbStorage->getInactiveStorageByUserId($_SESSION['userId']);
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
            <th>Status</th>
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
            <td>In-Active</td>
	        <td>
                <?php echo "<a class='btn btn-danger' href='view-inactive-storage.php?action=active&id=" . $values['id'] . "'><i class='glyphicon glyphicon-save'></i>Make Active</a>"; ?>
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
