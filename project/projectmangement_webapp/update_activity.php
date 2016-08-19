<?
include("connect.php");
include("button.php");
$prj_id=$_REQUEST['prj_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Untitled Document</title>
</head>
<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
	<td colspan="5"><input type="button" name="info" class="info button gray" id="info" value="ข้อมูลโครงการ" onclick="window.location.replace('projectview.php?prj_id=<?echo $prj_id;?>');"/>
	<input type="button" name="history" class="history button gray" id="history" value="ประวัติการแก้ไข" onclick="window.location.replace('history.php?prj_id=<?echo $prj_id;?>');"/>
	</td>
  </tr>  <tr>
	<td height="5" colspan="5"></td>
  </tr>  
</table>

<?
if(isset($_REQUEST['update'])){
	updateInfo();
	echo "<script type='text/javascript'>alert('บันทึกข้อมูลเรียบร้อยแล้ว');window.location.replace('projectview.php');</script>";
}
else if(isset($_REQUEST['approve'])){
	$prj_id=$_REQUEST['prj_id'];
	$approve=$_REQUEST['approve'];
	if($approve==1){
		$sql="update project set is_approved=1 where project_id=".$prj_id.";";
		mysql_query($sql) or die(mysql_error());
		echo('<meta http-equiv="refresh" content="0">'); 
		//header("location:projectview.php");
		//echo $sql;
	}else if($approve==0){
		$sql="update project set is_approved=0 where project_id=".$prj_id.";";
		mysql_query($sql) or die(mysql_error());
		echo('<meta http-equiv="refresh" content="0">'); 
		//echo $sql;
	}
}
else if(isset($_REQUEST['sector_prj_id'])&&isset($_REQUEST['act_id'])){
$prj_id=$_REQUEST['prj_id'];
$sector_prj_id=$_REQUEST['sector_prj_id'];
$act_id=$_REQUEST['act_id'];

$sql="SELECT * FROM project p JOIN sector_project s ON p.project_id = s.project_id JOIN activity a ON s.sector_project_id = a.section_project_id where p.project_id='".$prj_id."' and s.sector_project_id='".$sector_prj_id."' and a.activity_id='".$act_id."';";
$rst=mysql_query($sql) or die(mysql_error());
// --------------------- เช็คกรณีไม่มีข้อมูล หรือผิดพลาด --------------------------- 
if(mysql_num_rows($rst)==0){
	echo "<script type='text/javascript'>alert('กรุณาตรวจสอบข้อมูลอีกครั้ง');window.location.replace('projects.php');</script>";
}else{
while($row=mysql_fetch_array($rst)){
?>
<form name="updateform" action="update_activity.php" onsubmit="return validate();">
<input type="hidden" id="update" name="update" value="1"/>
<input type="hidden" id="prj_id" name="prj_id" value="<? echo $row['Project_ID']; ?>"/>
<input type="hidden" id="sector_prj_id" name="sector_prj_id" value="<? echo $row['Section_Project_ID']; ?>"/>
<input type="hidden" id="act_id" name="act_id" value="<? echo $row['Activity_ID']; ?>"/>
<table width="800" border="0" cellspacing="3" cellpadding="2" align="center" bgcolor="#e8e8e8">
<tr>
    <td width="120" height="30"><b>โครงการ</b></td>
    <td colspan="2"><? echo $row['Project_Name']; ?></td>
</tr>
<tr>
    <td height="30"><b>รหัสชุดโครงการที่ </b></td>
    <td colspan="2"><? echo $sector_prj_id; ?></td>
</tr>
<tr>
    <td height="30"><b>กิจกรรมที่ </b></td>
	<td colspan="2"><? echo $act_id; ?></td>
</tr>
<tr valign="top">
  <td height="35"><b>ชื่อกิจกรรม</b></td>
  <td colspan="2"><? echo $row['Activity_Name']; ?></td>
</tr>
<tr>
	<td colspan="3" height="10"><hr/></td>
</tr>
<tr>
	<td colspan="3" height="30"><b>ส่วนบันทึกผลการดำเนินการในกิจกรรม</b></td>
</tr>
<tr>
	<td></td>
	<td colspan="2" height="30"><b>ผลการดำเนินการในกิจกรรม</b></td>
</tr>
<tr>
	<td></td>
	<td><textarea cols="90" rows="7" id="operation_outcome" name="operation_outcome" wrap="hard"></textarea></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td colspan="2" height="30"><b>ปัญหาและอุปสรรค</b></td>
</tr>
<tr>
	<td></td>
	<td><textarea cols="90" rows="7" id="problem" name="problem" wrap="hard"></textarea></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td colspan="2" height="30"><b>ช่วงเวลาที่ดำเนินการจริง</b></td>
</tr>
<tr>
	<td></td>
	<td>
	เริ่มต้น : <input type="date" id="start_date" name="start_date"/>&nbsp;&nbsp;สิ้นสุด : <input type="date" id="end_date" name="end_date"/>
	<!-- <br/>
	<b>หรือ</b><br/>
	ระยะเวลาในการดำเนินการ (วัน) <input type="text" id="act_day" name="act_day"/> 
	-->
	</td>	
	<td></td>
</tr>
<tr>
	<td></td>
	<td colspan="2" height="30"><b>สถานที่จัดกิจกรรม</b></td>
</tr>
<tr>
	<td></td>
	<td><textarea cols="60" rows="2" id="location" name="location" wrap="hard"></textarea></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td colspan="2" height="30"><b>งบประมาณที่ใช้</b></td>
</tr>
<tr>
	<td></td>
	<td><input type="text" id="budget_spent" name="budget_spent"/> บาท</td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td colspan="2" height="30"><b>ผลการดำเนินการตามตัวชี้วัดผลผลิด</b></td>
</tr>
<tr>
	<td></td>
	<td><textarea cols="90" rows="7" id="output" name="output" wrap="hard"></textarea></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td colspan="2" height="30"><b>ผลการดำเนินการตามตัวชี้วัดผลลัพธ์</b></td>
</tr>
<tr>
	<td></td>
	<td><textarea cols="90" rows="7" id="outcome" name="outcome" wrap="hard"></textarea></td>
	<td></td>
</tr>
<tr>
	<td colspan="3" align="center">
		<input type="submit" id="submit" name="submit" value="บันทึกผล"/>
		&nbsp;		
		<input type="reset" id="reset" name="reset" value="ล้างข้อมูลทั้งหมด" onclick="javascript:window.location.reload();"/>
		&nbsp;		
		<input type="button" id="back" name="back" value="ย้อนกลับ" onclick="javascript:window.history.go(-1);"/>
	</td>
</tr>
</table>
</form>
<?
}
}
}
?>
</body>
</html>
<script type="text/javascript">
function checkSet(idname)
{
    if (!document.getElementById(idname).value) {
		document.getElementById(idname).style.background = '#FF0000';		
		//document.getElementById(idname).value="โปรดกรอกข้อมูลลงในช่อง";
		//alert("กรุณากรอกข้อมูลให้ครบถ้วนสมบูรณ์");
		//document.getElementById(idname).focus();
        return false;
    } else {
		document.getElementById(idname).style.background = '#ffffff';
    }
    return true;
}
function validate(){
	var ochk=true;
	if(checkSet('operation_outcome')==false){ ochk=false; }
	if(checkSet('problem')==false){ ochk=false; }
	if(checkSet('start_date')==false&&checkSet('end_date')==false){ ochk=false; }
	if(checkSet('location')==false){ ochk=false; }
	if(checkSet('budget_spent')==false){ ochk=false; }
	if(checkSet('output')==false){ ochk=false; }
	if(checkSet('outcome')==false){ ochk=false; }
	if(ochk==false){ alert("กรุณากรอกข้อมูลให้ครบถ้วนสมบูรณ์"); }
	return ochk;
}
</script>
<?
function updateInfo(){
	$prj_id=$_REQUEST['prj_id'];
	$sector_prj_id=$_REQUEST['sector_prj_id'];
	$act_id=$_REQUEST['act_id'];
	$operation_outcome=$_REQUEST['operation_outcome'];
	$problem=$_REQUEST['problem'];
	$location=$_REQUEST['location'];
	$budget_spent=$_REQUEST['budget_spent'];
	$output=$_REQUEST['output'];
	$outcome=$_REQUEST['outcome'];
	$start_date=$_REQUEST['start_date'];
	$end_date=$_REQUEST['end_date'];	
	$sql="update activity set Actual_Starting_Date='".$start_date."', Actual_Ending_Date='".$end_date."', Activity_Location='".$location."', Budget_Spent_Amount='".$budget_spent."', Problem_and_Obstacle='".$problem."', Operational_Outcome='".$operation_outcome."' where Activity_ID='".$act_id."';";
	/*
		if(isset($_REQUEST['start_date'])&&isset($_REQUEST['end_date'])){
		$start_date=$_REQUEST['start_date'];
		$end_date=$_REQUEST['end_date'];	
		$sql="update activity set Actual_Starting_Date='".$start_date."', Actual_Ending_Date='".$end_date."', Activity_Location='".$location."', Budget_Spent_Amount='".$budget_spent."', Problem_and_Obstacle='".$problem."', Operational_Outcome='".$operation_outcome."' where Activity_ID='".$act_id."';";
	}else{
		$act_day=$_REQUEST['act_day'];
		$sql="update activity set Activity_Duration='".$act_day."', Activity_Location='".$location."', Budget_Spent_Amount='".$budget_spent."', Problem_and_Obstacle='".$problem."', Operational_Outcome='".$operation_outcome."' where Activity_ID='".$act_id."';";
	}	
	*/
	//echo $sql;
	mysql_query($sql) or die(mysql_error());
}
?>