<?php
session_start();
include("../inc_dbconnect.php");
include ("../quotation_sales_data_new.php");

include("invoice_db.php");
$invoice = new invoiceDB($dbname);

header('Content-Type: text/html; charset=TIS-620');

if(mysql_num_rows($invoice->invoiceQuery("SELECT * FROM ready_invoice WHERE invID = '$_POST[invNo]' AND status = '1';")) == 0){
    echo "This invoice cannot be found.";
    exit();
}

foreach ($_POST[itemNote] as $value) {
    $noteItem[] = $invoice->convertBigText($value);
}
unset($_POST[itemNote]);

$_POST = $invoice->convertToTis($_POST);

$sp = ($_POST[companyID] == 1) ? 0 : 1;//normal : spacial
$sql = "UPDATE ready_invoice_customers SET
        name = '$_POST[attention]',
        company = '$_POST[company]',
        address = '$_POST[add]',
        province = '$_POST[province]',
        zipcode = '$_POST[zip]',
        tel = '$_POST[tel]',
        fax = '$_POST[fax]',
        saleName = '$_POST[attention_sale]',
        telExt = '$_POST[tel_ext]',
        directLine = '$_POST[directLine]'
        WHERE no = '$_POST[no]';";

if(!$invoice->invoiceQuery($sql)){
    echo "ERROR !!";
    exit();
}


$sql = "UPDATE ready_invoice SET
        payMethod = '$_POST[payMethod]',
        poNumber = '$_POST[poNumber]',
        percentVat = '$_POST[vatSp]',
        customerType = '$_POST[customer_type]',
        businessType = '$_POST[business_type]',
        createDate = '$_POST[issue]',
        dueDate = '$_POST[dueDate]',
        billingDate = '$_POST[billingDate]',
        chequeReceivingDate = '$_POST[chequeReceivingDate]',
        totalPrice = '$_POST[totalprice]',
        vatPrice = '$_POST[vatprice]',
        netTotalPrice = '$_POST[nettotalprice]',
        withholdingTax = '$_POST[withholdingTax]',
        netAmount = '$_POST[netAmount]',
        monetary = '$_POST[monetary]',
        remark = '$_POST[note]'
        WHERE no = '$_POST[no]';";

if(!$invoice->invoiceQuery($sql)){
    echo "ERROR !!";
    exit();
}


$invoice->invoiceQuery("DELETE FROM ready_invoice_details WHERE invNo = '$_POST[no]';");


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
    
    $detail[] = "('$_POST[no]', '$item[0]', '$itemDetail[pname]', '$price', '$unit', '$amount', '$boi', '$note')";
}
$sql .= implode(",", $detail) . ";";
if(!$invoice->invoiceQuery($sql)){
    echo "ERROR !!";
    exit();
}

echo "Success";
?>

