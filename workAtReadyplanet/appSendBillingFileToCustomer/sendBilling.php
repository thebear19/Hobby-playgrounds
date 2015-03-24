<?php

session_start();
include("/home/dev01/2010_readyplanet_com/grandadmin/inc_dbconnectOOP_a23.php");
require("class.phpmailer.php");
header('Content-Type: text/html; charset=TIS-620');

$waitingPart = "/home/dev01/2010_readyplanet_com/grandadmin/billing_sendmail/outbox";
$completePart = "/home/dev01/2010_readyplanet_com/grandadmin/billing_sendmail/complete";
$errorPart = "/home/dev01/2010_readyplanet_com/grandadmin/billing_sendmail/error";
$logPart = "/home/dev01/2010_readyplanet_com/grandadmin/billing_sendmail/system/log";

$dateNow = new DateTime("now");
$logName = $dateNow->format("Y-m-d");
$dateNow = $dateNow->format("d/m/Y H:i:s");
$textReport = "=== $dateNow ===\r\n";

if ($handle = opendir($waitingPart)) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
            $fileName = explode(".", iconv("UTF-8", "TIS-620", $file));
            $fileName = reset($fileName);

            $sql = "SELECT a.tax_invoice, b.bill_email, b.bill_firstname, b.bill_lastname, b.bill_company
                    FROM ready_office_clearing a, ready_new_members b
                    WHERE a.tax_invoice = '$fileName' AND a.newmemberid = b.ID LIMIT 0 , 1;";

            $query = $dbConnect_libra->query($sql);

            if (!$query->num_rows) {
                $textReport .= "$fileName : THIS FILE DOES NOT MATCH THE DATABASE\r\n";
                rename("$waitingPart/$file", "$errorPart/$file");       //move file
                continue;
            }

            $row = $query->fetch_array();
            
            /*$contentMail = "เรียนคุณ $row[bill_firstname] $row[bill_lastname]<br/>
                    $row[bill_company]";*/
            $contentMail = "เรียน ท่านสมาชิก<br/><br/>
                    บริษัท เรดดี้แพลนเน็ต จำกัด ขอขอบคุณที่ท่านได้ใช้บริการของเรา<br/><br/>
                    บริษัทฯ ขอจัดส่งใบกำกับภาษี เลขที่ $row[tax_invoice] ตามเอกสารที่แนบมานี้<br/><br/>
                    ขอแสดงความนับถือ<br/>
                    บริษัท เรดดี้แพลนเน็ต จำกัด<br/><br/>
                    หากท่านต้องการสอบถามข้อมูลเพิ่มเติม กรุณาติดต่อ <a href='mailto:account@readyplanet.com' target='_top'>account@readyplanet.com</a>";

            if(sendMail($file, $row[bill_email], $waitingPart, $contentMail)){
                $textReport .= "$row[tax_invoice] : SEND COMPLETE\r\n";
                rename("$waitingPart/$file", "$completePart/$file");    //move file
            }else{
                $textReport .= "$row[tax_invoice] : SEND ERROR\r\n";
                rename("$waitingPart/$file", "$errorPart/$file");       //move file
            }
        }
    }
    $logHandle = fopen("$logPart/$logName.txt", "a");
    fwrite($logHandle, $textReport);
    fclose($logHandle);
    closedir($handle);
}

function sendMail($file, $receiver, $filePart, $contentMail) {
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->CharSet = "tis-620";
    
    $mail->From = "account@readyplanet.com";
    $mail->FromName = "account@readyplanet.com";

    $mail->addAddress($receiver);//$receiver

    $mail->addBCC("readylog@readyplanet.com");
    //$mail->addBCC("chatchawan@readyplanet.com");
    $mail->addBCC("account@readyplanet.com");
    $mail->addBCC("janisara@readyplanet.com");
    
    $mail->addAttachment("$filePart/$file");

    $mail->IsHTML(true);
    $mail->Subject = "จัดส่งใบกำกับภาษี";
    $mail->Body = $contentMail;

    if ($mail->Send()) {
        return TRUE;
    } else {
        return FALSE;
    }
}

?>