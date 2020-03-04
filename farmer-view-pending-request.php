<?php
include "database/DBRequest.php";
include "database/DBStorage.php";
$dbRequest=new DBRequest();
$dbStorage=new DBStorage();
$requestRes=$dbRequest->getRequestByStatus("pending");
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
<?php include "includes/farmer-navbar.php";?>    
    <div class="container" align="center" style="min-height: 450px;">   
        <br><br>
        <input type="" name="" class="btn btn-danger form-control container" value="My Pending Storage Requests">
        <table class="table">
            <tr align="center">
                <th>ID</th>
                <th>Storage Name</th>
                <th>Product Type</th>
                <th>Product Capacity</th>
                <th>Cost 1day/1ton</th>
                <th>Request Date</th>
                <th>Status</th>
            </tr>
            <?php foreach ($requestRes as $values) { ?>
            <tr>
                <td><?php echo $values['id'] ?></td>
                <td><?php echo $values['storagename'] ?></td>
                <td><?php echo $values['product'] ?></td>
                <td><?php echo $values['capacity'] ?></td>
                <td><?php echo $values['price'] ?></td>
                <td><?php echo $values['date'] ?></td>
                <td><?php echo $values['status'] ?></td>
            </tr>
            <?php }?>
        </table>
    </div>
    <br><br>
<?php include "includes/footer.php" ?>
</body>
</html>