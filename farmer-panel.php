<?php
session_start();
if (isset($_SESSION['USER']) != "Farmer") {
    header('Location: index.php');
    exit();
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
<img src="images/c.jpg" style="width: 100%;height: 500px">
<?php include "includes/footer.php" ?>
</body>
</html>
