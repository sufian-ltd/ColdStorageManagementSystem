<?php
session_start();
if (isset($_SESSION['USER']) != "Owner") {
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
if (isset($_GET['action']) && $_GET['action'] == 'acceptRequest') {
    $id = $_GET['id'];
    $requestRes=$dbRequest->getRequestById($id);
    $productRes=$dbProducts->getProductById($requestRes['productid']);
    $storageProductRes=$dbProducts->getStorageProduct($requestRes['storageid']);
}
?>
<?php
    if( isset($_POST['add']) ) {
        $requestid = $_POST['id'];
        $requestRes=$dbRequest->getRequestById($requestid);
        $productRes=$dbProducts->getProductById($requestRes['productid']);
        $msg="";
        if($productRes['availablecapacity']<$requestRes['capacity'])
            $msg="Storage Capacity Limit Exceed...!!!Please Try Again.....!!!";
        if($msg==""){
            $dbProducts->updateAvailableCapacity($productRes['id'],$productRes['availablecapacity']-$requestRes['capacity']);
            $date=date('y-m-d');
            $dbRequest->acceptRequest($requestid,$date);
            $msg="Successfully Added in Your Storage.....!!!!!!!!!";
        }
        $storageProductRes=$dbProducts->getStorageProduct($requestRes['storageid']);
}
?>
<?php
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $storageid = $_POST['storageid'];
    $product = $_POST['product'];
    $capacity = $_POST['capacity'];
    $capacitybefore=$_POST['capacitybefore'];
    $storageRes=$dbStorage->getStorageById($storageid);
    $msg="";
    if($capacitybefore<$capacity){
        if($storageRes['availablecapacity']<($capacity-$capacitybefore))
            $msg="Storage Capacity Limit Exceed...!!!Please Try Again.....!!!";
        else {
            $dbProducts->updateProducts($id, $product, $capacity);
            $dbStorage->updateStorageCapacity($storageid,$storageRes['availablecapacity']-($capacity-$capacitybefore));
            $msg="Update successful(storage available capacity decreased....!!!)";
        }
    }
    else if($capacitybefore>$capacity){
            $dbProducts->updateProducts($id, $product, $capacity,$price);
            $dbStorage->updateStorageCapacity($storageid,$storageRes['availablecapacity']+($capacitybefore-$capacity));
            $msg="Update successful(storage available capacity increased....!!!)";
    }
    else if($capacitybefore==$capacity){
        $dbProducts->updateProducts($id, $product, $capacity);
        $msg="Update successful(No change in storage available capacity....!!!)";
    }
    $storageProductRes=$dbProducts->getStorageProduct($storageid);
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
    <div class="container" align="center" style="min-height: 450px;">
        <br/>
        <?php
        if ($msg != "") {
            echo '<div style="width: 400px;" class="alert alert-danger">' . $msg . '</div>';
        }
        ?>
        <?php
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            $id = (int)$_GET['id'];
            $storageid=$_GET['storageid'];
            $result = $dbProducts->getProductById($id);
            $storageProductRes=$dbProducts->getStorageProduct($storageid);
            ?>
            <div align="center" class="">
                <form action="manage-capacity.php" method="post" style="width: 400px">
                    <br/>
                    <button style="background: black;color: #ffffff;font-family: serif" class="form-control">Please Fill The Specific
                        Field
                    </button>
                    <br/>
                    <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                    <input type="hidden" name="storageid" value="<?php echo $result['storageid']; ?>">
                    <input type="hidden" name="capacitybefore" value="<?php echo $result['capacity']; ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" name="product" id="name"
                               value="<?php echo $result['product']; ?>" placeholder="Product Type :"/>
                    </div>
                    <div class="form-group">
                        <input type="number" required="true" class="form-control" name="capacity" id="capacity" placeholder="Product Capacity : "
                               value="<?php echo $result['capacity']; ?>"/>
                    </div>

                    <div class="form-group">
                        <button style="width: 400px" type="submit" class="btn btn-success" name="update"><i class="glyphicon glyphicon-save"></i>Save Changes</button>
                    </div>
                </form>
            </div>
        <?php } else{ ?>
        <form action="manage-capacity.php" method="post" style="width: 400px">
        <a class="btn" style="background-color: #000;color: #fff;font-family: serif;width: 400px;">Manage Request For Product In Your Stoarge</a>
            <br><br>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <input type="text" readonly class="form-control" value="Storage Name: <?php echo $requestRes['storagename']; ?>" />
            </div>
            <div class="form-group">
                <input type="text" readonly class="form-control" value="Product Type: <?php echo $requestRes['product']; ?>" />
            </div>
            <div class="form-group">
                <input type="text" readonly class="form-control" value="Total Capacity: <?php echo $productRes['totalcapacity']; ?>" />
            </div>
            <div class="form-group">
                <input type="text" readonly class="form-control"  value="Available Capacity: <?php echo $productRes['availablecapacity']; ?>" />
            </div>
            <div class="form-group">
                <input type="text" readonly class="form-control" value="Needed Capacity: <?php echo $requestRes['capacity']; ?>" />
            </div>
            <div class="form-group">
                <input type="text" readonly class="form-control" value="Total Cost: <?php echo $requestRes['price'];; ?>" />
            </div>
            <div class="form-group">
                <button style="width: 400px" type="submit" class="btn btn-primary" name="add"><i class="glyphicon glyphicon-stats"></i> Yes I confirm</button>
            </div>
        </form>
        <?php }?>
        <table class="table">
            <tr align="center">
                <th>Product ID</th>
                <th>Storage ID</th>
                <th>Product Type</th>
                <th>Total Capacity</th>
                <th>Available Capacity</th>
                <th>Price</th>
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
    <br><br>
<?php include "includes/footer.php" ?>
</body>
</html>