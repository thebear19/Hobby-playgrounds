<?php
session_start();
include("inc_dbconnect.php");
header('Content-Type: text/html; charset=TIS-620');

$admin_email = mysql_fetch_array(mysql_db_query($dbname, "SELECT admin_email FROM ready_office_admin WHERE admin_id = $admin_id"));
$admin_email = $admin_email[admin_email];

$date = new DateTime($_POST[input][0]);
$date->add(new DateInterval("P0543-00-00T00:00:00"));//�.�. -> �.�.
$data = $date->format('d/m/Y');// �ʴ��� �ѹ/��͹/��

$amount = number_format($_POST[input][1],2,'.',',');//��� , ������Թ�ҡ����1k ������ . �ȹ���

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
$detail = stripcslashes($detail);//����¹ \",\' -> ",'

echo "
    From : $admin_email<br/>
    To : thanchanid@readyplanet.com<br/>
    Cc : saipin@readyplanet.com, jutamas@readyplanet.com, $admin_email<br/><br/><br/><br/>
    Subject : ��ᵡ�ʹ�Թ�͹��Һѭ�� �.$bankS �ѹ��� $data <br/><br/>
    ���ͧ�ҡ�١��Ҫ������ʹ�Թ��� $amount �ҷ ��ҹ<br/><br/>
    ��Ҥ�� : $bank<br/><br/>
    ��ͧ�ҧ : $payment_by $refno<br/><br/>
    �ѹ��� : $data <br/><br/>
    ��������´�ͧ�����ʹ�Թ����ͧ������ᵡ :<br/>
    $detail<br/><br/><br/>$admin_name";
?>