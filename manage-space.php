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
if (isset($_GET['action']) && $_GET['action'] == 'manage') {
    $storageid = $_GET['id'];
    $storageProductRes=$dbProducts->getStorageProduct($storageid);
}
?>
<?php
if( isset($_POST['add']) ) {
    $storageid=$_POST['storageid'];
    $product = $_POST['product'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];
    $storageRes=$dbStorage->getStorageById($storageid);
    $msg="";
    if($storageRes['availablecapacity']<$capacity)
        $msg="Storage Capacity Limit Exceed...!!!Please Try Again.....!!!";
    else{
        $dbProducts->saveProductByStorage($storageid,$product,$capacity,$capacity,$price);
        $dbStorage->updateStorageCapacity($storageid,$storageRes['availablecapacity']-$capacity);
    }
    $storageProductRes=$dbProducts->getStorageProduct($storageid);
}
?>
<?php
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $storageid = $_POST['storageid'];
    $product = $_POST['product'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];
    $capacitybefore=$_POST['capacitybefore'];
    $availablecapacitybefore=$_POST['availablecapacitybefore'];
    $storageRes=$dbStorage->getStorageById($storageid);
    $msg="";
    if($capacitybefore<$capacity){
        if($storageRes['availablecapacity']<($capacity-$capacitybefore))
            $msg="Storage Capacity Limit Exceed...!!!Please Try Again.....!!!";
        else {
            $dbProducts->updateProducts($id, $product, $capacity,$availablecapacitybefore+($capacity-$capacitybefore),$price);
            $dbStorage->updateStorageCapacity($storageid,$storageRes['availablecapacity']-($capacity-$capacitybefore));
            $msg="Update successful(product available capacity increased....!!!)";
            $msg=$msg."<br/>Update successful(storage available capacity decreased....!!!)";
        }
    }
    else if($capacitybefore>$capacity){
        if(($capacitybefore-$capacity)<=$availablecapacitybefore){
            $dbProducts->updateProducts($id, $product, $capacity,$availablecapacitybefore-($capacitybefore-$capacity),$price);
            $dbStorage->updateStorageCapacity($storageid,$storageRes['availablecapacity']+($capacitybefore-$capacity));
            $msg="Update successful(product available capacity decreased....!!!)";
            $msg=$msg."<br/>Update successful(storage available capacity increased....!!!)";
        }
    }
    else if($capacitybefore==$capacity){
        $dbProducts->updateProducts($id, $product, $capacity,$availablecapacitybefore,$price);
        $msg="Update successful(No change in storage available capacity....!!!)";
    }
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
                <form action="manage-space.php" method="post" style="width: 400px">
                    <br/>
                    <button style="background: black;color: #ffffff;font-family: serif" class="form-control">Please Fill The Specific
                        Field
                    </button>
                    <br/>
                    <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                    <input type="hidden" name="storageid" value="<?php echo $result['storageid']; ?>">
                    <input type="hidden" name="capacitybefore" value="<?php echo $result['totalcapacity']; ?>">
                    <input type="hidden" name="availablecapacitybefore" value="<?php echo $result['availablecapacity']; ?>">
                    <div class="form-group">
                        <input type="text" required class="form-control" name="product" id="name"
                               value="<?php echo $result['product']; ?>" placeholder="Product Type :"/>
                    </div>
                    <div class="form-group">
                        <input type="text" readonly required="true" class="form-control" value="Avilable Capacity : <?php echo $result['availablecapacity']; ?>"/>
                    </div>
                    <div class="form-group" style="text-align: left">
                        <label>Total Capacity</label>
                        <input type="text" class="form-control" name="capacity" id="capacity" placeholder="Product Capacity : "
                               value="<?php echo $result['totalcapacity']; ?>"/>
                    </div>
                    <div class="form-group" style="text-align: left">
                        <label>Price</label>
                        <input type="number" required="true" class="form-control" name="price" id="price" placeholder="Product Price : "
                               value="<?php echo $result['price']; ?>"/>
                    </div>
                    <div class="form-group">
                        <button style="width: 400px" type="submit" class="btn btn-primary" name="update"><i class="glyphicon glyphicon-save-file"></i> Save Changes</button>
                    </div>
                </form>
            </div>
        <?php } else{ ?>
            <form action="manage-space.php" method="post" style="width: 400px">
                <a class="btn" style="background-color: #000;color:#fff;font-family: serif;width: 400px;">Manage Product In Your Stoarge</a>
                <br><br>
                <input type="hidden" name="storageid" value="<?php echo $storageid; ?>">
                <div class="form-group">
                    <input type="text" required="true" class="form-control" name="product" id="name" placeholder="Product Type :"/>
                </div>
                <div class="form-group">
                    <input type="number" required="true" class="form-control" name="capacity" id="capacity" placeholder="Product Capacity : " />
                </div>
                <div class="form-group">
                    <input type="number" required="true" class="form-control" name="price" id="price" placeholder="Product Price : " />
                </div>
                <div class="form-group">
                    <button style="width: 400px" type="submit" class="btn btn-primary" name="add"><i class="glyphicon glyphicon-save"></i> Click here to Add</button>
                </div>
            </form>
        <?php }?>
        <br>
        <table class="table">
            <tr align="center">
                <th>Product ID</th>
                <th>Storage ID</th>
                <th>Product</th>
                <th>Total Capacity</th>
                <th>Available Capacity</th>
                <th>Price</th>
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
                        <?php echo "<a class='btn btn-primary' href='manage-space.php?action=edit&id=" . $values['id'] . "&storageid=" . $values['storageid'] . "'><i class='glyphicon glyphicon-edit'></i> Update</a>"; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php include "includes/footer.php" ?>
</body>
</html>