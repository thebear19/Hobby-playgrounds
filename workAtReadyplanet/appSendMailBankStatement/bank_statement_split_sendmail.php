<?php
session_start();
include("inc_dbconnect.php");
require("class.phpmailer.php");
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

$subject = "��ᵡ�ʹ�Թ�͹��Һѭ�� �.$bankS �ѹ��� $data";
$body = "���ͧ�ҡ�١��Ҫ������ʹ�Թ��� $amount �ҷ ��ҹ<br/><br/>
    ��Ҥ�� : $bank<br/><br/>
    ��ͧ�ҧ : $payment_by $refno<br/><br/>
    �ѹ��� : $data <br/><br/>
    ��������´�ͧ�����ʹ�Թ����ͧ������ᵡ :<br/>
    $detail<br/><br/><br/>$admin_name";

$mail = new PHPMailer();
$mail->IsSMTP();                                     
$mail->CharSet = "tis-620";
$mail->From = $admin_email;
$mail->FromName = $admin_email;

$mail->AddAddress("thanchanid@readyplanet.com");

$mail->AddCC("saipin@readyplanet.com");
$mail->AddCC("jutamas@readyplanet.com");
$mail->AddCC($admin_email);

$mail->AddBCC("readylog@readyplanet.com");

$mail->IsHTML(true); 
$mail->Subject = $subject;
$mail->Body = $body;

if($mail->Send()){
    $sql = "INSERT INTO log_bank_statement_split (ID, sender, reciever, sendDate, detail) VALUES ('', '$admin_email', 'sirikan@readyplanet.com', now(), '$body')";
    mysql_db_query($dbname, $sql);
    echo 'Message has been sent';
}else{
    echo 'Message could not be sent.';
    echo 'Error: ' . $mail->ErrorInfo;
}
?>