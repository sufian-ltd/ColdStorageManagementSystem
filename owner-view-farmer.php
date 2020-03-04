<?php
session_start();
if (isset($_SESSION['USER']) != "Owner") {
    header('Location: index.php');
    exit();
}
?>
<?php
include "database/DBUser.php";
$dbUser = new DBUser();
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'viewFarmer') {
    $farmerid = $_GET['farmerid'];
    $storageid= $_GET['storageid'];
    $userRes=$dbUser->getUser($farmerid);
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
<div class="container" style="min-height: 400px;" align="center">
    <br/><br/>
    <div align="center" style="width: 400px;">
    <img src="images/u2.png" style="width:250px; height:250px;">
    <br><br>
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <input readonly type="text" maxlength="15" class="form-control"  value="Farmer Name : <?php echo $userRes['name']?>"/>
    </div>
    <br/>
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
        <input readonly type="email" class="form-control"  value="Email : <?php echo $userRes['email']?>"/>
    </div>
    <br/>
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
        <input readonly maxlength="11" minlength="11" class="form-control"  value="Contact : <?php echo $userRes['contact']?>"/>
    </div>
    <br/>
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
        <input readonly type="text" maxlength="20" class="form-control" value="Address : <?php echo $userRes['address']?>"/>
    </div>
    </div>
</div>
<br/>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>
