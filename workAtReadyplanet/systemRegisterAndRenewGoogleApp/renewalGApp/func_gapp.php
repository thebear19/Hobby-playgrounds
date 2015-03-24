<?php

if ($exp_date != "")
    $future_date = $exp_date;

$handledb = mysql_pconnect($rphost, $rpuser, $rppasswd);

//เช็ค gapp ที่หมดอายุในวันนั้นๆ ที่ยังไม่ดำเนินการต่ออายุ status =0 (=1 กำลังต่อ, =0 ปกติ)
$sql = "SELECT *
        FROM ready_googleapp
        WHERE status = 0 && DATEDIFF (readyEndDate, '$future_date') = 0";

$rsGa = mysql_db_query($rpdbname, $sql, $handledb);
$NRow = mysql_num_rows($rsGa);

$checkY = 2015;

if ($NRow != 0) {
    while ($row = mysql_fetch_array($rsGa)) {
        //เช็ค sever ที่ gapp อยู่
        $domain = str_replace('.', '', $row[domain]); // ex.  abc.com -> abccom
        
        //ดึงข้อมูลสำหรับแสดงผล
        $cd = new DateTime($row[googleEndDate]);//$row[createDate]
        $cd = $cd->format('Y');

        //โดเมนที่หมดอายุหลังปี 2015 จะใช้ราคาใหม่
        $renew_gapp_1y = ($cd < $checkY) ? $renew_gapp[0] * $row[numSeats] : $renew_gapp57[0] * $row[numSeats];
        $renew_gapp_2y = ($cd < $checkY) ? $renew_gapp[1] * $row[numSeats] : $renew_gapp57[1] * $row[numSeats];
        $renew_gapp_3y = ($cd < $checkY) ? $renew_gapp[2] * $row[numSeats] : $renew_gapp57[2] * $row[numSeats];
        $Product_Description = ($cd < $checkY) ? "QA" : "57QA";

        $applied_date = new DateTime($row[createDate]);
        $applied_date = $applied_date->format('Y-m-d');
        $expired_date = new DateTime($row[readyEndDate]);
        $expired_date = $expired_date->format('Y-m-d');

        $sql = "SELECT * FROM ready_new_members WHERE DomainName LIKE '$row[domain]' ORDER BY ID DESC LIMIT 0 , 1";
        $query = mysql_db_query($rpdbname, $sql, $handledb);
        $detail = mysql_fetch_array($query);

        //เช็ค รายการ renew ว่ามีการสร้างแล้วหรือยัง
        $recordS = "SELECT ID
                    FROM ready_new_members 
                    WHERE  DomainName='$row[domain]' AND ExpiredDate='$future_date'
                    AND typedomain LIKE 'Renew%' AND Product_Description='$Product_Description'  ";

        $recordQ = mysql_db_query($rpdbname, $recordS, $handledb);
        $recordN = mysql_num_rows($recordQ);

        if ($recordN == 0) {
            $sql = "INSERT INTO ready_new_members
                    (ID,Datetime,AppliedDate,ExpiredDate,DomainName,DomainNameNoDot,typedomain,Password,Product,Product_Description,
                    RegisYear,Price,FirstName,LastName,Organization,Email,Address,Province,Country,ZipCode,Phone,Fax,Survey,bill_firstname,
                    bill_lastname,bill_company,bill_email,bill_address,bill_province,bill_country,bill_zip,bill_phone,bill_fax,referid,status,
                    product_code,Email2,CustomerID,office_phone,office_phone2,mobile_phone,mobile_phone2,bill_office_phone,bill_office_phone2,
                    bill_mobile_phone,bill_mobile_phone2,product_type,Sponsor,Remark,secondarySaleName)
                    VALUES
                    ('', '$datetime', '$applied_date', '$expired_date', '$row[domain]', '$domain', 'Renew - www.$row[domain]', 'RenewGapp', 'AutoAdd', '$Product_Description'
                    , '1', '$renew_gapp_1y', '$detail[FirstName]', '$detail[LastName]', '$detail[Organization]', '$detail[Email]', '$detail[Address]', '$detail[Province]', '$detail[Country]', '$detail[ZipCode]', '$detail[Phone]', '$detail[Fax]', '$detail[Survey]', '$detail[bill_firstname]',
                    '$detail[bill_lastname]', '$detail[bill_company]', '$detail[bill_email]', '$detail[bill_address]', '$detail[bill_province]', '$detail[bill_country]', '$detail[bill_zip]', '$detail[bill_phone]', '$detail[bill_fax]', 'autorenew', '1',
                    '999', '$detail[Email2]', '$detail[CustomerID]','$detail[office_phone]','$detail[office_phone2]','$detail[mobile_phone]','$detail[mobile_phone2]','$detail[bill_office_phone]','$detail[bill_office_phone2]',
                    '$detail[bill_mobile_phone]','$detail[bill_mobile_phone2]','-2','','','');";

            mysql_db_query($rpdbname,$sql,$handledb) or die(mysql_error());

            $newid = mysql_insert_id();
            $time = time();

            $sql = "INSERT INTO ready_customer_detail
                    (CustomerID, timestamp, FirstName, LastName, Organization, Email, Address, Province, Country, ZipCode, Phone, Fax, bill_firstname
                    , bill_lastname, bill_company, bill_email, bill_address, bill_province, bill_country, bill_zip, bill_phone, bill_fax, Email2
                    , currentWebsiteName, Datetime,office_phone,office_phone2,mobile_phone,mobile_phone2,bill_office_phone,bill_office_phone2,bill_mobile_phone
                    , bill_mobile_phone2)
                    VALUES
                    ('$detail[CustomerID]', '$time', '$detail[FirstName]', '$detail[LastName]', '$detail[Organization]','$detail[Email]', '$detail[Address]','$detail[Province]','$detail[Country]', '$detail[ZipCode]','$detail[Phone]','$detail[Fax]','$detail[bill_firstname]'
                    ,'$detail[bill_lastname]', '$detail[bill_company]','$detail[bill_email]','$detail[bill_address]', '$detail[bill_province]','$detail[bill_country]','$detail[bill_zip]','$detail[bill_phone]','$detail[bill_fax]','$detail[Email2]'
                    ,'$row[domain]','$datetime', '$detail[office_phone]','$detail[office_phone2]','$detail[mobile_phone]','$detail[mobile_phone2]','$detail[bill_office_phone]','$detail[bill_office_phone2]','$detail[bill_mobile_phone]','$detail[bill_mobile_phone2]');";

            mysql_db_query($rpdbname,$sql,$handledb) or die(mysql_error());

            include("inc_check_random_renew.php"); //insert renew lis to support//
            
            //--add to ready_new_members_detail--//
            $seProduct = "SELECT * FROM ready_product WHERE pro_pcode_single = '$Product_Description' AND pro_year = '1';";
            $qrProduct = mysql_db_query($rpdbname, $seProduct, $handledb);
            $reProduct = mysql_fetch_array($qrProduct);
            $product_id = $reProduct[pid];
            $product_name = $reProduct[pname];

            //get Sale ID
            $seSale = "SELECT Sale FROM ready_customer_id WHERE CustomerID = '$detail[CustomerID]';";
            $qrSale = mysql_db_query($rpdbname, $seSale, $handledb);
            $reSale = mysql_fetch_array($qrSale);
            $sale_id = $reSale[Sale];

            //get from inc_check_random_renew.php
            $owner_id = $reSaleID[admin_id];

            $sql = "INSERT INTO ready_new_members_detail 
                    (id, ready_new_members_id, clearing_date, ready_new_members_AppliedDate,
                    ready_new_members_ExpiredDate, ready_new_members_DomainName, ready_new_members_DomainNameNoDot, ready_new_members_Product,
                    ready_new_members_Product_Description, ready_new_members_Price, price_decimal, price_decimal1,
                    ready_office_clearing_amount, ready_new_members_product_code, ready_new_members_count, ready_product_pid,
                    ready_product_pname, ready_product_pro_pcode, clearing_user, sale_id,
                    owner_id, status, quantity)
                    VALUES
                    ('', '$newid', '', '$applied_date',
                    '$expired_date', '$row[domain]', '$domain', 'AutoAdd',
                    '$Product_Description', '$renew_gapp_1y' ,'$renew_gapp_1y', '$renew_gapp_1y',
                    '0', '$Product_Description', '1', '$product_id',
                    '$product_name', '$product_code', '', '$sale_id',
                    '$owner_id', 'new', '1');";

            mysql_db_query($rpdbname,$sql,$handledb) or die(mysql_error());

            $num_gapp_add++;
        }

        //--Send Mail
        if (($arr[$ck] == '60' || $arr[$ck] == '30' || $arr[$ck] == '15' || $arr[$ck] == '7') && !in_array($row[domain], $mailSent)) {
            include("config_mail_renew.php");
            for ($n_bcc_mail = 0; $n_bcc_mail < count($ccaddress); $n_bcc_mail++) {
                if ($n_bcc_mail == 0) {
                    $bcc_address = $ccaddress[$n_bcc_mail];
                } else {
                    $bcc_address .= "," . $ccaddress[$n_bcc_mail];
                }
            }
            include ("msg_gapp.php");

            $headers = "From: info@readyplanet.com\n";
            $headers .= "Content-Type: text/html; charset=windows-874\n";
            $headers .= "Bcc: readylog@readyplanet.com,$bcc_address\n";

            //$detail[Email] = receiver
            mail($detail[Email], "Your Google Apps for Business service of $row[domain] are being expired within $arr[$ck] days.", $messageweb, $headers, "-finfo@readyplanet.com");
            
            //insert log mail renew
            $input_date = date("Y-m-d H:i:s");
            $mail_type = "GoogleApp";
            $sql = "INSERT INTO log_mail_renew ( id, date, account, domain,
                    expdate, package, type, duration, email )
                    VALUES ('','$input_date','$domain','$row[domain]',
                    '$expired_date','','$mail_type','$arr[$ck]','$detail[Email]' );";

            mysql_db_query($rpdbname, $sql, $handledb);
            $num_gapp_sendmail++;
            
            $mailSent[] = $row[domain]; //เก็บโดเมนที่ทำการส่งเมลเรียบร้อยแล้ว
        }

        echo "<tr>
                <td>$row[domain]</td>
                <td>$applied_date</td>
                <td>$expired_date</td>
                <td style = 'background-color:#FDFCDA'>GoogleApp</td>
                <td>$renew_gapp_1y / $renew_gapp_2y / $renew_gapp_3y</td>
                <td>$detail[FirstName]</td>
                <td>$detail[LastName]</td>
                <td>$detail[Email]</td>
                <td>$arr[$ck]</td>
                <td>-</td>
            </tr>";

        $num_gapp_found++;
    }
}
?>