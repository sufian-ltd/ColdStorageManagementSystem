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
    $dbStorage = new DBStorage();
    $dbProduct=new DBProducts();
    $key=0;
    $storageRes=$dbStorage->getStorages();
?>
<?php
    if(isset($_GET['search']) ) {
        $location=$_GET['location'];
        $product=$_GET['product'];
        $key=0;
        if($product!="" && $location!="") {
            $storageRes=$dbStorage->searchByKey($location);
            $productRes=$dbProduct->searchProduct($product);
            $key=1;
        }
        else if($product=="" && $location!=""){
            $storageRes=$dbStorage->searchByKey($location);
            $key=2;
        }
        else if($product!=="" && $location==""){
            $productRes=$dbProduct->searchProduct($product);
            $storageRes=$dbStorage->getStorages();
            $key=3;
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
        <form action="search-storage.php" method="get" style="width: 400px">
        <br/>
        <br/>
            <div class="form-group">
                <input type="text" class="form-control" name="location" id="location" placeholder="Search Location"/>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="product" id="product" placeholder="Search Product"/>
            </div>
            <div class="form-group">
                <button style="width: 400px" type="submit" class="btn btn-danger" name="search"><i class="glyphicon glyphicon-search"></i> Search</button>
            </div>
        </form>
        <br>
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
                <th>Action</th>
                <th>Action</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
            <?php if($key==0 || $key==2) {?>
                <?php foreach ($storageRes as $values) {?>
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
                        <?php
                        $lat=$values['latitude'];
                        $lon=$values['longitude'];
                        $mapurl="https://maps.google.com/maps?q=".$lat.",".$lon;
                        ?>
                        <td>
                            <?php echo "<a class='btn btn-warning' href='farmer-view-owner.php?action=viewOwner&ownerId=" . $values['userId'] . "'><i class='glyphicon glyphicon-user'></i> View Owner</a>"; ?>
                        </td>
                        <td>
                            <?php echo "<a class='btn btn-success' href='farmer-view-storage-offer.php?action=viewOffer&storageid=" . $values['id'] . "'><i class='glyphicon glyphicon-gift'></i> View Offer</a>"; ?>
                        </td>
                        <td>
                            <?php echo "<a class='btn btn-danger' href='search-product.php?action=searchproduct&storageid=" . $values['id'] . "'><i class='glyphicon glyphicon-tree-deciduous'></i> Check Details</a>"; ?>
                        </td>
                        <td>
                            <a href="<?php echo $mapurl;?>" class="btn btn-primary"><i class='glyphicon glyphicon-map-marker'></i> View Location</a>
                        </td>
                    </tr>
                <?php }?>
            <?php }?>
            <?php if($key==1 || $key==3) {?>
            <?php foreach ($productRes as $pro) { ?>
                <?php foreach ($storageRes as $values) {?>
                    <?php if($pro['storageid']==$values['id']) {?>
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
                        <?php
                        $lat=$values['latitude'];
                        $lon=$values['longitude'];
                        $mapurl="https://maps.google.com/maps?q=".$lat.",".$lon;
                        ?>
                        <td>
                            <?php echo "<a class='btn btn-warning' href='farmer-view-owner.php?action=viewOwner&ownerId=" . $values['userId'] . "'><i class='glyphicon glyphicon-user'></i> View Owner</a>"; ?>
                        </td>
                        <td>
                            <?php echo "<a class='btn btn-success' href='farmer-view-storage-offer.php?action=viewOffer&storageid=" . $values['id'] . "'><i class='glyphicon glyphicon-tree-conifer'></i> View Offer</a>"; ?>
                        </td>
                        <td>
                            <?php echo "<a class='btn btn-danger' href='search-product.php?action=searchproduct&storageid=" . $values['id'] . "'><i class='glyphicon glyphicon-book'></i> Check Details</a>"; ?>
                        </td>
                        <td>
                            <a href="<?php echo $mapurl;?>" class="btn btn-primary"><i class='glyphicon glyphicon-map-marker'></i> View Location</a>
                        </td>
                    </tr>
                    <?php }?>
                <?php }?>
            <?php } ?>
            <?php }?>
        </table>
    </div>
    <br><br>
<?php include "includes/footer.php" ?>
</body>
</html>