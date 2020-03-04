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
    $storageOfferRes=$dbStorageOffer->getStorageOffer($id);
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

<?php
if(isset($_POST['add']) ) {
    $id=$_POST['id'];
    $days = $_POST['days'];
    $description=$_POST['description'];
    $msg="";
    if($dbStorageOffer->hasOffer($id)=="exist"){
        $dbStorageOffer->updateStorageOffer($id,$days,$description);
        header('Location: owner-storage.php');
        exit();
    }
    else{
        $dbStorageOffer->saveStorageOffer($id,$days,$description,date('y-m-d'));
        header('Location: owner-storage.php');
        exit();
    }
}
?>
<?php
if(isset($_POST['delete']) ) {
    $id=$_POST['id'];
    $dbStorageOffer->deleteStorageOfferByStorageid($id);
    $msg="No Offer Added In Your Storage....!!!!!!!!!!!!!";
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
    <br/><br><br>
    <?php
    if ($msg != "") {
        echo '<div style="font-size: 35px;font-family: fantasy;color: red;">' . $msg . '</div>';
    }
    ?>
    <div align="center" class="">
        <form action="add-storage-offer.php" method="post" style="width: 400px">
            <br/><br>
            <button style="background: #002636;color: #ffffff;font-family: serif" class="form-control">Please Fill The Specific
                Field
            </button>
            <br/>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group" style="text-align: left;margin-bottom: 5px;">
                <label>How Many Days</label>
            </div>
            <div class="form-group">
                <input type="number" required="true" class="form-control" name="days" id="days"
                       value="<?php echo $storageOfferRes['days'] ?>" placeholder="How many days :"/>
            </div>
            <div class="form-group" style="text-align: left;margin-bottom: 5px;">
                <label>Enter Offer Values</label>
            </div>
            <div class="form-group">
                <input type="number" required="true" class="form-control" name="description" id="description" placeholder="offer value(ex:10): " value="<?php echo $storageOfferRes['description']; ?>" />
            </div>
            <div class="form-group">
                <button style="width: 190px;margin-right: 10px;" type="submit" class="btn btn-primary" name="add"><i class="glyphicon glyphicon-save"></i> Save Changes</button>
                <?php if($msg=="") {?>
                <button style="width: 190px" type="submit" class="btn btn-danger" name="delete"><i class="glyphicon glyphicon-trash"></i> Delete Offer</button>
                <?php } else {?>
                    <button style="width: 190px;opacity: 0.5;" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete Offer</button>
                <?php }?>
            </div>
        </form>
    </div>
</div>
<br><br>
<?php include "includes/footer.php" ?>
</body>
</html>