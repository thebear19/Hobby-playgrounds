<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<?php
//�к����������� Google App ����͹ index.php �� �¡�͡�����ͧ�ҡ��ҧ��ǹ�������ö�������ѹ��

include ("inc_dbconnect.php");

$handledb = mysql_pconnect($rphost, $rpuser, $rppasswd);

// Set current date
$datetime = date("YmdHis");
$current_date = date("Y-m-d"); //�֧�ѹ���Ѩ�غѹ

$num_gapp_found = 0;
$num_gapp_add = 0;
$num_gapp_sendmail = 0;

$datesetting = date("Y-m-d");   //����ô֧�ѹ���Ѩ�غѹ����ҹ �������ö�ҡ�˹�����ѹ������ͧ������ӧҹẺ��͹��ѧ�� �� $datesetting = "2007-07-11";
//$datesetting = "2014-11-16";

$datesettingarr = explode("-", $datesetting);
$daynow = $datesettingarr[2];
$monthnow = $datesettingarr[1];
$yearnow = $datesettingarr[0];

//�֧�Ҥ��Թ���
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

$arr = array(7, 15, 30, 60, 90); //���������طء� 7 15 30 60 90 �ѹ
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

print "GoogleApp �ӹǹ��¡�÷�辺 $num_gapp_found ��¡��<br>
        GoogleApp �ӹǹ��¡�÷��ѹ�֡ $num_gapp_add ��¡��<br>
        GoogleApp �ӹǹ��¡�÷������� $num_gapp_sendmail ��¡��";
?>