<?php
    session_start();
    include "database/DBUser.php";
    $dbUser=new DBUser();
    $msg = "";
    if( isset($_POST['login']) ) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password=md5($password);
        $userType=$_POST['userType'];
        if($dbUser->isUser($email,$password,$userType)=="exist"){
            $user=$dbUser->getUserByEmailPass($email,$password);
            if($userType=="Owner") {
                $_SESSION["USER"]="Owner";
                $_SESSION["email"]=$email;
                $_SESSION["password"]=$password;
                $_SESSION["userId"]=$user['id'];
                header('Location: owner-panel.php');
                exit;
            }
            elseif ($userType=="Farmer") {
                $_SESSION["USER"]="Farmer";
                $_SESSION["email"]=$email;
                $_SESSION["password"]=$password;
                $_SESSION["userId"]=$user['id'];
                header('Location: farmer-panel.php');
                exit;
            }
        }
        else {
            $msg = "You entered wrong information...!!!";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin-Login</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body style="font-family: serif;color:#fff;width: 100%;background-color: #002636">
<div class="container" align="center">
    <h2>Cold Storage Management System</h2>
    <hr/>
    <form action="index.php" method="post" style="background-color: #002636;width: 450px;padding: 15px">
        <img src="images/u3.png" style="width:200px; height:200px;">
        <div class="input-group">
            <h3>Welcome Please Login</h3>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
            <input required type="email" class="form-control" name="email" id="email1" placeholder="Email : "/>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input required maxlength="15" minlength="5" type="password" class="form-control" name="password" id="password1"
                   placeholder="Password : "/>
        </div>
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
            <button style="width:420px" name="login" type="submit" class="btn btn-danger glyphicon glyphicon-log-in"> Login</button>
        </div>
        <br/>
        <div class="input-group">
            <a style="color: white" href="registration.php">Not register yet? Click here to Register</a>
        </div>
    </form>
</div>
</body>
</html>
