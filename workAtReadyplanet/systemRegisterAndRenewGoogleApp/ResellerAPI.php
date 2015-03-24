<?php
include "resellerFunction.php";

try {
    $service = new Google_Service_Reseller($client);


    if (isset($_POST['create'])) {
        //Create customer
        $response = $service->customers->insert(createCustomer());

        //Create subscript (ขอทดลองใช้ 30 วัน)
        $response = $service->subscriptions->insert($_POST['id'], createSubscription());

        //เลือกบริการ 1 ปี ชำระแบบรายเดือน
        $response = $service->subscriptions->changePlan($response->customerId, $response->subscriptionId, updateSubscription(0));

        //เก็บข้อมูลไว้สำหรับตามต่ออายุ ลงใน ready_googleapp
        insertDB($response->creationTime, $response->trialSettings->trialEndTime, $response->plan->commitmentInterval->endTime);

        //Get key for verify domain
        $responseToken = getToken($_POST['id']);
        $responseToken = $responseToken->token;
        $_SESSION['domainID'] = $_POST['id'];

        //check server and response link for set TXT CNAME MXmail in enom
        $results = "http://www.readyplanet.com/grandadmin/";
        if ($_POST['serverType'] != "a28") {
            $results .= "velaclassic_admin.php?account=$_POST[domainNoDot]&fullsizetotal=&txt=$responseToken#ESD";
        } else {
            $results .= "velaeasy_admin.php?account=$_POST[fullDomain]&txt=$responseToken#ESD";
        }

        echo json_encode(array('results' => $results));
    } elseif (isset($_POST['verify'])) {
        //waiting after set enom (รอข้อมูลทาง enom อัพเดท ไม่งั้นเวลายืนยันโดเมน ทาง google จะหา token ไม่เจอ)
        sleep(10);

        $response = verifySite($_SESSION['domainID']);
        unset($_SESSION['domainID']);

        echo json_encode(array('results' => "success"));
    } elseif (isset($_POST['renew'])) {
        $sql = "SELECT * FROM ready_googleapp WHERE domain = '$_POST[domain]'";
        
        $query = mysql_db_query("readyplanet_com", $sql);
        $row = mysql_fetch_array($query);

        $response = $service->subscriptions->listSubscriptions(array("customerId" => $row[domain]));
        
        if($response->subscriptions[0]->status != "ACTIVE"){
            $service->subscriptions->activate($response->subscriptions[0]->customerId, $response->subscriptions[0]->subscriptionId);
        }
        
        $_POST['maxSeat'] = ($_POST['isEdit']) ? $_POST['seats'] : $response->subscriptions[0]->seats->numberOfSeats;

        if (strtotime($row[readyEndDate]) - time() <= 0) {
            $response = $service->subscriptions->changePlan($row[domain], $response->subscriptions[0]->subscriptionId, updateSubscription(0));

            $googleEndDate = $response->plan->commitmentInterval->endTime;
            if ($_POST['year'] > 1) {
                $readyEndDate = $googleEndDate + (31556926000 * ($_POST['year'] - 1));
            } else {
                $readyEndDate = $googleEndDate;
            }

            $readyEndDate = epochToDate($readyEndDate);
            $googleEndDate = epochToDate($googleEndDate);

            
            $sql = "UPDATE ready_googleapp
                SET numYears = '$_POST[year]', numSeats = '$_POST[maxSeat]', googleEndDate = '$googleEndDate', readyEndDate = '$readyEndDate'
                WHERE domain = '$_POST[domain]'";
            
            
            $sendmailData[domain] = $_POST[domain];
            $sendmailData[numYears] = $_POST[year];
            $sendmailData[readyEndDate] = $readyEndDate;
            
            sendMailGapp($sendmailData);
            
        } else {
            //เช็คเงื่อนไขแบบนี้เพราะ ค่าที่ส่งมามองเป็น string ไม่ใช่ bool
            if ($_POST['isEdit'] == "true") {
                $service->subscriptions->changeSeats($row[domain], $response->subscriptions[0]->subscriptionId, getSeats($_POST['maxSeat'], 0));
            }
            
            $service->subscriptions->changeRenewalSettings($row[domain], $response->subscriptions[0]->subscriptionId, getRenewal(true));
            
            $sql = "UPDATE ready_googleapp
                SET numYears = '$_POST[year]', numSeats = '$_POST[maxSeat]', status = '1'
                WHERE domain = '$_POST[domain]'";
        }

        if (mysql_db_query("readyplanet_com", $sql)) {
            echo json_encode(array('results' => "success"));
        } else {
            echo json_encode(array('error' => array('message' => mysql_error())));
        }
    } elseif (isset($_POST['cancelRenew'])) {
        $sql = "SELECT * FROM ready_googleapp WHERE domain = '$_POST[domain]'";
        $query = mysql_db_query("readyplanet_com", $sql);
        $row = mysql_fetch_array($query);

        $response = $service->subscriptions->listSubscriptions(array("customerId" => $row[domain]));
        $service->subscriptions->changeRenewalSettings($row[domain], $response->subscriptions[0]->subscriptionId, getRenewal(false));

        $sql = "UPDATE ready_googleapp SET status = '0' WHERE domain = '$row[domain]';";

        if (mysql_db_query("readyplanet_com", $sql)) {
            echo json_encode(array('results' => "success"));
        } else {
            echo json_encode(array('error' => array('message' => mysql_error())));
        }
    }
} catch (Exception $e) {
    echo json_encode(array(
        'error' => array(
            'code' => $e->getCode(),
            'message' => $e->getMessage()
        )
    ));
}
?>