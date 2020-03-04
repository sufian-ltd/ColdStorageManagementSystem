<?php
session_start();
if (isset($_SESSION['USER']) != "Farmer") {
    header('Location: index.php');
    exit();
}
?>
<?php
    include "database/DBStorageOffer.php";
    $dbStorageOffer = new DBStorageOffer();
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'viewOffer') {
    $id = $_GET['storageid'];
    $storageOfferRes=$dbStorageOffer->getStorageOfferByStorageId($id);
    $msg="";
    if($dbStorageOffer->hasOffer($id)=="not exist")
        $msg="No Offer Added In Your Storage....!!!!!!!!!!!!!";
    else{
        $todayDate=time();
        $offerDate=$storageOfferRes['date']."";
        $offerDate=strtotime($offerDate);
        $datediff = $todayDate - $offerDate;
        $datediff=round($datediff / (60 * 60 * 24));
        if($datediff>=$storageOfferRes['days']){
            $dbStorageOffer->deleteStorageOfferByStorageid($id);
            $storageOfferRes=$dbStorageOffer->getStorageOffer(-1);
            $msg="No Offer Added In Your Storage....!!!!!!!!!!!!!";
        }
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
        <br><br><br><br>
        <?php
        if ($msg != "") {
            echo '<div style="font-size: 35px;font-family: fantasy;color: red;">' . $msg . '</div>';
        }
        ?>
        <br><br>
        <a style="font-family: serif;background-color: #002636;color: white;width: 400px" class="btn container">The Storage Offer Information</a>
        <table class="table table-bordered" style="width: 400px;">
        <tr align="center">
            <th>ID</th>
            <td><?php echo $storageOfferRes['id'] ?></td>
        </tr>
        <tr align="center">
            <th>Storage ID</th>
            <td><?php echo $storageOfferRes['storageid'] ?></td>
        </tr>
        <tr align="center">
            <th>Offer Value</th>
            <td style="color: red;font-family: fantasy;font-style: oblique;font-size: 18px;"><?php echo $storageOfferRes['description'] ?>% OFF</td>
        </tr>
        <tr align="center">
            <th>Offers Days</th>
            <td><?php echo $storageOfferRes['days'] ?></td>
        </tr>
    </table>
    </div>
    <br><br>
<?php include "includes/footer.php" ?>
</body>
</html>