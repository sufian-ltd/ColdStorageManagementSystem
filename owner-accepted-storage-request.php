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
?>
<?php
if(isset($_GET["checkout"])) {
    $id = $_GET['id'];
    $productid = $_GET['productid'];
    $ownerid=$_GET['ownerId'];
    $storageid=$_GET['storageid'];
    $farmerid=$_GET['farmerid'];
    require_once('tcpdf/tcpdf.php');

    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $obj_pdf->SetCreator(PDF_CREATOR);
    $obj_pdf->SetTitle("Farmer Storage Checkout Report");
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
    $content .= fetch_data($id,$storageid,$productid,$ownerid,$farmerid);
    $obj_pdf->writeHTML($content);
    $obj_pdf->Output('file.pdf', 'I');
    $dbRequest->checkoutRequest($id);
    $proRes=$dbProducts->getProductById($id);
    $requestRes=$dbRequest->getRequestById($id);
    $dbProducts->updateAvailableCapacity($proRes['id'],$proRes['availablecapacity']+$requestRes['capacity']);
}
?>
<?php
$requestRes=$dbRequest->getStorageRequestByOwnerId($_SESSION['userId'],'accepted');
?>

<?php
 function fetch_data($id,$storageid,$productid,$ownerid,$farmerid)
 {  
      $output = '';
      $dbStorage = new DBStorage();
      $dbRequest=new DBRequest();
      $dbUser=new DBUser();
      $dbStorageOffer = new DBStorageOffer();
      $dbProduct=new DBProducts();
      $requestValues=$dbRequest->getRequestById($id);
      $userValues=$dbUser->getUser($farmerid);
      $storageValues=$dbStorage->getStorageById($storageid);

      $storageOfferRes=$dbStorageOffer->getStorageOffer($storageid);
      if($dbStorageOffer->hasOffer($storageid)=="exist"){
        $todayDate=time();
        $offerDate=$storageOfferRes['date']."";
        $offerDate=strtotime($offerDate);
        $datediff = $todayDate - $offerDate;
        $datediff=round($datediff / (60 * 60 * 24));
        if($datediff>=$storageOfferRes['days']){
            $dbStorageOffer->deleteStorageOfferByStorageid($storageid);
        }
      }

      $checkoutDate=time();
      $entryDate=$requestValues['date']."";
      $entryDate=strtotime($entryDate);
      $datediff = $checkoutDate - $entryDate;
      $datediff=round($datediff / (60 * 60 * 24));
      $checkoutDate=date('y-m-d');
      $totalCost=$requestValues['price']*$requestValues['capacity']*$datediff;
      if($dbStorageOffer->hasOffer($storageid)=="exist"){
          $offerValues=$dbStorageOffer->getStorageOffer($storageid);
          $discount=$offerValues['description'];
          $afterDiscount=$totalCost-(($discount*$totalCost)/100);
          $discount=$discount." % OFF";
      }
      else{
          $discount="No Discount";
          $afterDiscount=$totalCost;
      }

     $output .= '
        <h2 align="center">Product Check Our Report</h2>
        <table border="1" cellspacing="0" cellpadding="3">
            <tr>
                <td>'.'Storage Name'.'</td>
                <td>'.$requestValues['storagename'].'</td>
            </tr>
            <tr>
                <td>'.'Storage Location'.'</td>
                <td>'.$storageValues['location'].'</td>
            </tr>
        </table>
        <br><br>
        <h3 align="center">'.'Farmer Information'.'</h3>
        <table border="1" cellspacing="0" cellpadding="3">
            <tr>
                <td>'.'ID'.'</td>
                <td>'.$userValues['id'].'</td>  
            </tr>
            <tr>
                <td>'.'Name'.'</td>
                <td>'.$userValues['name'].'</td>
            </tr>
            <tr>
                <td>'.'Email'.'</td>
                <td>'.$userValues['email'].'</td>
            </tr>
            <tr>
                <td>'.'Contact'.'</td>
                <td>'.$userValues['contact'].'</td>
            </tr>
            <tr>
                <td>'.'Address'.'</td>
                <td>'.$userValues['address'].'</td>
            </tr>
        </table>
        <br><br>
        <h2 align="center">Checkout Transaction</h2>
        <table border="1" cellspacing="0" cellpadding="3">
            <tr>  
                <td>'.'Request ID : '.'</td>  
                <td>'.$requestValues['id'].'</td>
            </tr>
            <tr>
                <td>'.'Product Name : '.'</td>  
                <td>'.$requestValues['product'].'</td>
            </tr>
            <tr>
                <td>'.'Product Weight : '.'</td>  
                <td>'.$requestValues['capacity'].'</td>
            </tr>
            <tr>
                <td>'.'Total Cost : '.'</td>  
                <td>'.$totalCost.'</td>
            </tr>
            <tr>
                <td>'.'Discount : '.'</td>  
                <td>'.$discount.'</td>
            </tr>
            <tr>
                <td>'.'After Discount : '.'</td>  
                <td>'.$afterDiscount.'</td>
            </tr>
            <tr>
                <td>'.'Request Date : '.'</td>  
                <td>'.$requestValues['date'].'</td>
            </tr>
            <tr>
                <td>'.'Checkout Date : '.'</td>  
                <td>'.$checkoutDate.'</td>
            </tr>
        </table>
                          ';
     return $output;
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
    <br/><br/>
    <table class="table">
        <tr align="center">
        	<th>Owner ID</th>
            <th>Storage ID</th>
            <th>Storage Name</th>
            <th>Product Type</th>
            <th>Farmer Id</th>
            <th>Product Weight</th>
            <th>Total Cost(1day/1ton)</th>
            <th>Accept Request Date</th>
            <th>Action</th>
            <th>Action</th>
            <th>Action</th>
        </tr>
        <?php foreach ($requestRes as $values) { ?>
	    <tr>
            <td><?php echo $values['ownerId'] ?></td>
            <td><?php echo $values['storageid'] ?></td>
            <td><?php echo $values['storagename'] ?></td>
            <td><?php echo $values['product'] ?></td>
            <td><?php echo $values['farmerid'] ?></td>
            <td><?php echo $values['capacity'] ?></td>
            <td><?php echo $values['price'] ?></td>
            <td><?php echo $values['date'] ?></td>
            <td>
                <?php echo "<a class='btn btn-success' href='owner-view-farmer.php?action=viewFarmer&farmerid=" . $values['farmerid'] . "&storageid=" . $values['storageid'] . "'><i class='glyphicon glyphicon-user'></i> View Farmer</a>"; ?>
            </td>
            <td>
                <?php echo "<a class='btn btn-primary' href='owner-storage-capacity.php?action=viewStorageCapacity&ownerId=" . $values['ownerId'] . "&storageid=" . $values['storageid'] . "'><i class='glyphicon glyphicon-fire'></i> Storage Capacity</a>"; ?>
            </td>
            <td>
                <form action="" method="get">
                    <input type="hidden" name="id" value="<?php echo $values['id']; ?>">
                    <input type="hidden" name="productid" value="<?php echo $values['productid']; ?>">
                    <input type="hidden" name="ownerId" value="<?php echo $values['ownerId']; ?>">
                    <input type="hidden" name="farmerid" value="<?php echo $values['farmerid']; ?>">
                    <input type="hidden" name="storageid" value="<?php echo $values['storageid']; ?>">
                    <button class="btn btn-danger" type="submit" name="checkout"><i class='glyphicon glyphicon-shopping-cart'></i> Checkout</button>
                </form>
            </td>
	    </tr>
        <?php } ?>
    </table>
</div>
<br/>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>
