<?php
session_start();
if (isset($_SESSION['USER']) != "Farmer") {
    header('Location: index.php');
    exit();
}
?>
<?php
include "database/DBUser.php";
$dbUser = new DBUser();
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'viewOwner') {
    $id= $_GET['ownerId'];
    $userRes=$dbUser->getUser($id);
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
<body style="font-family: serif;background-color: #002636;">
<?php //include "includes/farmer-navbar.php";?>
<div class="container" style="min-height: 400px;" align="center">
    <br/><br>
    <div align="center" style="width: 400px;">
    <img src="images/u3.png" style="width:250px; height:220px;">
    <br><br>
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <input readonly type="text" maxlength="15" class="form-control"  value="Owner Name : <?php echo $userRes['name']?>"/>
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
    <br>
    <div class="input-group">
        <a style="width: 400px;" href="search-storage.php" class="btn btn-danger"><i class="glyphicon glyphicon-hand-left"></i> Back</a>
    </div>
    </div>
</div>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>
