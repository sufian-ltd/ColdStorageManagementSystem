<?php
session_start();
if (isset($_SESSION['USER']) != "Owner") {
    header('Location: index.php');
    exit();
}
?>
<?php
include "database/DBStorage.php";
include "database/DBProducts.php";
include "database/DBStorageOffer.php";
include "database/DBRequest.php";
include "database/DBUser.php";
$msg = "";
$dbStorage = new DBStorage();
$dbProducts = new DBProducts();
$dbStorageOffer = new DBStorageOffer();
$dbRequest=new DBRequest();
$dbUser=new DBUser();
$requestRes=$dbRequest->getStorageRequestByOwnerId($_SESSION['userId'],'checkout');
?>
<?php
function fetch_data()
{
    $output = '';
    $dbRequest = new DBRequest();
    $reqRes=$dbRequest->getRequestByStatus("checkout");
    foreach ($reqRes as $values)
    {
        $output .= '
        <tr>  
            <td>'.$values['id'].'</td>  
            <td>'.$values['ownerId'].'</td>
            <td>'.$values['storageid'].'</td>
            <td>'.$values['storagename'].'</td>
            <td>'.$values['productid'].'</td>
            <td>'.$values['product'].'</td>
            <td>'.$values['farmerid'].'</td>
            <td>'.$values['capacity'].'</td>
            <td>'.$values['price'].'</td>
            <td>'.$values['date'].'</td>
            <td>'.$values['status'].'</td>
        </tr>  
                          ';
    }
    return $output;
}
?>
<?php
if((isset($_GET['action']) && $_GET['action'] == 'report')) {

    require_once('tcpdf/tcpdf.php');
    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $obj_pdf->SetCreator(PDF_CREATOR);
    $obj_pdf->SetTitle("Your All Product Transaction Report");
    $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $obj_pdf->SetDefaultMonospacedFont('helvetica');
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
    $obj_pdf->setPrintHeader(false);
    $obj_pdf->setPrintFooter(false);
    $obj_pdf->SetAutoPageBreak(TRUE, 10);
    $obj_pdf->SetFont('helvetica', '', 11);
    $obj_pdf->AddPage();
    $content = '';
    $content .= '  
        <h4 align="center">Your Storage Transaction Report</h4><br /> 
        <table border="1" cellspacing="0" cellpadding="3">  
           <tr>
            <th>ID</th>
            <th>Owner ID</th>
            <th>Storage ID</th>
            <th>Storage Name</th>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Farmer id</th>
            <th>Capacity</th>
            <th>Price</th>
            <th>Delivery Date</th>
            <th>Message</th>
        </tr> 
        ';
    $content .= fetch_data();
    $content .= '</table>';
    $obj_pdf->writeHTML($content);
    $obj_pdf->Output('file.pdf', 'I');
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
<div class="container-fluid" style="min-height: 400px;">
    <br/>
    <a href="owner-transaction.php?action=report" class="btn btn-primary"><i class='glyphicon glyphicon-print'></i> Generate Report</a>
    <br><br>
    <table class="table">
        <tr align="center">
            <th>ID</th>
            <th>Owner ID</th>
        	<th>Storage Owner</th>
            <th>Storage ID</th>
            <th>Storage Name</th>
            <th>Product ID</th>
            <th>Product Type</th>
            <th>Farmer ID</th>
            <th>Farmer Name</th>
            <th>Used Capacity</th>
            <th>Total Cost</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        <?php foreach ($requestRes as $values) { ?>
	    <tr>
            <td><?php echo $values['id'] ?></td>
            <td><?php echo $values['ownerId'] ?></td>
            <?php $owner=$dbUser->getUser($values['ownerId']) ?>
            <td><?php echo $owner['name'] ?></td>
            <td><?php echo $values['storageid'] ?></td>
            <td><?php echo $values['storagename'] ?></td>
            <td><?php echo $values['productid'] ?></td>
            <td><?php echo $values['product'] ?></td>
            <td><?php echo $values['farmerid'] ?></td>
            <?php $farmer=$dbUser->getUser($values['farmerid']) ?>
            <td><?php echo $farmer['name'] ?></td>
            <td><?php echo $values['capacity'] ?> Ton</td>
            <td><?php echo $values['price'] ?> TK</td>
            <td><?php echo $values['date'] ?></td>
            <td><?php echo $values['status'] ?> complete</td>
	    </tr>
        <?php } ?>
    </table>
</div>
<br/>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>
