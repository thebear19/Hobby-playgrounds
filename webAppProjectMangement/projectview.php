<?
include("connect.php");
include("button.php");
$prj_id=$_GET['prj_id'];

function echoTD($st,$ed){
	$i=10;
	while($st<=$ed&&$i<=21){
		if($st==$i){
			echo "<td bgcolor='#ff9900'></td>";
			$i++;
			while($i<=$ed){
				echo "<td bgcolor='#ff9900'></td>";
				$i++;
			}
		}
		else{
			echo "<td></td>";
			$i++;
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
<title>Untitled Document</title>
<script type="text/javascript">
	function approve(){
		var prj_id = document.getElementById("prj_id").value;
		var approve = document.getElementById("approve").value;
		if(approve=="approve"){
			alert("อนุมัติโครงการเรียบร้อยแล้ว")
			loadXMLDoc("update_activity.php?prj_id="+prj_id+"&approve=1",function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("contentarea").innerHTML=xmlhttp.responseText;
				}
			});
		}else if(approve=="unapprove"){
			alert("ยกเลิกอนุมัติโครงการเรียบร้อยแล้ว")
			loadXMLDoc("update_activity.php?prj_id="+prj_id+"&approve=0",function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("contentarea").innerHTML=xmlhttp.responseText;
				}
			});
		}
	}
	function activity(){
        var prj_id = document.getElementById("prj_id").value;
		var sector_prj_id=prompt("กรุณาใส่รหัสชุดโครงการที่รับผิดชอบ\n(ใส่2)");
		var act_id=prompt("กรุณาใส่รหัสกิจกรรมที่ท่านต้องการรายงานผล\n(ใส่7)");
		window.location.replace("update_activity.php?prj_id="+prj_id+"&sector_prj_id="+sector_prj_id+"&act_id="+act_id+"");
		/*if(sector_prj_id!=""||act_id!=""){
			loadXMLDoc("update_activity.php?prj_id="+prj_id+"&sector_prj_id="+sector_prj_id+"&act_id="+act_id,function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("contentarea").innerHTML=xmlhttp.responseText;
				}
			});
		}else{
			alert("เกิดข้อผิดพลาด!!\nกรุณากรอกข้อมูลให้ครบถ้วนสมบูรณ์");
		}*/
    }
    var xmlhttp;
    function loadXMLDoc(url,cfunc){
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=cfunc;
        xmlhttp.open("GET",url,true);
        xmlhttp.send();
    }
</script>
</head>
<body>
<?
$sql="select * from project where project_id=".$prj_id.";";
$rst=mysql_query($sql);
$numrow=mysql_num_rows($rst);
if($numrow!=0){
?>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
	<td colspan="5"><input type="button" name="info" class="info button gray" id="info" value="ข้อมูลโครงการ" onclick="window.location.replace('projectview.php?prj_id=<?echo $prj_id;?>');"/>
	<input type="button" name="history" class="history button gray" id="history" value="ประวัติการแก้ไข" onclick="window.location.replace('history.php?prj_id=<?echo $prj_id;?>');"/>
	</td>
  </tr>
</table>
<table width="800" border="0" cellspacing="3" cellpadding="2" align="center">
<tr><td>
<div id="contentarea">
 <? 
$sql="select Project_Status from project where project_id=".$prj_id.";";
$rst=mysql_query($sql);
while($row=mysql_fetch_array($rst)){
	//$app=$row['Is_Approved'];
?>
<table width="800" border="0" cellspacing="1" cellpadding="8" align="center" bgcolor="#e8e8e8">
  <tr valign="top" >
    <td height="20" colspan="5" align="right"><b>สถานะโครงการ</b> : <? echo $row['Project_Status']; ?></td>
  </tr>
  <tr>
    <td height="15" colspan="5"><b>แผนงาน</b></td>
  </tr>
<?
}
/*$sql="SELECT * FROM annual_objective_plan ap JOIN strategy s ON ap.plan_id=s.plan_id JOIN aim am ON s.strategy_id=am.strategy_id JOIN aim_project amp ON am.aim_id=amp.aim_id JOIN project p ON amp.project_id=p.project_id JOIN sector_project sp ON p.project_id = sp.project_id JOIN activity a ON sp.sector_project_id = a.section_project_id where p.project_id=".$prj_id." order by activity_id;";
mysql_query("SET NAMES UTF8");
$rst=mysql_query($sql) or die(mysql_error());
$num_row = mysql_num_rows($rst);*/
$sql="select distinct plan_name from annual_objective_plan aop join strategy s on aop.plan_id=s.plan_id join aim a on s.strategy_id=a.strategy_id join aim_project ap on a.aim_id=ap.aim_id where project_id=".$prj_id.";";
$rst=mysql_query($sql);
while($row=mysql_fetch_array($rst)){
	//$app=$row['Is_Approved'];
?>
  <tr valign="top">
    <td width="150"></td>
    <td colspan="4" ><? echo $row['plan_name']; ?></td>
  </tr>
  <tr valign="top">
    <td height="15" colspan="5"><b>ยุทธศาสตร์</b></td>
  </tr>
<?
}
$sql="select * from strategy s join aim a on s.strategy_id=a.strategy_id join aim_project ap on a.aim_id=ap.aim_id where project_id=".$prj_id.";";
$rst=mysql_query($sql);
while($row=mysql_fetch_array($rst))
{
	?>
  <tr valign="top">
    <td></td>
    <td colspan="4"><b>ยุทธศาสตร์ที่ <? echo $row['Strategy_ID']; ?></b > <? echo $row['Strategy_Description']; ?></td>
  </tr>
 <? }
?>
  <tr valign="top">
    <td height="15" colspan="5"><b>เป้าประสงค์</b></td>
  </tr>
<?
$sql="select * from aim a join aim_project ap on a.aim_id=ap.aim_id where project_id=".$prj_id.";";
$rst=mysql_query($sql);
while($row=mysql_fetch_array($rst))
{
	?>
  <tr valign="top">
    <td></td>
    <td colspan="4"><b>เป้าประสงค์ที่ <? echo $row['Aim_ID']; ?></b > <? echo $row['Aim_Description']; ?></td>
  </tr>
  <?
}
$sql="select * from project where project_id=".$prj_id.";";
$rst=mysql_query($sql);
while($row=mysql_fetch_array($rst))
{
	?>
  <input type="hidden" id="prj_id" name="prj_id" value="<? echo $row['Project_ID']; ?>"/>
  <tr>
    <td height="35"><b>ชื่อโครงการ</b></td>
    <td colspan="4"><? echo $row['Project_Name']; ?></td>
  </tr>  
  <tr valign="top">
    <td height="35"><b>หน่วยงานที่รับผิดชอบ</b></td>
    <td colspan="4"><? echo $row['Project_Manager']; ?></td>
  </tr>
  <tr valign="top">
    <td colspan="5"><hr/></td>
  </tr>
  <!-- 
  <tr valign="top">
    <td height="35"><b>ประเภทโครงการ</b></td>
    <td colspan="4"><? echo $row['Project_Type']; ?></td>
  </tr>
  -->
  <tr valign="top">
    <td height="15" colspan="5"><b>หลักการและเหตุผล</b></td>
  </tr>
  <tr valign="top">
    <td></td>
    <td colspan="4"><? echo $row['Project_Principles_Rationale']; ?></td>
  </tr>
    <?
//}
/*$sql="select * from project_goal where project_id=".$prj_id.";";
$rst=mysql_query($sql);
while($row=mysql_fetch_array($rst))
{*/
	?>
  <tr valign="top">
    <td height="15" colspan="5"><b>วัตถุประสงค์ของโครงการ</b></td>
  </tr>
  <tr valign="top">
    <td></td>
    <td colspan="4"><? echo $row['Project_Goal']; ?></td>
  </tr>
  <?
}
$sql="select * from project where project_id=".$prj_id.";";
$rst=mysql_query($sql);
while($row=mysql_fetch_array($rst))
{
	?>
  <tr valign="top">
    <td height="15" colspan="5"><b>เป้าหมายของโครงการ</b></td>
  </tr>
  <tr valign="top">
    <td></td>
    <td colspan="4"><? echo $row['Project_Target']; ?></td>
  </tr>
  <tr valign="top">
    <td height="35" colspan="5"><b>ผลสัมฤทธิ์ของงานที่คาดหวัง</b></td>
  </tr>
  <tr valign="top">
    <td height="35">&nbsp;&nbsp;&nbsp;- <b>ด้านผลลัพธ์</b></td>
    <td colspan="4"><? echo $row['Expected_Outcome_Result']; ?></td>
  </tr>
  <tr valign="top">
    <td height="35">&nbsp;&nbsp;&nbsp;- <b>ด้านผลผลิต</b></td>
    <td colspan="4"><? echo $row['Expected_Output_Result']; ?></td>
  </tr>
  <!-- 
  <tr valign="top">
    <td height="35"><b>เจ้าหน้าที่ผู้รับผิดชอบโครงการ</b></td>
    <td colspan="4"></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ผู้ประสานงานโครงการ</b></td>
    <td colspan="4"><? echo $row['Project_Coordinator']; ?></td>
  </tr>
  -->
  <tr valign="top">
    <td height="35" colspan="5"><b>วิธีวัดผลสัมฤทธิ์ของโครงการ</b></td>
  </tr>
  <tr valign="top">
    <td height="35">&nbsp;&nbsp;&nbsp;- <b>ตัวชี้วัดผลลัพธ์</b></td>
    <td colspan="4"><? echo $row['Outcome_Indicator']; ?></td>
  </tr>
  <tr valign="top">
    <td height="35">&nbsp;&nbsp;&nbsp;- <b>ตัวชี้วัดผลผลิต</b></td>
    <td colspan="4"><? echo $row['Productive_Indicator']; ?></td>
  </tr>
  <tr valign="top">
    <td height="20" colspan="5"><b>แผนการดำเนินงานโครงการ</b></td>
  </tr>
  <tr valign="top">
    <td height="35" colspan="5">
<?
}
$sql="select * from activity a join sector_project sp on a.section_project_id=sp.sector_project_id where project_id=".$prj_id.";";
$rst=mysql_query($sql);
$num_row=mysql_num_rows($rst);
while($row=mysql_fetch_array($rst))
{
	?>
		<table width="750" align="center" cellpadding="6" border="1px" bordercolor="#707070" style="border-width:thin;border-style:solid;border-spacing:0px;" bgcolor="#ffffcc">
			<tr>
				<td width="330" colspan="2"></td>
				<td colspan="12" align="center" width="420"><b>ปีงบประมาณ XX</b></td>
			</tr>
			<!--
			<tr>
				<td width="340"></td>
				<td></td>
				<td colspan="12" align="center" width="440"><b>ระยะเวลา</b></td>
			</tr>
			-->
			<tr align="center">
				<td colspan="2" align="right"><b>ระยะเวลา</b></td>
				<td>ต.ค.</td>
				<td>พ.ย.</td>
				<td>ธ.ค.</td>
				<td>ม.ค.</td>
				<td>ก.พ.</td>
				<td>มี.ค.</td>
				<td>เม.ย.</td>
				<td>พ.ค.</td>
				<td>มิ.ย.</td>
				<td>ก.ค.</td>
				<td>ส.ค.</td>
				<td>ก.ย.</td>
			</tr>
			<tr>
				<td width="350" colspan="2"><b>กิจกรรม</b></td>
				<td colspan="12"></td>
			</tr>
			<tr>
				<td colspan="2">
				<? 
					echo $row['Activity_Name']; 
				?>
				</td>
				<?
					if($row['Planned_Starting_Date']!=NULL){
					$start_d=substr($row['Planned_Starting_Date'],5,2);
					if($start_d<=9){
						$start_d+=12;
					}
					$end_d=substr($row['Planned_Ending_Date'],5,2);
					if($end_d<=9){
						$end_d+=12;
					}					
					echoTD($start_d,$end_d);
					}else{
						echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
					}
				?>
			</tr>
			<?	  
			if($num_row!=0||$num_row!=1){
				while($row2=mysql_fetch_array($rst)){
			?>
			<tr>
				<td colspan="2">
				<? 
					echo $row2['Activity_Name']; 
				?>
				</td>
				<?
					if($row2['Planned_Starting_Date']!=NULL){
					$start_d=substr($row2['Planned_Starting_Date'],5,2);
					if($start_d<=9){
						$start_d+=12;
					}
					$end_d=substr($row2['Planned_Ending_Date'],5,2);
					if($end_d<=9){
						$end_d+=12;
					}
					echoTD($start_d,$end_d);
					}else{
						echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
					}
				?>
			</tr>
			<?
				}
			}
			?>
		</table>
	</td>
  <?
}
$sql="select * from project where project_id=".$prj_id.";";
$rst=mysql_query($sql);
while($row=mysql_fetch_array($rst))
{
	?>
  <tr><td height="10" colspan="14"></td></tr>
  </tr>
  <tr valign="top">
    <td height="35"><b>สถานที่จัดทำโครงการ</b></td>
    <td colspan="4"><? echo $row['Project_Location']; ?></td>
  </tr>
  <?
			}
$sql="select * from project p join fiscal_year_project f where p.project_id=".$prj_id." and f.project_id=".$prj_id.";";
$rst=mysql_query($sql);
while($row=mysql_fetch_array($rst))
{
	?>
  <tr valign="top">
    <td height="15" colspan="5"><b>ระยะเวลาดำเนินการตามโครงการ</b></td>
  </tr>
  <tr valign="top">
    <td></td>
    <td colspan="4"><b>เริ่มต้น : </b><? echo $row['Planned_Starting_Date']; ?>
	<br/><br/><b>สิ้นสุด : </b><? echo $row['Planned_Ending_Date']; ?></td>
  </tr>
  <?
}
$sql="select sum(allocated_budget_amount) budget from budget_project where project_id=".$prj_id.";";
$rst=mysql_query($sql);
while($row=mysql_fetch_array($rst))
{
	?>
  <tr valign="top">
    <td height="35" colspan="5"><b>ค่าใช้จ่ายและอัตรากำลัง</b></td>
  </tr>
  <tr valign="top">
    <td height="35">&nbsp;&nbsp;&nbsp;- <b>ค่าใช้จ่าย</b></td>
    <td colspan="4"><? echo $row['budget']; ?></td>
  </tr>
  <?
}
$sql="select * from project where project_id=".$prj_id.";";
$rst=mysql_query($sql);
while($row=mysql_fetch_array($rst))
{
	$app=$row['Is_Approved'];
	?>
  <tr valign="top">
    <td height="35">&nbsp;&nbsp;&nbsp;- <b>อัตรากำลัง</b></td>
    <td colspan="4"><? echo $row['Task_Force']; ?></td>
  </tr>
  <tr valign="top">
    <td height="15" colspan="5"><b>ความสอดคล้องกับเป้าหมายส่วนรวม</b></td>
  </tr>
  <tr valign="top">
    <td></td>
    <td colspan="4"><? echo $row['Consistency_With_Overall_Objective']; ?></td>
  </tr>
  <!--
  <tr valign="top">
    <td height="35"><b>คำอธิบาย</b></td>
    <td colspan="4"><? echo $row['Notes']; ?></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>เงินสำรองกันปี</b></td>
    <td colspan="4"><? echo $row['Reserved_Fund']; ?></td>
  </tr>
  -->
  <tr valign="top">
    <td height="15" colspan="5"><b>การติดตามและประเมินผลโครงการ</b></td>
  </tr>
  <tr valign="top">
    <td></td>
    <td colspan="4"><? echo $row['Project_Tracking_And_Evalution']; ?></td>
  </tr>
  <tr valign="top">
    <td height="15" colspan="5"><b>ผลที่คาดว่าจะได้รับ</b></td>
  </tr>
  <tr valign="top">
    <td></td>
    <td colspan="4"><? echo $row['Anticipated_Deliverable']; ?></td>
  </tr> 
  <!--
  <tr valign="top">
    <td height="35"><b>ผลตอบแทน</b></td>
    <td colspan="4"><? echo $row['Return_On_Project']; 
	$app=$row['Is_Approved']; ?></td>
  </tr>
  <? 
  $i=1;
  ?>
  <tr valign="top">
    <td height="35"><b>กิจกรรม</b></td>
    <td colspan="4"><b>>></b> <? echo $row['Activity_Name']; ?></td>
	<input type="hidden" id="act_name<? echo $i; ?>" name="act_name<? echo $i; ?>" value="<? echo $row['Activity_Name']; ?>"/>
  </tr>  
  <tr valign="top">
    <td></td>  
    <td width="70" height="50"><b>หน่วยงาน</b></td>
    <td width="250"><? echo $row['Contact_Name']; ?></td>    
    <td><b>เริ่มต้น</b><? echo $row['Planned_Starting_Date']; ?><b>
	<br/>สิ้นสุด</b><? echo $row['Planned_Ending_Date']; ?></td>
    <td></td>
  </tr>
  <?
	if($num_row>1){
		while($row=mysql_fetch_array($rst)){
			$i++;
  ?>
  <tr valign="top">
    <td height="35"></td>
    <td colspan="4"><b>>> </b><? echo $row['Activity_Name']; ?></td>	
	<input type="hidden" id="act_name<? echo $i; ?>" name="act_name<? echo $i; ?>" value="<? echo $row['Activity_Name']; ?>"/>
  </tr>  
  <tr valign="top">
    <td></td>  
    <td width="70" height="50"><b>หน่วยงาน</b></td>
    <td width="250"><? echo $row['Contact_Name']; ?></td>    
    <td><b>เริ่มต้น</b><? echo $row['Planned_Starting_Date']; ?><b>
	<br/>สิ้นสุด</b><? echo $row['Planned_Ending_Date']; ?></td>
    <td></td>
  </tr>
  <?
		}
	}
  ?>  
  -->
  <?
  if(isset($_SESSION['username'])){
  ?>
  <tr><td colspan="5" height="20"></td></tr> 
  <tr align="center">
    <td colspan="5">
	<? if($app==0){ ?>
			<input type="button" id="approve" onclick="approve();" value="approve"/>
	<? }else if($app==1){ ?>			
			<input type="button" id="approve" onclick="approve();" value="unapprove"/>
	<? } ?>
	<input type="button" id="" name="" onclick="javascript:window.print();" value="print"/>
	&nbsp;
	<? if($app==0){ ?>
	<input type="button" onclick="activity();" value="รายงานผลการดำเนินกิจกรรม" disabled="disabled"/>
	<? }else{ ?>
	<input type="button" onclick="activity();" value="รายงานผลการดำเนินกิจกรรม"/>
	<? } ?>
	&nbsp;
	<a href="project_edit.php?prj_id=<? echo $prj_id; ?>">แก้ไข</a>
	</td>
  </tr>
  <tr><td colspan="5" height="30"><hr/></td></tr> 
<?
  }
}
?>
</table>
</div>
</td></tr>
</table>
<?
}else{
?>
  <center><b><font style="color:red;">ไม่มีโครงการนี้</font></b></center> 
<?
}
?>
</body>
</html>