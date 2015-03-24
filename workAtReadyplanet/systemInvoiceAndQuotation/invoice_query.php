<?php
include("../inc_dbconnect.php");
include("invoice_db.php");
$invoice = new invoiceDB($dbname);

header('Content-Type: text/html; charset=TIS-620');

if(!empty($_POST[productID])){
    $productRow = $invoice->getProduct($_POST[productID]);
    echo "$productRow[pro_desc]";
    exit();
}
?>