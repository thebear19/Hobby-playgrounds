<?php
/*
 * Created on 16 ก.ย. 2556
 *
 * File: bank_statement_list.php
 * แสดงรายการ Bank Statement
 */
?>

<?php
session_start();
include ("inc_checkerror.php");

$monththai = array("ไม่ระบุ","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม", "สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$daynow = date("d");
$monthnow = date("m");
$yearnow = date("Y");
$check_fromdate = strtotime(date("d"));
$fromdate = date("d",$check_fromdate);

if($bank != ""){
	$downloadfile="Bank_statement_".$bank."_"."$date_from"."_"."$date_to.xls";
}else{
	$downloadfile="Bank_statement_"."$date_from"."_"."$date_to.xls";
}
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$downloadfile");
?>
<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:x='urn:schemas-microsoft-com:office:excel' xmlns='http://www.w3.org/TR/REC-html40'>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
</head>
<body>
<table x:str width="100%" border="1" bordercolor="#CCCCCC" style="border:1px solid #000000;">
	<tr bgcolor="#990066" align="center">
		<td style="border-right:1px solid #000000; background-color: #990066;"><font color="#FFFFFF" face='tahoma'><b>No.</b></font></td>
		<td style="border-right:1px solid #000000; background-color: #990066;"><font color="#FFFFFF" face='tahoma'><b>ID</b></font></td>
		<td style="border-right:1px solid #000000; background-color: #990066;"><font color="#FFFFFF" face='tahoma'><b>Status</b></font></td>
		<td style="border-right:1px solid #000000; background-color: #990066;" width="10%"><font color="#FFFFFF" face='tahoma'><b>Bank</b></font></td>
		<td style="border-right:1px solid #000000; background-color: #990066;" width="15%"><font color="#FFFFFF" face='tahoma'><b>ช่องทางการชำระเงิน</b></font></td>
		<td style="border-right:1px solid #000000; background-color: #990066;" width="10%"><font color="#FFFFFF" face='tahoma'><b>Reference No</b></font></td>		
		<td style="border-right:1px solid #000000; background-color: #990066;" width="10%"><font color="#FFFFFF" face='tahoma'><b>Date</b></font></td>
		<td style="border-right:1px solid #000000; background-color: #990066;" width="10%"><font color="#FFFFFF" face='tahoma'><b>เข้า</b></font></td>
		<td style="border-right:1px solid #000000; background-color: #990066;" width="10%"><font color="#FFFFFF" face='tahoma'><b>ออก</b></font></td>
		<td style="border-right:1px solid #000000; background-color: #990066;" width="10%"><font color="#FFFFFF" face='tahoma'><b>คงเหลือ</b></font></td>
		<td style="border-right:1px solid #000000; background-color: #990066;" width="10%"><font color="#FFFFFF" face='tahoma'><b>Clearing No</b></font></td>
		<td style="border-right:1px solid #000000; background-color: #990066;" width="10%"><font color="#FFFFFF" face='tahoma'><b>Invoice No</b></font></td>
		<td style="border-right:1px solid #000000; background-color: #990066;" width="10%"><font color="#FFFFFF" face='tahoma'><b>Sale</b></font></td>
	</tr>
	<?php
	if($date_from=="" || $date_to==""){ 
		$ex_date_from = explode("-", date("d-m-Y"));
		$ex_date_to = explode("-", date("d-m-Y"));
		
	}else{
		$ex_date_from = explode("-", $date_from);
		$ex_date_to = explode("-", $date_to);
	}
	
	function checkPaymentBy($pay_id){
		global $dbname;
		$sql_payment = "SELECT * FROM ready_account_payment WHERE pay_id=$pay_id";
		$se_payment = mysql_db_query($dbname,$sql_payment);
		$re_payment = mysql_fetch_array($se_payment);
		$payment_by = $re_payment[payment_by];
		return $payment_by;
	}
	
	//กำหนดยอดยกมาจากเดือนที่แล้ว
	$sql_balance = "SELECT SUM(pay_in) AS sumPayin, SUM(pay_out) AS sumPayout FROM ready_account_bank_statement WHERE pay_date <'".$ex_date_from[2]."-".$ex_date_from[1]."-".$ex_date_from[0]."'";
	if($bank != ""){
		$sql_balance .= " AND bank = '$bank'";
	}		
	$sql_balance .= " ORDER BY pay_date ASC, s_id ASC";	
	$se_balance = mysql_db_query($dbname,$sql_balance);
	
	//1. หา Begining หาจากยอดรวมตั้งแต่วันที่กำหนดถึงวันที่ปัจจุบันที่ค้นหา  SUM(pay_in - pay_out)	
	$amount = 0;
	$begining = 0;
	$total_payin = 0;
	$re_balance = mysql_fetch_array($se_balance);
	$sum_pay_in = $re_balance[sumPayin];
	$sum_pay_out = $re_balance[sumPayout];
	$total_balance = $sum_pay_in - $sum_pay_out;
	$num = 1;
	echo "<tr>";		
		echo "<td align=\"center\">$num</td>";
		echo "<td></td>";
		echo "<td align=\"center\"></td>";
		echo "<td align=\"center\">ยอดยกมา</td>";			
		echo "<td align=\"left\"></td>";
		echo "<td align=\"center\"></td>";
		echo "<td align=\"center\">".$date_from."</td>"; //ถึงวันที่ last_recheck_date($date_from, 1) ก่อนหน้า 1 วัน
		echo "<td align=\"right\">".number_format($sum_pay_in,2,'.','')."</td>";
		echo "<td align=\"right\">".number_format($sum_pay_out,2,'.','')."</td>";
		echo "<td align=\"right\">".number_format($total_balance,2,'.','')."</td>";
		echo "<td align=\"center\">-</td>";
		echo "<td align=\"center\">-</td>";
		echo "<td align=\"center\">ACC</td>";
	echo "</tr>";
	
	$total_payin = $sum_pay_in;
	$total_payout = $sum_pay_out;
	$total_begining = $total_payin - $total_payout;
	
	$amount += $total_begining;
		
	$sql_num_bank_statement = "SELECT count(*) AS numBankStatement FROM ready_account_bank_statement WHERE pay_date >='".$ex_date_from[2]."-".$ex_date_from[1]."-".$ex_date_from[0]."'"." AND pay_date <='".$ex_date_to[2]."-".$ex_date_to[1]."-".$ex_date_to[0]."'";
	$sql_bank_statement = "SELECT * FROM ready_account_bank_statement WHERE pay_date >='".$ex_date_from[2]."-".$ex_date_from[1]."-".$ex_date_from[0]."' AND pay_date <='".$ex_date_to[2]."-".$ex_date_to[1]."-".$ex_date_to[0]."'";
	
	if($bank != ""){
		$sql_num_bank_statement .= " AND bank = '$bank'";
		$sql_bank_statement .= " AND bank = '$bank'";
	}
	if($payment_by != ""){
		$sql_num_bank_statement .= " AND pay_by = '$payment_by'";
		$sql_bank_statement .= " AND pay_by = '$payment_by'";
	}
	if($status != ""){
		$sql_num_bank_statement .= " AND status = '$status'";
		$sql_bank_statement .= " AND status = '$status'";
	}
	$se_num_bank_statement = mysql_db_query($dbname,$sql_num_bank_statement);
	$re_num_bank_statement = mysql_fetch_array($se_num_bank_statement);
	
	$sql_bank_statement .= "ORDER BY pay_date ASC, s_id ASC";
	$se_bank_statement = mysql_db_query($dbname,$sql_bank_statement);	
	
	
	while($re_bank_statement = mysql_fetch_array($se_bank_statement)){		
		$amount += ($re_bank_statement[pay_in] - $re_bank_statement[pay_out]);
		$num += 1;
                
                $tax_invoice = mysql_db_query($dbname,"SELECT tax_invoice FROM ready_office_clearing WHERE newmemberid = $re_bank_statement[clearing_no]");
                $tax_invoice = mysql_fetch_array($tax_invoice);
                $tax_invoice = $tax_invoice[tax_invoice];
                
		echo "<tr>";
			echo "<td align=\"center\">$num</td>";
			echo "<td align=\"center\">$re_bank_statement[s_id]</td>";
			echo "<td align=\"center\">"; if($re_bank_statement[status]==1) echo "ยืนยัน"; else echo "-"; echo "</td>";
			echo "<td align=\"center\">$re_bank_statement[bank]</td>";			
			echo "<td align=\"center\">".checkPaymentBy($re_bank_statement[pay_by])."</td>";			
			echo "<td align=\"center\">"; if($re_bank_statement[ref_no]=="") echo "-"; else echo $re_bank_statement[ref_no]; echo "</td>";
			echo "<td align=\"center\">".date("d-m-Y", strtotime($re_bank_statement[pay_date]))."</td>";
			echo "<td align=\"right\">".number_format($re_bank_statement[pay_in],2,'.','')."</td>";
			echo "<td align=\"right\">".number_format($re_bank_statement[pay_out],2,'.','')."</td>";
			echo "<td align=\"right\">".number_format($amount,2,'.','')."</td>";
			
			//For ling to confirm clearing
			
			if($re_bank_statement[clearing_no]!="" AND $re_bank_statement[status]==1){
				$sql_clearing_page = "SELECT a.newmemberid, a.CustomerID, b.Sale, b.currentWebsiteName FROM ready_office_clearing a INNER JOIN ready_customer_id b ON a.CustomerID = b.CustomerID WHERE a.newmemberid =$re_bank_statement[clearing_no]";
				$se_clearing_page = mysql_db_query($dbname,$sql_clearing_page);
				$re_clearing_page = mysql_fetch_array($se_clearing_page);
				$clearing_no = $re_clearing_page[newmemberid];
				if($clearing_no){
					$sql_call_status = "SELECT call_status FROM ready_new_members_call WHERE newmemberid = $clearing_no";
					$se_call_status = mysql_db_query($dbname,$sql_call_status);
					$re_call_status = mysql_fetch_array($se_call_status);
					$call_status_id = $re_call_status[call_status];					
					
					echo "<td align=\"center\">$re_bank_statement[clearing_no]</td>";
				}else{
					echo "<td align=\"center\">-</td>";
				}
											
			}else{
				echo "<td align=\"center\">-</td>";
			}
			
			if($tax_invoice != ""){
				echo "<td align=\"center\" >$tax_invoice</td>";
			}else{
				echo "<td align=\"center\" >-</td>";
			}
			
			echo "<td align=\"center\">"; if(($re_bank_statement[sale_name]!="" or  $re_bank_statement[clearing_no]!="") and $re_bank_statement[status]==1) echo "$re_bank_statement[sale_name]</td>";
			
		echo "</tr>";		
		
	}
	?>	
	
</table>

</table>
</body>
</html>