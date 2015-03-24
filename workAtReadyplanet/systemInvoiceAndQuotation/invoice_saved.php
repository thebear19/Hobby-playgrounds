<?php
session_start();
include("../inc_dbconnect.php");
include ("../quotation_sales_data_new.php");

include("invoice_db.php");
$invoice = new invoiceDB($dbname);

header('Content-Type: text/html; charset=TIS-620');

if(mysql_num_rows($invoice->invoiceQuery("SELECT * FROM ready_invoice WHERE invID = '$_POST[invNo]' AND status = '1';")) > 0){
    echo "This invoice has already.";
    exit();
}

foreach ($_POST[itemNote] as $value) {
    $noteItem[] = $invoice->convertBigText($value);
}
unset($_POST[itemNote]);

$_POST = $invoice->convertToTis($_POST);

$sp = ($_POST[companyID] == 1) ? 0 : 1;//normal : spacial
$sql = "INSERT INTO ready_invoice_customers (customerID, name, company, address, province, country, zipcode, tel, fax, saleName, telExt, directLine)
        VALUES ('$_POST[cusID]', '$_POST[attention]', '$_POST[company]', '$_POST[add]', '$_POST[province]', 'Thailand', '$_POST[zip]',
        '$_POST[tel]','$_POST[fax]', '$_POST[attention_sale]', '$_POST[tel_ext]', '$_POST[directLine]');";

if(!$invoice->invoiceQuery($sql)){
    echo "ERROR !!";
    exit();
}

$invCus = mysql_insert_id();



$sql = "INSERT INTO ready_invoice (invID, qaID, adminID, invCusNO, clearingID, companyID,
    status, payMethod, payType, poNumber, percentVat, customerType, businessType, createDate, dueDate, billingDate, chequeReceivingDate,
    totalPrice, vatPrice, netTotalPrice, withholdingTax, netAmount, monetary, domainName, remark, special, orgStuct)
        VALUES ('$_POST[invNo]', '$_POST[qno]', '$_POST[adminID]', '$invCus', '0', '$_POST[companyID]', '1', '$_POST[payMethod]', '$_POST[companyID]',
        '$_POST[poNumber]', '$_POST[vatSp]', '$_POST[customer_type]', '$_POST[business_type]', '$_POST[issue]', '$_POST[dueDate]', '$_POST[billingDate]', '$_POST[chequeReceivingDate]', '$_POST[totalprice]',
        '$_POST[vatprice]', '$_POST[nettotalprice]', '$_POST[withholdingTax]', '$_POST[netAmount]', '$_POST[monetary]', '$_POST[domain]', '$_POST[note]', '$sp', '0');";

if(!$invoice->invoiceQuery($sql)){
    echo "ERROR !!";
    exit();
}

$invNo = mysql_insert_id();


$sql = "INSERT INTO ready_invoice_details (invNo, productID, itemName, price, unit, amount, boi, note) VALUES";
foreach ($_POST[service] as $key => $service) {
    if(empty($service)){
        continue;
    }
    $item = explode("-", $service);
    
    $itemDetail = $invoice->getProduct($item[0]);
    
    $boi = ($itemDetail[BOI] == "NB") ? 0 : 1;
    $note = $noteItem[$key];
    $price = $_POST[price][$key];
    $unit = $_POST[unit][$key];
    $amount = $_POST[amount][$key];
    
    $detail[] = "('$invNo', '$item[0]', '$itemDetail[pname]', '$price', '$unit', '$amount', '$boi', '$note')";
}
$sql .= implode(",", $detail) . ";";

if($invoice->invoiceQuery($sql)){
    $invoice->invoiceQuery("UPDATE ready_office_quotation SET invoice_no = '$_POST[invNo]' WHERE qno = '$_POST[qno]';");
    
    echo "Success";
}else{
    echo "ERROR !!";
}

?>

