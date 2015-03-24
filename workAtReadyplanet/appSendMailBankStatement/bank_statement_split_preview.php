<?php
session_start();
include("inc_dbconnect.php");
header('Content-Type: text/html; charset=TIS-620');

$admin_email = mysql_fetch_array(mysql_db_query($dbname, "SELECT admin_email FROM ready_office_admin WHERE admin_id = $admin_id"));
$admin_email = $admin_email[admin_email];

$date = new DateTime($_POST[input][0]);
$date->add(new DateInterval("P0543-00-00T00:00:00"));//ค.ศ. -> พ.ศ.
$data = $date->format('d/m/Y');// แสดงผล วัน/เดือน/ปี

$amount = number_format($_POST[input][1],2,'.',',');//เติม , เมื่อเงินมากกว่า1k และใส่ . ทศนิยม

$bank = $_POST[input][2];
$query = mysql_db_query($dbname, "SELECT * FROM ready_account_bank WHERE bank_name = '$bank'");
$result = mysql_fetch_array($query);
$bankS = "$result[bank_description]";
$bank = "$result[bank_description] $result[bank_name]";

$payment_by = $_POST[input][3];
$query = mysql_db_query($dbname, "SELECT * FROM ready_account_payment WHERE pay_id = $payment_by");
$result = mysql_fetch_array($query);
$payment_by = "$result[payment_by]";

$refno = ($_POST[input][4] != '') ? "(".$_POST[input][4].")" : "" ;

$detail = iconv("UTF-8", "TIS-620", $_POST[input][5]);// UTF-8 -> TIS-620
$detail = str_replace(" ",'&nbsp;',$detail);// spacebar -> &nbsp;
$detail = nl2br($detail);// \n -> <br>
$detail = stripcslashes($detail);//เปลี่ยน \",\' -> ",'

echo "
    From : $admin_email<br/>
    To : thanchanid@readyplanet.com<br/>
    Cc : saipin@readyplanet.com, jutamas@readyplanet.com, $admin_email<br/><br/><br/><br/>
    Subject : ขอแตกยอดเงินโอนเข้าบัญชี ธ.$bankS วันที่ $data <br/><br/>
    เนื่องจากลูกค้าชำระเป็นยอดเงินรวม $amount บาท ผ่าน<br/><br/>
    ธนาคาร : $bank<br/><br/>
    ช่องทาง : $payment_by $refno<br/><br/>
    วันที่ : $data <br/><br/>
    รายละเอียดของแต่ละยอดเงินที่ต้องการให้แตก :<br/>
    $detail<br/><br/><br/>$admin_name";
?>