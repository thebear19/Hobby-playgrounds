<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<?php
//ระบบตามต่ออายุ Google App เหมือน index.php แต่ แยกออกมาเนื่องจากบ้างส่วนไม่สามารถใช้ร่วมกันได้

include ("inc_dbconnect.php");

$handledb = mysql_pconnect($rphost, $rpuser, $rppasswd);

// Set current date
$datetime = date("YmdHis");
$current_date = date("Y-m-d"); //ดึงวันที่ปัจจุบัน

$num_gapp_found = 0;
$num_gapp_add = 0;
$num_gapp_sendmail = 0;

$datesetting = date("Y-m-d");   //ตัวแปรดึงวันที่ปัจจุบันมาใช้งาน ซึ่งสามารถมากำหนดค่าวันที่ที่ต้องการให้ทำงานแบบย้อนหลังได้ เช่น $datesetting = "2007-07-11";
//$datesetting = "2014-11-16";

$datesettingarr = explode("-", $datesetting);
$daynow = $datesettingarr[2];
$monthnow = $datesettingarr[1];
$yearnow = $datesettingarr[0];

//ดึงราคาสินค้า
$sql = "SELECT pro_price FROM ready_product WHERE pro_pcode = 'QA' ORDER BY pro_year ASC";
$result = mysql_db_query($rpdbname, $sql, $handledb);
while ($row = mysql_fetch_array($result)) {
    $renew_gapp[] = $row[pro_price];
}

$sql = "SELECT pro_price FROM ready_product WHERE pro_pcode = '57QA' ORDER BY pro_year ASC";
$result = mysql_db_query($rpdbname, $sql, $handledb);
while ($row = mysql_fetch_array($result)) {
    $renew_gapp57[] = $row[pro_price];
}

//------------------------------------------Renew Gapp Part------------------------------------------//

print "<h2>Google app being expired at $datesetting</h2>";
$index_no = 0;

print"<table style='border-collapse:collapse;border-color:#cccccc;' cellspacing='0' cellpadding='5' width = '100%' align = 'center' border = '1'>
	<tr align = 'center' style = 'background-color:#ECE9D8;font-weight:bold'>
            <td>Domain</td>
            <td>Applied Date</td>
            <td>Expired Date</td>
            <td>Package</td>
            <td>Price</td>
            <td>FirstName</td>
            <td>LastName</td>
            <td>Email</td>
            <td>Status</td>
            <td>Remark</td>
	</tr>";

$arr = array(7, 15, 30, 60, 90); //ตามต่ออายุทุกๆ 7 15 30 60 90 วัน
$start = array(3, 11, 26, 1, 75);
$end = array(7, 15, 30, 60, 90);

$carr = count($arr);

for ($ck = 0; $ck < $carr; $ck++) {
    print "<tr style = 'background-color:#ECE9D8'><td colspan = '10'><b>Being expired within $arr[$ck] days </b></tr>";
    
    for ($arr[$ck] = $start[$ck]; $arr[$ck] <= $end[$ck]; $arr[$ck] ++) {
        
        $future_date = date("Y-m-d", mktime(0, 0, 0, $monthnow, $daynow + $arr[$ck], $yearnow));
        print"<tr><td colspan = '10'>$future_date</td></tr>";
        include ("func_gapp.php");
    }
}

print"</table><br><hr style = 'border:1px;border-style:solid'>";
sleep(2);

print "GoogleApp จำนวนรายการที่พบ $num_gapp_found รายการ<br>
        GoogleApp จำนวนรายการที่บันทึก $num_gapp_add รายการ<br>
        GoogleApp จำนวนรายการที่ส่งเมล $num_gapp_sendmail รายการ";
?>