<?php

/* ระบบต่ออายุอัตโนมัติ
 * 1. เช็คโดเมนที่สมัครใช้บริการมากกว่า 1 ปี เพื่อส่งคำร้องไปทาง google ว่าพอถึงวันหมดอายุให้ทำการต่ออายุทันที
 *    พอ google ดำเนินการเสร็จสิ้นจะส่งคำร้องเพื่อยกเลิกคำขอข้างต้น
 * 2. ยกเลิกคำขอโดเมนที่ดำเนินการต่ออายุเรียบร้อยแล้วทั้งหมดแต่ยังไม่ได้ยกเลิกคำร้อง
 * 3. ส่งเมลถึงลูกค้า กรณี manual
 * 
 * ปล. Auto = โดเมนในระบบหมดอายุ แต่สัญญากับทางลูกค้ายังไม่หมด เช่น ลูกค้าขอซื้อ 3 ปี แต่โดเมนมีอายุแค่ 1ปี
 *     Manual = โดเมนหมดอายุ ลูกค้าขอซื้อบริการต่อ
 */
include "/home/dev01/2010_readyplanet_com/grandadmin/googleApp/resellerFunction.php";
header('Content-Type: text/html; charset=UTF-8');

$service = new Google_Service_Reseller($client);

// retrive all domain for checking
$response = subscriptionList(1);

$autoR = 0; //num auto renewal
$autoRC = 0; //num done renewal
$manR = 0; //num manual renewal
$sup = 0; //num suspend

foreach ($response as $data) {
    // retirve all data each domain
    $sql = "SELECT * FROM ready_googleapp WHERE domain = '$data->customerId';";
    $query = mysql_db_query($dbname, $sql);
    $row = mysql_fetch_array($query);
    
    if(mysql_num_rows($query) == 0){continue;}
    
    //syc:  ready db <- google db
    $sql = "UPDATE ready_googleapp SET numSeats = '".$data->seats->numberOfSeats."' WHERE domain = '$row[domain]';";
    mysql_db_query($dbname, $sql);
    
    //check googleEnd - now() < 1 month && readyEnd - now() >  1 year
    $durationGoogle = strtotime($row[googleEndDate]) - time();
    $durationReady = strtotime($row[readyEndDate]) - time();
    
    
    if ($durationGoogle <= 2629743 && $durationGoogle > 0 && $durationReady >= 31556926) {
        if($data->renewalSettings->renewalType == "AUTO_RENEW" || $data->renewalSettings->renewalType == "AUTO_RENEW_MONTHLY_PAY"){continue;}
        
        $service->subscriptions->changeRenewalSettings($data->customerId, $data->subscriptionId, getRenewal(true));
        $autoR++;
    }
    elseif ($data->renewalSettings->renewalType != 'SWITCH_TO_PAY_AS_YOU_GO' && $data->plan->planName != "FLEXIBLE" && $durationGoogle <= 0) {
        //ถ้าต่ออายุเรียบร้อยแล้ว ทำการยกเลิกการต่ออายุ (ป้องกันการต่ออายุเกิน)
        
        $re = $service->subscriptions->changeRenewalSettings($data->customerId, $data->subscriptionId, getRenewal(false));

        
        //cal EndDate
        $googleEndDate = $re->plan->commitmentInterval->endTime;
        if ($row[numYears] > 1) {
            $readyEndDate = $googleEndDate + (31556926000 * ($row[numYears] - 1));
        } else {
            $readyEndDate = $googleEndDate;
        }
        $readyEndDate = epochToDate($readyEndDate);
        $googleEndDate = epochToDate($googleEndDate);

        
        //create query, count and sendmail
        $sql = "UPDATE ready_googleapp SET googleEndDate = '$googleEndDate', status = '0' ";
        if (strtotime($row[readyEndDate]) > time()) {
            //ยกเลิกกรณีลูกค้าซื้อมากกว่า 1 year
            
            $sql .= "WHERE domain = '$row[domain]';";
            $autoRC++;
        } else {
            //ยกเลิกกรณีทีม renewal ส่งคำร้องมา (สัญญาเก่าหมดอายุ และลูกค้าต้องการต่ออายุเพิ่ม)
            
            $sql .= ", readyEndDate = '$readyEndDate' WHERE domain = '$row[domain]';";
            
            $sentmailSql = "SELECT Email FROM ready_new_members WHERE DomainName LIKE '$row[domain]' ORDER BY ID DESC LIMIT 0 , 1";
            $sentmailQuery = mysql_db_query($dbname, $sentmailSql);
            $sentmailRow = mysql_fetch_array($sentmailQuery);
            
            $row[readyEndDate] = $readyEndDate;
            $msgBody = sendMailBody($row);
            
            $msgHead = sendMailHead();

            //$sentmailRow[Email] = receiver
            mail($sentmailRow[Email], "READYPLANET Google Apps for Business Renewal - $row[domain]", $msgBody, $msgHead, "-finfo@readyplanet.com");
            
            //save sent mail log
            $input_date = date("Y-m-d H:i:s");
            $mail_type = "GoogleApp - Renewed";
            $account = str_replace('.', '', $row[domain]);
            
            $logMailSql = "INSERT INTO log_mail_renew (date, account, domain, expdate, package, type, email)
                    VALUES ('$input_date', '$account', '$row[domain]',
                    '$row[readyEndDate]', '', '$mail_type', '$sentmailRow[Email]');";
            mysql_db_query($dbname, $logMailSql);
            
            $manR ++;
        }
        mysql_db_query($dbname, $sql);
    }
    elseif ($durationReady <= 0 && $data->status == "ACTIVE" && $data->plan->planName == "FLEXIBLE"){
        //แจ้งระงับลูกค้าที่หมดสัญญา เพื่อให้ทาง google หยุดคิดเงิน
        
        $service->subscriptions->suspend($data->customerId, $data->subscriptionId);
        $sup ++;
    }
}

savelogToday($autoR, $autoRC, $manR, $sup);
?>

