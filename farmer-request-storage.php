<?php
session_start();
if (isset($_SESSION['USER']) != "Farmer") {
    header('Location: index.php');
    exit();
}
?>
<?php
include "database/DBRequest.php";
include "database/DBStorage.php";
include "database/DBProducts.php";
$dbRequest=new DBRequest();
$dbStorage=new DBStorage();
$dbProduct=new DBProducts();
$msg = "";
?>
<?php
    if(isset($_GET['action']) && $_GET['action'] == 'farmerRequestStorage'){
        $id=$_GET['id'];
        $storageid=$_GET['storageid'];
        $storageRes=$dbStorage->getStorageById($storageid);
        $productRes=$dbProduct->getProductById($id);
    }
?>

<?php
    if (isset($_POST['add'])) {
        $ownerId=$_POST['ownerId'];
        $storageId = $_POST['storageId'];
        $productid = $_POST['productid'];
        $farmerid= $_SESSION['userId'];
        $productRes=$dbProduct->getProductById($productid);
        $storageRes=$dbStorage->getStorageById($storageId);
        $storagename = $storageRes['name'];
        $product = $productRes['product'];
        $capacity=$_POST['capacity'];
        $proTotalCapacity=$productRes['totalcapacity'];
        $proAvailableCapacity=$productRes['availablecapacity'];
        $price=$productRes['price'];
        $date=date('y-m-d');
        $status="pending";
        if($capacity>$proAvailableCapacity){
            $msg="Storage Capacity Limit Exceed...!!!Please Try Again.....!!!";
        }
        else if($dbRequest->addRequest($ownerId,$storageId, $storagename,$productid,$product,
            $farmerid, $capacity,$price,$date,$status)){
            header('Location: farmer-view-pending-request.php');
            exit();
        }
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
        <form action="farmer-request-storage.php" method="post" style="width: 400px">
        <br>
        <a class="btn" style="background-color: #000;color: #fff;font-family: serif;width: 400px;">Please Complete Request Procerss</a>
            <br/>
            <?php
            if ($msg != "") {
                echo '<div style="width: 400px;" class="alert alert-danger">' . $msg . '</div>';
            }
            ?>
            <br/>
            <input type="hidden" name="storageId" value="<?php echo $storageRes['id']?>">
            <input type="hidden" name="ownerId" value="<?php echo $storageRes['userId']?>">
            <input type="hidden" name="productid" value="<?php echo $productRes['id']?>">
            <div class="form-group">
                <input type="text" readonly class="form-control" value="Storage Name: <?php echo $storageRes['name']?>"/>
            </div>
            <div class="form-group">
                <input type="text" readonly class="form-control" value="Product Name: <?php echo $productRes['product']?>"/>
            </div>
            <div class="form-group">
                <input type="text" readonly class="form-control" value="Total Capacity : <?php echo $productRes['totalcapacity']?> Ton"/>
            </div>
            <div class="form-group">
                <input type="text" readonly class="form-control" value="Available Capacity : <?php echo $productRes['availablecapacity']?> Ton"/>
            </div>
            <div class="form-group">
                <input type="text" readonly class="form-control" value="Price Per/Ton : <?php echo $productRes['price']?>"/>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" required="true" name="capacity" id="capacity" placeholder="Your Needed Capacity :"/>
            </div>
            <div class="form-group">
                <button style="width: 400px" type="submit" class="btn btn-danger" name="add"><i class='glyphicon glyphicon-save'></i> Send Request</button>
            </div>
        </form>
    </div>
<br>
<?php include "includes/footer.php" ?>
</body>
</html>