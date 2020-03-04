<?php
session_start();
if (isset($_SESSION['USER']) != "Farmer") {
    header('Location: index.php');
    exit();
}
?>
<?php
include "database/DBProducts.php";
include "database/DBStorage.php";
include "database/DBRequest.php";

$dbStorage = new DBStorage();
$dbProducts = new DBProducts();
$dbRequest=new DBRequest();
$msg="";
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'searchproduct') {
    $id = $_GET['storageid'];
    $storageProductRes=$dbProducts->getStorageProduct($id);
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
<?php include "includes/farmer-navbar.php";?>
    <div class="container" align="center" style="min-height: 450px;">
        <br/>
        <?php
        if ($msg != "") {
            echo '<div style="width: 400px;" class="alert alert-danger">' . $msg . '</div>';
        }
        ?>
        <br/>
        <table class="table">
            <tr align="center">
                <th>Product ID</th>
                <th>Storage ID</th>
                <th>Product Name</th>
                <th>Total Capacity</th>
                <th>Available Capacity</th>
                <th>Price 1day/1ton</th>
                <th>Action</th>
            </tr>
            <?php foreach ($storageProductRes as $values) { ?>
            <tr>
                <td><?php echo $values['id'] ?></td>
                <td><?php echo $values['storageid'] ?></td>
                <td><?php echo $values['product'] ?></td>
                <td><?php echo $values['totalcapacity'] ?></td>
                <td><?php echo $values['availablecapacity'] ?></td>
                <td><?php echo $values['price'] ?></td>
                <td>
                    <?php echo "<a class='btn btn-primary' href='farmer-request-storage.php?action=farmerRequestStorage&id=" . $values['id'] . "&storageid=" . $values['storageid'] . "'><i class='glyphicon glyphicon-fire'></i> Send Request</a>"; ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <br><br>
<?php include "includes/footer.php" ?>
</body>
</html>