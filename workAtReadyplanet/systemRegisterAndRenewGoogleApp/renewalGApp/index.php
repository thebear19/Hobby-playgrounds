<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<?php
include ("inc_dbconnect.php");
include ("../grandadmin/inc_load_server_config.php"); //load server config

$handledb = mysql_pconnect($rphost,$rpuser,$rppasswd);

// Set current date
$datetime = date("YmdHis");
$current_date = date( "Y-m-d"); //�֧�ѹ���Ѩ�غѹ

$totalrenew_today = 0;  //�ӹǹ��¡�÷���������Ǩ�ͺ����ͺ�ѹ���
$totalrenew_newly = 0;  //�ӹǹ��¡�÷���������ա�úѹ�֡�������к���ͺ���
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

$datesetting = date("Y-m-d"); 		//����ô֧�ѹ���Ѩ�غѹ����ҹ �������ö�ҡ�˹�����ѹ������ͧ������ӧҹẺ��͹��ѧ�� �� $datesetting = "2007-07-11";

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
		} elseif ($arr[$ck] == '90') {//�礷�� 3 ��͹���ʹ���纷���ͧ������� ��ǧ˹��
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
print "website �ӹǹ��¡�÷�辺 $totalrenew_today ��¡��<br>";
print "website �ӹǹ��¡�÷��ѹ�֡ $totalrenew_newly ��¡��<br>";
print "website �ӹǹ��¡�÷������� $total_sendmail ��¡��<br><br>";

print "pop mail �ӹǹ��¡�÷�辺 $num_popmail_found ��¡��<br>";
print "pop mail �ӹǹ��¡�÷��ѹ�֡ $num_popmail_add ��¡��<br>";
print "pop mail �ӹǹ��¡�÷������� $num_popmail_sendmail ��¡��<br><br>";

print "Hosting ��¡�÷�辺 $num_host_found ��¡��<br>";
print "Hosting ��¡�÷��ѹ�֡����к�  $num_host_add ��¡��<br>";
print "Hosting ��¡�÷��������  $num_host_sendmail ��¡��<br><br>";

print "Thnic ��¡�÷�辺 $totalthnic_today ��¡��<br>";
print "Thnic ��¡�÷��ѹ�֡����к�  $totalthnic_newly ��¡��<br>";
print "Thnic ��¡�÷��������  $total_sendmailthnic ��¡��<br><br>";

print "Space ��¡�÷�辺 $totalSpace_today ��¡��<br>";
print "Space ��¡�÷��ѹ�֡����к�  $totalSpace_newly ��¡��<br>";
print "Space ��¡�÷��������  $total_sendmailSpace ��¡��<br><br>";

print "website �ӹǹ��¡�÷�辺 $totalrenew_velaeasy_today ��¡��<br>";
print "website �ӹǹ��¡�÷��ѹ�֡ $totalrenew_velaeasy_newly ��¡��<br>";
print "website �ӹǹ��¡�÷������� $total_velaeasy_sendmail ��¡��<br><br>";

print "GoogleApp �ӹǹ��¡�÷�辺 $num_gapp_found ��¡��<br>";
print "GoogleApp �ӹǹ��¡�÷��ѹ�֡ $num_gapp_add ��¡��<br>";
print "GoogleApp �ӹǹ��¡�÷������� $num_gapp_sendmail ��¡��<br><br>";
?>