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
$msg = "";
$dbStorage = new DBStorage();
$storageRes=$dbStorage->getStorageByUserId($_SESSION['userId']);
$dbProducts = new DBProducts();
$dbStorageOffer = new DBStorageOffer();
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    $dbStorage->makeInActiveStorage($id);
    // $dbProducts->deleteByStorageId($id);
    // $dbStorageOffer->deleteStorageOfferByStorageid($id);
    $storageRes=$dbStorage->getStorageByUserId($_SESSION['userId']);
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
<div class="container-fluid" style="min-height: 400px;">
    <br/><br/>
    <a href="add-storage.php" style="font-family: serif;" class="btn btn-danger"><i class='glyphicon glyphicon-plus'></i> Add New Storage</a>
    <br/><br/>
    <table class="table">
        <tr align="center">
            <th>ID</th>
            <th>Storage Name</th>
            <th>Type</th>
            <th>Total Capacity</th>
            <th>Available Capacity</th>
            <th>Division</th>
            <th>District</th>
            <th>Thana</th>
            <th>Location</th>
            <th>Status</th>
            <th>Action</th>
            <th>Action</th>
            <th>Action</th>
            <th>Action</th>
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
            <td>Active</td>
            <?php
                $lat=$values['latitude'];
                $lon=$values['longitude'];
                $mapurl="https://maps.google.com/maps?q=".$lat.",".$lon;
            ?>
            <td>
                <?php echo "<a class='btn btn-primary' href='manage-space.php?action=manage&id=" . $values['id'] . "'><i class='glyphicon glyphicon-edit'></i> Manage Capacity</a>"; ?>
            </td>
            <td>
                <a href="<?php echo $mapurl;?>" class="btn btn-danger"><i class='glyphicon glyphicon-map-marker'></i> View Location</a>
            </td>
            <td>
                <?php echo "<a class='btn btn-success' href='edit-storage.php?action=edit&id=" . $values['id'] . "'><i class='glyphicon glyphicon-edit'></i> Edit Storage</a>"; ?>
            </td>
	        <td>
                <?php echo "<a class='btn btn-primary' href='add-storage-offer.php?action=offer&id=" . $values['id'] . "'><i class='glyphicon glyphicon-stats'></i> Package Offer</a>"; ?>
	        </td>
	        <td>
                <?php echo "<a class='btn btn-danger' href='owner-storage.php?action=delete&id=" . $values['id'] . "'><i class='glyphicon glyphicon-duplicate'></i> In-Active</a>"; ?>
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
<script>
    function showPosition() {
        navigator.geolocation.getCurrentPosition(showMap);
    }

    function showMap(position) {
        // Get location data
        var latlong = position.coords.latitude + "," + position.coords.longitude;

        // Set Google map source url
        var mapLink = "https://maps.googleapis.com/maps/api/staticmap?center="+latlong+"&zoom=16&size=400x300&output=embed";

        // Create and insert Google map
        document.getElementById("embedMap").innerHTML = "<img alt='Map Holder' src='"+ mapLink +"'>";
    }
</script>