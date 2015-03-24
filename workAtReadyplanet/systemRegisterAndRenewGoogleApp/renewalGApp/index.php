<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<?php
include ("inc_dbconnect.php");
include ("../grandadmin/inc_load_server_config.php"); //load server config

$handledb = mysql_pconnect($rphost,$rpuser,$rppasswd);

// Set current date
$datetime = date("YmdHis");
$current_date = date( "Y-m-d"); //ดึงวันที่ปัจจุบัน

$totalrenew_today = 0;  //จำนวนรายการทั้งหมดที่ตรวจสอบเจอในรอบวันนี้
$totalrenew_newly = 0;  //จำนวนรายการทั้งหมดที่มีการบันทึกเข้าสู่ระบบในรอบนี้
$total_sendmail = 0;

$totalthnic_today = 0;
$totalthnic_newly = 0;
$total_sendmailthnic = 0;

$totalSpace_today = 0;
$totalSpace_newly = 0; 
$total_sendmailSpace = 0;

$totalrenew_velaeasy_today = 0;  
$totalrenew_velaeasy_newly = 0;  
$total_velaeasy_sendmail = 0; 

$num_popmail_found = 0;
$num_popmail_add = 0;
$num_popmail_sendmail = 0;

$num_host_found = 0;
$num_host_add = 0;
$num_host_sendmail = 0;

$num_gapp_found = 0;
$num_gapp_add = 0;
$num_gapp_sendmail = 0;

$datesetting = date("Y-m-d"); 		//ตัวแปรดึงวันที่ปัจจุบันมาใช้งาน ซึ่งสามารถมากำหนดค่าวันที่ที่ต้องการให้ทำงานแบบย้อนหลังได้ เช่น $datesetting = "2007-07-11";

$datesettingarr = explode("-",$datesetting);
$daynow = $datesettingarr[2];
$monthnow = $datesettingarr[1];
$yearnow = $datesettingarr[0];

//------------------------------------------Website And Popmail Part------------------------------------------//

print "<h2>Website being expired at $datesetting</h2>";
for ($index_no = 0; $index_no < count($arr_serverhost); $index_no++) {
	
	print "<h2>Server : $arr_servershow[$index_no]</h2>";
	print"<table style='border-collapse:collapse;border-color:#cccccc;' cellspacing='0' cellpadding='5' width = '100%' align = 'center' border = '1'>";
	print"<tr align = 'center' style = 'background-color:#ECE9D8;font-weight:bold'>";
	print"<td>Domain</td>";
	print"<td>Applied Date</td>";
	print"<td>Expired Date</td>";
	print"<td>Package</td>";
	print"<td>Price</td>";
	print"<td>FirstName</td>";
	print"<td>LastName</td>";
	print"<td>Email</td>";
	print"<td>Status</td>";
	print"<td>Remark</td>";
	print"</tr>";

	$arr = array(90,60,30,15,7);
	$carr = count($arr);
	for ($ck=0 ; $ck<$carr ; $ck++) {
		$handlemain = mysql_pconnect($arr_serverhost[$index_no],$arr_serveruser[$index_no],$arr_serverpasswd[$index_no]);
		$use_database = $arr_serverdbname[$index_no];		
		print "<tr style = 'background-color:#ECE9D8'><td colspan = '10'><b>Being expired within $arr[$ck] days </b></tr>";
		if ($arr[$ck] == '30') {
			for ($arr[$ck]=26 ; $arr[$ck]<=30 ; $arr[$ck]++) {
				$future_date  = date("Y-m-d", mktime (0,0,0,$monthnow, $daynow+$arr[$ck], $yearnow) );
				print"<tr><td colspan = '10'>$future_date</td></tr>";
				include ("func_query.php");
				include ("func_query_popmail.php");
				include ("func_query_hosting_new.php");
				include ("func_query_thnic.php");
				
			}
		} elseif ($arr[$ck] == '15') {
			for ($arr[$ck]=11 ; $arr[$ck]<=15 ; $arr[$ck]++) {
				$future_date  = date("Y-m-d", mktime (0,0,0,$monthnow, $daynow+$arr[$ck], $yearnow) );
				print"<tr><td colspan = '10'>$future_date</td></tr>";
				include ("func_query.php");
				include ("func_query_popmail.php");
				include ("func_query_hosting_new.php");
				include ("func_query_thnic.php");
				
			}
		} elseif ($arr[$ck] == '7') {
			for ($arr[$ck]=3 ; $arr[$ck]<=7 ; $arr[$ck]++) {
				$future_date  = date("Y-m-d", mktime (0,0,0,$monthnow, $daynow+$arr[$ck], $yearnow) );
				print"<tr><td colspan = '10'>$future_date</td></tr>";
				include ("func_query.php");
				include ("func_query_popmail.php");
				include ("func_query_hosting_new.php");
				include ("func_query_thnic.php");
			}
		} elseif ($arr[$ck] == '90') {//เช็คที่ 3 เดือนเพื่อดูเว็บที่ต้องต่ออายุ ล่วงหน้า
			for($arr[$ck]=75; $arr[$ck]<=90; $arr[$ck]++){
				$future_date  = date("Y-m-d", mktime (0,0,0,$monthnow, $daynow+$arr[$ck], $yearnow) );
				print"<tr><td colspan = '10'>$future_date</td></tr>";
				include ("func_query.php");
				include ("func_query_popmail.php");
				include ("func_query_hosting_new.php");
	   			include ("func_query_thnic.php");
				
			}
		} elseif ($arr[$ck] == '60') {
			for ($arr[$ck]=1 ; $arr[$ck]<=60 ; $arr[$ck]++) {
				$future_date  = date("Y-m-d", mktime (0,0,0,$monthnow, $daynow+$arr[$ck], $yearnow) );
				print"<tr><td colspan = '10'>$future_date</td></tr>";
				include ("func_query.php");
				include ("func_query_popmail.php");
				include ("func_query_hosting_new.php");
				include ("func_query_thnic.php");
			}
		}		
	}
	$sql_log = mysql_db_query($rpdbname,"insert into  log_renew_auto (no,datetime,server,status) values ('','$datetime','$arr_servershow[$index_no]','success')",$handledb);
	print"</table><br><hr style = 'border:1px;border-style:solid'>";
	sleep(2);
}

print "<br><br>";
print "website จำนวนรายการที่พบ $totalrenew_today รายการ<br>";
print "website จำนวนรายการที่บันทึก $totalrenew_newly รายการ<br>";
print "website จำนวนรายการที่ส่งเมล $total_sendmail รายการ<br><br>";

print "pop mail จำนวนรายการที่พบ $num_popmail_found รายการ<br>";
print "pop mail จำนวนรายการที่บันทึก $num_popmail_add รายการ<br>";
print "pop mail จำนวนรายการที่ส่งเมล $num_popmail_sendmail รายการ<br><br>";

print "Hosting รายการที่พบ $num_host_found รายการ<br>";
print "Hosting รายการที่บันทึกเข้าระบบ  $num_host_add รายการ<br>";
print "Hosting รายการที่ส่งเมล์  $num_host_sendmail รายการ<br><br>";

print "Thnic รายการที่พบ $totalthnic_today รายการ<br>";
print "Thnic รายการที่บันทึกเข้าระบบ  $totalthnic_newly รายการ<br>";
print "Thnic รายการที่ส่งเมล์  $total_sendmailthnic รายการ<br><br>";

print "Space รายการที่พบ $totalSpace_today รายการ<br>";
print "Space รายการที่บันทึกเข้าระบบ  $totalSpace_newly รายการ<br>";
print "Space รายการที่ส่งเมล์  $total_sendmailSpace รายการ<br><br>";

print "website จำนวนรายการที่พบ $totalrenew_velaeasy_today รายการ<br>";
print "website จำนวนรายการที่บันทึก $totalrenew_velaeasy_newly รายการ<br>";
print "website จำนวนรายการที่ส่งเมล $total_velaeasy_sendmail รายการ<br><br>";

print "GoogleApp จำนวนรายการที่พบ $num_gapp_found รายการ<br>";
print "GoogleApp จำนวนรายการที่บันทึก $num_gapp_add รายการ<br>";
print "GoogleApp จำนวนรายการที่ส่งเมล $num_gapp_sendmail รายการ<br><br>";
?>