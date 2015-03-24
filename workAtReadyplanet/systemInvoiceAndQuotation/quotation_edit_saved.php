<?php
session_start();
include("../inc_dbconnect.php");
include ("../quotation_sales_data_new.php");

include("invoice_db.php");
$invoice = new invoiceDB($dbname);

header('Content-Type: text/html; charset=TIS-620');

if(mysql_num_rows($invoice->invoiceQuery("SELECT * FROM ready_office_quotation WHERE qno = '';")) == 0){
    echo "This quotation cannot be found. :(";
    exit();
}

foreach ($_POST[itemNote] as $value) {
    $noteItem[] = $invoice->convertBigText($value);
}
unset($_POST[itemNote]);

$noteFooter = $invoice->convertBigText($_POST[note]);
unset($_POST[note]);

$_POST = $invoice->convertToTis($_POST);
$sp = ($_POST[companyID] == 1) ? "" : "Yes";//normal : spacial


$sqlClear = "UPDATE ready_office_clearing_info SET
        CustomerType = '$_POST[customer_type]',
        BusinessType = '$_POST[business_type]',
        withholding_tax = '$_POST[withholdingTax]',
        netAmount = '$_POST[netAmount]'";


$sqlQuo = "UPDATE ready_office_quotation SET
        validdate = '$_POST[validUntil]',
        creator = '$_POST[attention_sale]',
        creator_mobile = '$_POST[directLine]',
        creator_int_number = '$_POST[tel_ext]',
        attention = '$_POST[attention]',
        company = '$_POST[company]',
        addr = '$_POST[add]',
        province = '$_POST[province]',
        zip = '$_POST[zip]',
        tel = '$_POST[tel]',
        fax = '$_POST[fax]',
        totalprice = '$_POST[totalprice]',
        vatprice = '$_POST[vatprice]',
        nettotalprice = '$_POST[nettotalprice]',
        direct_line = '$_POST[directLine]',
        note_webpro = '$noteFooter',
        special = '$sp',
        monetary_type = '$_POST[monetary]',
        thaiword = '$_POST[thaiword]',
        percentVat = '$_POST[vatSp]',
        DomainName = '$_POST[domain]'";

$index = 1;

foreach ($_POST[service] as $key => $service) {
    if(empty($service)){
        continue;
    }
    
    $item = explode("-", $service);
    
    $itemDetail = $invoice->getProduct($item[0]);
    
    $boi = ($itemDetail[BOI] == "NB") ? "Non-BOI" : "BOI";
    $note = $noteItem[$key];
    $price = $_POST[price][$key];
    $unit = $_POST[unit][$key];
    $amount = $_POST[amount][$key];
    
    //'$itemDetail[pname]\n$note' ÊÓÃÍ§ serviceà¾×èÍá¡é
    $sqlDetailQuo[] = "item$index = '$index',
        service$index = '$note',
        price$index = '$price',
        unit$index = '$unit',
        amount$index = '$amount',
        productid$index = '$item[0]'
    ";
    
    $sqlDetailClear[] = "BOI$index = '$boi'";
    
    $index++;
}

foreach ($_POST[service] as $key => $service) {
    if(empty($service)){
        $sqlDetailQuo[] = "item$index = NULL,
            service$index = NULL,
            price$index = NULL,
            unit$index = NULL,
            amount$index = NULL,
            productid$index = NULL
        ";
    
        $sqlDetailClear[] = "BOI$index = ''";
        
        $index++;
    }
}


if (!empty($sqlDetailClear) && !empty($sqlDetailQuo)) {
    $sqlQuo .= "," . implode(",", $sqlDetailQuo) . " WHERE qno = '$_POST[qno]';";

    $sqlClear .= "," . implode(",", $sqlDetailClear) . " WHERE qid = '$_POST[qno]';";

    $invoice->invoiceQuery($sqlQuo);
    $invoice->invoiceQuery($sqlClear);

    echo "Success";
} else {
    echo "ERROR !!";
}
?>

