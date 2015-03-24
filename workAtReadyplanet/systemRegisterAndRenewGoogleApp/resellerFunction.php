<?php

session_start();
include "connectAPI.php";
include "/home/dev01/2010_readyplanet_com/grandadmin/inc_dbconnect.php";


function subscriptionList($token) {
    if ($token == NULL) {
        return array();
    } elseif ($token == 1) {
        $response = $GLOBALS['service']->subscriptions->listSubscriptions(array("maxResults" => 100));
        return array_merge($response->subscriptions, subscriptionList($response->nextPageToken));
    } else {
        $response = $GLOBALS['service']->subscriptions->listSubscriptions(array("maxResults" => 100, "pageToken" => $token));
        return array_merge($response->subscriptions, subscriptionList($response->nextPageToken));
    }
}


function createCustomer() {
    $customer = new Google_Service_Reseller_Customer();
    $customer->setKind("reseller#customer");
    $customer->setCustomerId($_POST['id']);
    $customer->setCustomerDomain($_POST['id']);

    $address = new Google_Service_Reseller_Address();
    $address->setKind("customers#address");
    $address->setContactName($_POST['name']);
    $address->setOrganizationName($_POST['orgName']);
    $address->setLocality($_POST['locality']);
    $address->setRegion($_POST['region']);
    $address->setPostalCode($_POST['postCode']);
    $address->setCountryCode($_POST['country']);
    $address->setAddressLine1($_POST['address']);

    $customer->setPostalAddress($address);
    $customer->setPhoneNumber($_POST['phone']);
    $customer->setAlternateEmail($_POST['altEmail']);

    return $customer;
}


function createSubscription() {
    $subscription = new Google_Service_Reseller_Subscription();
    $subscription->setKind("reseller#subscription");
    $subscription->setSkuId("Google-Apps-For-Business");
    $subscription->setCustomerId($_POST['id']);

    $plan = new Google_Service_Reseller_SubscriptionPlan();
    $plan->setPlanName("TRIAL");

    $subscription->setPlan($plan);

    $subscription->setSeats(getSeats($_POST['maxSeat'], 1));

    return $subscription;
}


function updateSubscription($isflex) {
    $subscription = new Google_Service_Reseller_ChangePlanRequest();
    $subscription->setKind("reseller#changePlanRequest");
    $subscription->setPlanName("ANNUAL_MONTHLY_PAY"); //ANNUAL

    $subscription->setSeats(getSeats($_POST['maxSeat'], $isflex));

    return $subscription;
}


function getSeats($numSeat, $isflex) {
    $seat = new Google_Service_Reseller_Seats();
    $seat->setKind("subscriptons#seats");

    if ($isflex) {
        $seat->setMaximumNumberOfSeats($numSeat);
    } else {
        $seat->setNumberOfSeats($numSeat);
    }

    return $seat;
}


function getRenewal($isAuto) {
    $renewal = new Google_Service_Reseller_RenewalSettings();
    $renewal->setKind("subscriptions#renewalSettings");
    
    if ($isAuto) {
        $renewal->setRenewalType("AUTO_RENEW_MONTHLY_PAY");
    } else {
        $renewal->setRenewalType("SWITCH_TO_PAY_AS_YOU_GO");
    }

    return $renewal;
}


function getToken($domain) {
    $serviceToken = new Google_Service_SiteVerification($GLOBALS['client']);

    $site = new Google_Service_SiteVerification_SiteVerificationWebResourceGettokenRequestSite();
    $site->setType("INET_DOMAIN");
    $site->setIdentifier($domain);

    $domainToken = new Google_Service_SiteVerification_SiteVerificationWebResourceGettokenRequest();
    $domainToken->setSite($site);
    $domainToken->setVerificationMethod("DNS_TXT");

    return $serviceToken->webResource->getToken($domainToken);
}


function verifySite($domain) {
    $serviceToken = new Google_Service_SiteVerification($GLOBALS['client']);

    $site = new Google_Service_SiteVerification_SiteVerificationWebResourceResourceSite();
    $site->setType("INET_DOMAIN");
    $site->setIdentifier($domain);

    $domainToken = new Google_Service_SiteVerification_SiteVerificationWebResourceResource();
    $domainToken->setSite($site);

    return $serviceToken->webResource->insert("DNS_TXT", $domainToken);
}


function insertDB($createDate, $trialEndDate, $googleEndDate) {

    //คำนวณวันหมดอายุของลูกค้า โดยคิดจาก ปีที่หมดอายุของ G (G มีอายุแค่1ปีเท่านั้น)
    if ($_POST[year] > 1) {
        $readyEndDate = $trialEndDate + (31556926000 * $_POST[year]);
    } else {
        $readyEndDate = $googleEndDate;
    }

    //convert epoch format to datetime
    $createDate = epochToDate($createDate);
    $trialEndDate = epochToDate($trialEndDate);
    $readyEndDate = epochToDate($readyEndDate);
    $googleEndDate = epochToDate($googleEndDate);

    $sqlData = "INSERT INTO ready_googleapp (domain, numYears, numSeats, createDate, trialEndDate, googleEndDate, readyEndDate)"
            . "VALUES ('$_POST[id]', '$_POST[year]', '$_POST[maxSeat]', '$createDate', '$trialEndDate', '$googleEndDate', '$readyEndDate');";
    mysql_db_query("readyplanet_com", $sqlData) or die("ERROR DataBase");
}




function printDebug($input) {
    echo "<pre>";
    print_r($input);
    echo "</pre>";
}


function epochToDate($input) {
    if(empty($input)){
        return ;
    }
    
    $input = substr($input, 0, 10);
    $output = new DateTime("@$input");
    $tz = new DateTimeZone("Asia/Bangkok");
    $output->setTimezone($tz);
    return $output->format('Y-m-d H:i:s');
}




function sendMailHead() {
    $ccAddress = array("areesa@readyplanet.com","narisa@readyplanet.com","patcharee@readyplanet.com",
		"parichart@readyplanet.com","khomkhay@readyplanet.com","kornthip@readyplanet.com",
		"chatchawan@readyplanet.com");
    
    $bccAddress = implode(",", $ccAddress);
    
    return "From: info@readyplanet.com\nContent-Type: text/html; charset=UTF-8\nBcc: readylog@readyplanet.com,$bccAddress\n";
}

function sendMailBody($row) {
    $endDate = new DateTime($row[readyEndDate]);
    $endDate = $endDate->format("d/m/Y");
    
    return "เรียนท่านเจ้าของเว็บไซต์ $row[domain]<br/><br/>
            ทาง ReadyPlanet ได้ดำเนินการต่ออายุ<br/><br/>
            - Google Apps for Business<br/>
            &nbsp;เรียบร้อยแล้ว จำนวน $row[numYears] ปี<br/><br/>
            - วันหมดอายุ Google Apps for Business ครั้งถัดไป $endDate<br/><br/><br/>
            จึงเรียนมาเพื่อทราบ<br/><br/>
            หากมีข้อสงสัยประการใดโปรด ติดต่อ info@readyplanet.com<br/><br/>
            www.ReadyPlanet.com<br/>
            เว็บไซต์สำเร็จรูปแห่งแรกและใหญ่ที่สุดในประเทศไทย<br/><br/>
            ReadyPlanet Co., Ltd.<br/>
            202 Le Concorde Tower, 9th Floor, Room 903, Ratchadapisek Road, 
            Huaykwang, Huaykwang Bangkok 10310<br/>
            Tel. +66(0)2627-7900  24 ชั่วโมง ทุกวัน<br/>
            Fax +66(0)2627-7911";
}

function sendMailGapp($row) {
    $sentmailSql = "SELECT Email FROM ready_new_members WHERE DomainName LIKE '$row[domain]' ORDER BY ID DESC LIMIT 0 , 1";
    $sentmailQuery = mysql_db_query("readyplanet_com", $sentmailSql);
    $sentmailRow = mysql_fetch_array($sentmailQuery);
            
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
    mysql_db_query("readyplanet_com", $logMailSql);
}



function savelogToday($autoR, $autoRC, $manR, $sup) {
    $log = "Auto : ส่งคำร้องต่ออายุ $autoR รายการ\r\n".
           "Auto : ยกเลิกคำร้องต่ออายุ $autoRC รายการ\r\n".
           "Manual : ยกเลิกคำร้องต่ออายุ $manR รายการ\r\n\r\n".
           "Suspend : ระงับโดเมน $sup รายการ";
    
    file_put_contents('/home/dev01/2010_readyplanet_com/grandadmin/googleApp/log/log-GoogleRenewal-'.date("j-n-Y").'.txt', $log, FILE_APPEND);
}
?>