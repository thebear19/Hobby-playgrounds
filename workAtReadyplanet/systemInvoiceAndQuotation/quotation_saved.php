<?php
session_start();
include("../inc_dbconnect.php");
include ("../quotation_sales_data_new.php");

include("invoice_db.php");
$invoice = new invoiceDB($dbname);

header('Content-Type: text/html; charset=TIS-620');

foreach ($_POST[itemNote] as $value) {
    $noteItem[] = $invoice->convertBigText($value);
}
unset($_POST[itemNote]);

$noteFooter = $invoice->convertBigText($_POST[note]);
unset($_POST[note]);

$_POST = $invoice->convertToTis($_POST);
$sp = ($_POST[companyID] == 1) ? "" : "Yes";//normal : spacial
$_POST[qno] = $invoice->nextQA();

//DomainName = %vat เอามาใช้เก็บแทน
$sqlRow = "INSERT INTO ready_office_quotation 
    (qno, issue, validdate, creator, creator_admin_id, creator_company, creator_address, creator_int_number,
    CustomerID, attention, company, addr, province, zip, tel, fax, totalprice, vatprice,
    nettotalprice, SaleID, direct_line, note_webpro, special, monetary_type, thaiword, percentVat, DomainName, newSys";

$sqlValue = " VALUES ('$_POST[qno]', '$_POST[issue]', '$_POST[validUntil]', '$_POST[attention_sale]', '$_POST[adminID]', '$_POST[creatorCom]',
        '$_POST[creatorAdd]', '$_POST[tel_ext]', '$_POST[cusID]', '$_POST[attention]', '$_POST[company]', '$_POST[add]', '$_POST[province]',
        '$_POST[zip]', '$_POST[tel]', '$_POST[fax]', '$_POST[totalprice]', '$_POST[vatprice]', '$_POST[nettotalprice]', '$_POST[saleID]',
        '$_POST[directLine]', '$noteFooter', '$sp', '$_POST[monetary]', '$_POST[thaiword]', '$_POST[vatSp]', '$_POST[domain]', '1'";

foreach ($_POST[service] as $key => $service) {
    if(empty($service)){
        continue;
    }
    $index = $key + 1;
    
    $sqlDetail[] = "item$index, service$index, price$index, unit$index, amount$index, productid$index";
    $boiDetail[] = "BOI$index";
    
    $item = explode("-", $service);
    
    $itemDetail = $invoice->getProduct($item[0]);
    
    $boi = ($itemDetail[BOI] == "NB") ? "Non-BOI" : "BOI";
    $note = $noteItem[$key];
    $price = $_POST[price][$key];
    $unit = $_POST[unit][$key];
    $amount = $_POST[amount][$key];
    
    $sqlValueDetail[] = "'$index', '$note', '$price', '$unit', '$amount', '$item[0]'";
    $boiQuery[] = "'$boi'";
}

$sql = "$sqlRow, " . implode(",", $sqlDetail) . ") $sqlValue," . implode(",", $sqlValueDetail) . ");";

if(!$invoice->invoiceQuery($sql)){
    echo "ERROR !!";
}

$issue = new DateTime("now");
$issue = $issue->format("Y-m-d H:i:s");

$sql = "INSERT INTO ready_office_clearing_info
        (date, CustomerID, qid, CustomerType, BusinessType, withholding_tax, netAmount, qno, ".implode(",", $boiDetail).")
        VALUES
        ('$issue','$_POST[cusID]','$_POST[qno]','$_POST[customer_type]','$_POST[business_type]',
        '$_POST[withholdingTax]','$_POST[netAmount]','$_POST[qno]', ".implode(",", $boiQuery).");";

if($invoice->invoiceQuery($sql)){
    echo "Success";
}else{
    echo "ERROR !!";
}
?>

