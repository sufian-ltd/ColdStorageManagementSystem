<?php
session_start();
if (isset($_SESSION['USER']) != "Owner") {
    header('Location: index.php');
    exit();
}
?>
<?php
include "database/DBStorageOffer.php";
include "database/DBStorage.php";
$dbStorage = new DBStorage();
$dbStorageOffer = new DBStorageOffer();
$msg="";
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'offer') {
    $id = $_GET['id'];
    $storageOfferRes=$dbStorageOffer->getStorageOffers($id);
}
?>
<?php
if( isset($_POST['add']) ) {
    $storageid=$_POST['storageid'];
    $days = $_POST['days'];
    $product = $_POST['product'];
    $capacity = $_POST['capacity'];
    $pricetype = $_POST['pricetype'];
    $price = $_POST['price'];
    $description=$_POST['description'];
    $storageRes=$dbStorage->getStorageById($storageid);
    $offerCapacityRes=$dbStorageOffer->getTotalOfferCapacityByStorageId($storageid);
    $totalOfferCapacity=$offerCapacityRes['capacity']+$capacity;
    $msg="";
    if($storageRes['availablecapacity']<($totalOfferCapacity)) {
        $msg = "Storage Capacity Limit Exceed...!!!Please Try Again.....!!!";
    }
    if($msg==""){
        $dbStorageOffer->saveStorageOffer($storageid,$days,$product,$capacity,$pricetype,$price,$description);
        $msg="Storage Offer Package Successfully Added...!!!!!!!!!!!!!!!!";
    }
    $storageOfferRes=$dbStorageOffer->getStorageOffers($storageid);
}
?>
<?php
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $storageid = $_POST['storageid'];
    $days = $_POST['days'];
    $product = $_POST['product'];
    $capacity = $_POST['capacity'];
    $pricetype = $_POST['pricetype'];
    $price = $_POST['price'];
    $description=$_POST['description'];
    $storageRes=$dbStorage->getStorageById($storageid);
    $offerCapacityRes=$dbStorageOffer->getTotalOfferCapacityByStorageId($storageid);
    $totalOfferCapacity=$offerCapacityRes['capacity']+$capacity;
    $msg="";
    if($storageRes['availablecapacity']<($totalOfferCapacity)) {
        $msg = "Storage Capacity Limit Exceed...!!!Please Try Again.....!!!";
    }
    if($msg==""){
        $dbStorageOffer->updateStorageOffer($id,$storageid,$days,$product,$capacity,$pricetype,$price,$description);
    }
    $storageOfferRes=$dbStorageOffer->getStorageOffers($storageid);
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
        $result = $dbStorageOffer->getStorageOfferById($id);
        $storageOfferRes=$dbStorageOffer->getStorageOffers($result['storageid']);
        ?>
        <div align="center" class="">
            <form action="storage-offer.php" method="post" style="width: 400px">
                <br/>
                <button style="background: black;color: #ffffff;font-family: serif" class="form-control">Please Fill The Specific
                    Field
                </button>
                <br/>
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                <input type="hidden" name="storageid" value="<?php echo $result['storageid'] ?>">
                <div class="form-group">
                    <input type="number" class="form-control" name="days" id="days"
                           value="<?php echo $result['days'] ?>" placeholder="How many days :"/>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="product" id="name"
                           value="<?php echo $result['product'] ?>" placeholder="Product Type :"/>
                </div>
                <div class="form-group">
                    <input type="number" required="true" class="form-control" name="capacity" id="capacity" placeholder="Product Capacity : "
                           value="<?php echo $result['capacity'] ?>"/>
                </div>
                <div class="form-group">
                    <select class="form-control" name="pricetype">
                        <!--                            <option>Select Price Type</option>-->
                        <option>Per/Ton</option>
                        <option>Per/KG</option>
                        <option>Per/Litre</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="number" required="true" class="form-control" name="price" id="status" placeholder="Price : "
                           value="<?php echo $result['price'] ?>"/>
                </div>
                <div class="form-group">
                    <textarea type="text" required="true" class="form-control" name="description" id="description" placeholder="Description : "
                           value="<?php echo $result['description'] ?>"></textarea>
                </div>
                <div class="form-group">
                    <button style="width: 400px" type="submit" class="btn btn-success" name="update"><i class="glyphicon glyphicon-save"></i>Save Changes</button>
                </div>
            </form>
        </div>
    <?php } else{ ?>
        <form action="storage-offer.php" method="post" style="width: 400px">
            <h3 style="font-family: serif;width: 400px;">Manage Package Offer In Your Stoarge</h3>
            <br/>
            <input type="hidden" name="storageid" value="<?php echo $id ?>">
            <div class="form-group">
                <input type="number" required="true" class="form-control" name="days" id="days" placeholder="How Many Days :"/>
            </div>
            <div class="form-group">
                <textarea type="text" required="true" class="form-control" name="description" id="description" placeholder="Description : "></textarea>
            </div>
            <div class="form-group">
                <button style="width: 400px" type="submit" class="btn btn-danger" name="add"><i class="glyphicon glyphicon-save"></i>Click hete to add</button>
            </div>
        </form>
    <?php }?>
    <br>
    <table class="table">
        <tr align="center">
            <th>ID</th>
            <th>Storage ID</th>
            <th>Offers Days</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        <?php foreach ($storageOfferRes as $values) { ?>
            <tr>
                <td><?php echo $values['id'] ?></td>
                <td><?php echo $values['storageid'] ?></td>
                <td><?php echo $values['days'] ?></td>
                <td><?php echo $values['description'] ?></td>
                <td>
                    <?php echo "<a class='btn btn-success' href='storage-offer.php?action=edit&id=" . $values['id'] . "&storageid=" . $values['storageid'] . "'><i class='glyphicon glyphicon-save'></i>Update Capacity</a>"; ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<br><br>
<?php include "includes/footer.php" ?>
</body>
</html>