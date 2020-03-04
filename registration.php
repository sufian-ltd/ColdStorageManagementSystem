<?php
    include "database/DBUser.php";
    $msg = "";
    if( isset($_POST['register']) ) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $password = md5($password);
        $userType=$_POST['userType'];
        $dbUser = new DBUser();
        $msg=$dbUser->isUser($email,$password,$userType);
        if($msg=='exist'){
            $msg="This email and password is already exist...!!!<br/>So please try again";
        }
        else if($dbUser->registerUser($name,$email,$password,$contact,$address,$userType)){
            $msg="Your Registration is successfully complete....!!!!!!!!!";
        }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP-CRUD-Registration</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body style="font-family: serif;color: white; background-color: #002636;">
<div class="container" align="center">
    <h2>Cold Storage Management System</h2>
    <hr/>
    <form action="registration.php" method="post"
          style="width: 500px;border-style: groove;padding-left: 50px;padding-right: 50px;padding-bottom: 15px;border-color: #fff">
        <div style="margin-top: 10px">
            <?php
            if ($msg != "") {
                echo '<div class="alert alert-danger">' . $msg . '</div>';
            }
            ?>
        </div>
        <h3 style="color: white">User Registration</h3>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
            <select required name="userType" class="form-control">
                <option value="Owner">Owner</option>
                <option value="Farmer">Farmer</option>
            </select>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input required type="text" maxlength="15" class="form-control" name="name" id="name1" placeholder="Enter Full Name : "/>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
            <input required type="email" class="form-control" name="email" id="email1" placeholder="Enter Valid Email Address : "/>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input required maxlength="15" minlength="5" type="password" class="form-control" name="password" id="password1"
                   placeholder="Enter Valid Password : "/>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
            <input required type="number" maxlength="11" minlength="11" class="form-control" name="contact" id="contact1" placeholder="Enter Valid Contact : "/>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
            <input required type="text" maxlength="20" class="form-control" name="address" id="address1" placeholder="Enter Valid address"/>
        </div>
        <br/>
        <div class="input-group">
<!--            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>-->
            <button name="register" style=" width: 190px;margin-right: 14px;" type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-save"></i>  Register</button>
            <a href="index.php" name="login" style=" width: 190px" type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-log-in"></i>  Login</a>
        </div>
    </form>
</div>
<?php include "includes/footer.php" ?>
</body>
</html>
