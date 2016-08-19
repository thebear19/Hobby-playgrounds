<?
include("connect.php");
include("logcheck.php");
include('button.php');

echo "<meta charset='utf-8'>";
$prj_id=$_GET['prj_id'];
if(isset($_POST['submit'])){
	$set = "Project_Name = '".$_POST['project_name']."',Project_Principles_Rationale = '".$_POST['Project_Principles_Rationale']."', Project_Location = '".$_POST['Project_Location']."',Project_Manager = '".$_POST['Project_Manager']."', Project_Coordinator = '".$_POST['Project_Coordinator']."', Project_Target = '".$_POST['Project_Target']."', Consistency_With_Overall_Objective = '".$_POST['Consistency_With_Overall_Objective']."', Notes = '".$_POST['Notes']."', Expected_Outcome_Result = '".$_POST['Expected_Outcome_Result']."', Expected_Output_Result = '".$_POST['Expected_Output_Result']."', Reserved_Fund = '".$_POST['Reserved_Fund']."', Outcome_Indicator = '".$_POST['Outcome_Indicator']."', Productive_Indicator = '".$_POST['Productive_Indicator']."', Task_Force = '".$_POST['Task_Force']."', Project_Tracking_And_Evalution = '".$_POST['Project_Tracking_And_Evalution']."', Anticipated_Deliverable = '".$_POST['Anticipated_Deliverable']."', Return_On_Project = '".$_POST['Return_On_Project']."' ";
	$sql = "update project set ".$set." where project_id = '".$prj_id."'";
	mysql_query($sql) or die(mysql_error());
	
	$sql = "update fiscal_year_project set Planned_Starting_Date = '".$_POST['Planned_Starting_Date']."', Planned_Ending_Date = '".$_POST['Planned_Ending_Date']."', fiscal_year = '".$_POST['fiscal_year']."' where project_id = '".$prj_id."'" ;
	mysql_query($sql) or die(mysql_error());
	
	//insert to aim_project
		$count = $_POST['row_pas'];
		if($count > 1){
			
		for($i=1;$i<$count;$i++){
			$aim_id = $_POST["aim".$i];
			$sql = "insert into aim_project values('','".$aim_id."','".$prj_id."','')";
			mysql_query($sql)or die(mysql_error());
		}
		}
		
	header("Location:afterupdate.php");
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
<title>Untitled Document</title>
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script type="text/javascript">

function addoption(element){
	var objselect = element;
	var data = new Option("ประเภทงบประมาณ","null");
	objselect.options[objselect.length] = data;
	<?php
			$sql = "select DISTINCT Type_Of_Budget from budget_project";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
			?>
	
				var data = new Option("<?php echo $row['Type_Of_Budget']; ?>","<?php echo $row['Type_Of_Budget']; ?>");
				objselect.options[objselect.length] = data;
	
	<?php 
			} 
	?> 	
}
function addoption_name(element){
	var objselect = element;
	var data = new Option("แหล่งงบประมาณ","null");
	objselect.options[objselect.length] = data;
	<?php
		$sql_bud_name = "select SourceOfBudget_Name,SourceOfBudget_ID from source_of_budget";
		$result_bud_name = mysql_query($sql_bud_name);
		while($bud_name_row = mysql_fetch_array($result_bud_name)){
		?>
        	var data = new Option("<?php echo $bud_name_row['SourceOfBudget_Name']; ?>","<?php echo $bud_name_row['SourceOfBudget_ID']; ?>");
			objselect.options[objselect.length] = data;
        <?php	
		}
	?>

}
function addselect(){
	var row = document.getElementById('row');
	//row.value++;
	var show = document.getElementById('select');
	var field = document.createElement('fieldset');
	field.id = "field"+row.value;
	var budget1 = document.createTextNode("แหล่งงบประมาณ");
	var budget2 = document.createTextNode("ประเภทงบประมาณ");
	var budget3  = document.createTextNode("งบประมาณ (ตัวเลข)");

	var crebutt = document.createElement('br');
	crebutt.setAttribute('name',"br"+row.value);
	crebutt.setAttribute('id',"br"+row.value);

	var create_name = document.createElement('select');
	create_name.setAttribute('name',"budget_name"+row.value);
	create_name.setAttribute('id',"budget_name"+row.value);

	var create = document.createElement('select');
	create.setAttribute('name',"budget_type"+row.value);
	create.setAttribute('id',"budget_type"+row.value);

	var crenum = document.createElement('input');
	crenum.setAttribute('type',"number");
	crenum.setAttribute('name',"budget_num"+row.value);
	crenum.setAttribute('id',"budget_num"+row.value);
	crenum.setAttribute('placeholder',"งบประมาณเป็นตัวเลข");



	field.appendChild(budget2);
	field.appendChild(create);
	addoption(create);
	field.appendChild(budget1);
	field.appendChild(create_name);
	addoption_name(create_name);
	field.appendChild(crebutt);
	field.appendChild(budget3);
	field.appendChild(crenum);
	//show.appendChild(crebutt);
	row.value++;
	show.appendChild(field);
}

function deleted(){
	var row = document.getElementById('row');
	var show = document.getElementById('select');

	if(row.value <= 1){
	alert("cannot delete more");	
	}
	else{
	row.value--;
	var delfieldb = document.getElementById('field'+row.value);
	show.removeChild(delfieldb);
	}
}

function sel_strategy(element,element1,element2){
	var row = element.substring(4,5);
	var name = element.substring(0,4);
	var strategy = element1.substring(0,8);
	var aim = element2.substring(0,3);
	var defaultOption = '<option value=""> ------- เลือก ------ </option>';
	// Bind an event handler to the "change" JavaScript event, or trigger that event on an element.
		$("#strategy"+row).html(defaultOption);
		$("#aim"+row).html(defaultOption);
		// Perform an asynchronous HTTP (Ajax) request.
		$.ajax({
			// A string containing the URL to which the request is sent.
			url: "select_staim.php",
			// Data to be sent to the server.
			data: ({ nextList : 'strategy', plan_id: $('#'+name+row).val() }),
			// The type of data that you're expecting back from the server.
			dataType: "json",
			success: function(json){
				// Iterate over a jQuery object, executing a function for each matched element.
				$.each(json, function(index, value) {
					// Insert content, specified by the parameter, to the end of each element
					// in the set of matched elements.
					 $("#strategy"+row).append('<option value="' + value.Strategy_ID + 
											'">' + value.Strategy_Description + '</option>');
				});
			}
		});
}
function sel_aim(element,element1){
	var row = element.substring(8,9);
	var name = element.substring(0,8);
	var aim = element1.substring(0,3);
	var defaultOption = '<option value=""> ------- เลือก ------ </option>';
		$("#aim"+row).html(defaultOption);
		$.ajax({
			url: "select_staim.php",
			data: ({ nextList : 'aim', strategy_id: $('#'+name+row).val() }),
			dataType: "json",
			success: function(json){
				$.each(json, function(index, value) {
					 $("#aim"+row).append('<option value="' + value.Aim_ID + 
											'">' + value.Aim_Description + '</option>');
				});
			}
		});
}


function addoption_pro(element){
	var objselect = element;
	var data = new Option("แผนงาน","null");
	objselect.options[objselect.length] = data;
	<?php
		$sql_plan = "select plan_name,plan_id from annual_objective_plan";
			$result_sql_plan = mysql_query($sql_plan);
			while($plan_name_row = mysql_fetch_array($result_sql_plan)){
		?>
        	var data = new Option("<?php echo $plan_name_row['plan_name']; ?>","<?php echo $plan_name_row['plan_id']; ?>");
			objselect.options[objselect.length] = data;
        <?php	
		}
	?>

}

function addoption_dis(element){
	var objselect = element;
	var data = new Option("ยุทธศาสตร์","");
	objselect.options[objselect.length] = data;

}

function addoption_sub(element){
	var objselect = element;
	var data = new Option("เป้าประสงค์","");
	objselect.options[objselect.length] = data;
}


function added(){

	var row = document.getElementById('row_pas');
	var show = document.getElementById('add_select');
	var field = document.createElement('fieldset');
	field.id = "field"+row.value;
	var crebutt = document.createElement('br');
	crebutt.setAttribute('name',"br"+row.value);
	crebutt.setAttribute('id',"br"+row.value);
	
	var create_plan = document.createElement('select');
	create_plan.setAttribute('name',"plan"+row.value);
	create_plan.setAttribute('id',"plan"+row.value);
	create_plan.setAttribute('onchange',"sel_strategy(this.id,strategy"+row.value+".id,aim"+row.value+".id)");
	
	var create_strategy = document.createElement('select');
	create_strategy.setAttribute('name',"strategy"+row.value);
	create_strategy.setAttribute('id',"strategy"+row.value);
	create_strategy.setAttribute('onchange',"sel_aim(this.id,aim"+row.value+".id)");
	
	var create_aim = document.createElement('select');
	create_aim.setAttribute('name',"aim"+row.value);
	create_aim.setAttribute('id',"aim"+row.value);
	var plan = document.createTextNode("แผนงาน : ");
	var stra = document.createTextNode("ยุทธศาสตร์ : ");
	var aim = document.createTextNode("เป้าประสงค์ : ")

	
	field.appendChild(plan);
	field.appendChild(create_plan);
	addoption_pro(create_plan);
	field.appendChild(stra);
	field.appendChild(create_strategy);
	addoption_dis(create_strategy);
	field.appendChild(aim);
	field.appendChild(create_aim);
	addoption_sub(create_aim);
	//field.appendChild(crebutt);
	row.value++;
	show.appendChild(field);
}

function dele(){
	//var row = element.substring(7,8);
	var row_field = document.getElementById('row_pas');
	var show = document.getElementById('add_select');
	if(row_field.value <= 1){
		alert("ไม่สามารถลบมากไปกว่านี้ได้");
	}
	else{
	row_field.value--;
	var delfieldb = document.getElementById('field'+row_field.value);
	show.removeChild(delfieldb);
	}

}

</script>
<style type="text/css">
.holder_wrap{  
    position:absolute;  
    margin:auto;  
    display:block;
	width:100%;
    height:100%; 
	right:15px;
} 
.inner_position_right{  
    display:block;    
    background-color:#FFFF99;     
    height:60%; 
	left:500px;
    width:200px;  
    top:0px;
    right:0px;  
    z-index:999;  
	overflow:scroll;
} 
</style>
</head>
<body>
<form name="insertform" method="post">
<div class="holder_wrap" align="right">
<div class="inner_position_right" align="left">  
<center><b>ส่วนแก้ไขข้อมูล</b></center>

<?php
$sql="SELECT * FROM annual_objective_plan ap JOIN strategy s ON ap.plan_id=s.plan_id JOIN aim am ON s.strategy_id=am.strategy_id JOIN aim_project amp ON am.aim_id=amp.aim_id JOIN project p ON amp.project_id=p.project_id JOIN sector_project sp ON p.project_id = sp.project_id JOIN activity a ON sp.sector_project_id = a.section_project_id where p.project_id=".$prj_id." order by activity_id;";
mysql_query("SET NAMES UTF8");
$obj=mysql_query($sql) or die(mysql_error());
while($row_obj=mysql_fetch_array($obj)){
?>
แผนงาน : <? echo $row_obj['Plan_Name']; ?><br />
ยุทธศาสตร์ : <? echo $row_obj['Strategy_Description']; ?><br />
เป้าประสงค์ : <? echo $row_obj['Aim_Description']; ?><br/><br/>
<? }?>
<input type="hidden" id="row_pas" name = "row_pas" value="1"/> 
<input type="button" id="add_psa"  value="เพิ่ม" onclick="added()"/> 
<input type="button" id="del_psa"  value="ลบ" onclick="dele()"/> 

<span id="add_select"></span>

</div> 
</div>


<table width="800" border="0" cellspacing="3" cellpadding="2" align="center">
<tr><td>
<table width="800" border="0" cellspacing="3" cellpadding="2" align="center" bgcolor="#e8e8e8">
<tr valign="top"><td height="10"></td></tr>
<?

$sql="SELECT * FROM annual_objective_plan ap JOIN strategy s ON ap.plan_id=s.plan_id JOIN aim am ON s.strategy_id=am.strategy_id JOIN aim_project amp ON am.aim_id=amp.aim_id JOIN project p ON amp.project_id=p.project_id JOIN sector_project sp ON p.project_id = sp.project_id JOIN activity a ON sp.sector_project_id = a.section_project_id where p.project_id=".$prj_id." order by activity_id;";
mysql_query("SET NAMES UTF8");
$rst=mysql_query($sql) or die(mysql_error());
$num_row = mysql_num_rows($rst);
if($row=mysql_fetch_array($rst)){
?>
<tr valign="top">

</tr>
  <!--<tr valign="top">
    <td width="240" height="45"><b>แผนงาน</b></td>
    <td colspan="4">
    แผนการดำเนินงาน<select name="plan_name0" id = "plan_name0">
	<option value="null">แผนการดำเนินงาน</option>
			<?php
			/*$sql_plan = "select plan_name,plan_id from annual_objective_plan";
			$result_sql_plan = mysql_query($sql_plan);
			while($plan_name_row = mysql_fetch_array($result_sql_plan)){
			?>
		 		<option value = "<?php echo $plan_name_row['plan_id']; ?>" ><?php echo $plan_name_row['plan_name']; ?></option>
            <?php 
			} */
			?>

	</select>หรือ <span id="plan"><input type="hidden" name = "row_plan" id="row_plan" value="1" />
	    <input type="button" value="เพิ่มแผนงาน" name = "add_pl" id="add_pl" onClick="addplan()"/>
	    <input type="button" value="ลบแผนงาน" name = "del_pl" id="del_pl" onClick="deleteplan()" /> หรือ <a href="create_plan.php">สร้างแผนใหม่</a></span>
       
    </td>
  </tr>
  <tr valign="top">
    <td height="45"><b>ยุทธศาสตร์</b></td>
    <td colspan="4">
    ยุทธศาสตร์<select name="strategy_name0" id = "strategy_name0">
	<option value="null">ยุทธศาสตร์</option>
			<?php
			/*$sql_strategy = "select Strategy_Description,Strategy_ID from strategy";
			$result_sql_strategy = mysql_query($sql_strategy);
			while($strategy_name_row = mysql_fetch_array($result_sql_strategy)){
			?>
		 		<option value = "<?php echo $strategy_name_row['Strategy_ID']; ?>" ><?php echo $strategy_name_row['Strategy_Description']; ?></option>
            <?php 
			} */
			?>

	</select>หรือ <span id="strategy"><input type="hidden" name = "row_strategy" id="row_strategy" value="1" />
	    <input type="button" value="เพิ่มยุุทธศาสตร์" name = "add_st" id="add_st" onClick="addstrategy()"/>
	    <input type="button" value="ลบยุทธศาสตร์" name = "del_st" id="del_st" onClick="deletestrategy()" /> หรือ <a href="create_plan.php">สร้างยุทธศาสตร์ใหม่</a></span>
    </td>
  </tr>
  <tr valign="top">
    <td height="45"><b>เป้าประสงค์</b></td><td colspan="4">
    เป้าประสงค์<select name="aim_name0" id = "aim_name0">
	<option value="null">เป้าประสงค์</option>
			<?php
			/*$sql_aim = "select aim_id,Aim_Description from aim";
			$result_sql_aim = mysql_query($sql_aim);
			while($aim_name_row = mysql_fetch_array($result_sql_aim)){*/
			?>
		 		<option value = "<?php /*echo $aim_name_row['aim_id']; ?>" ><?php echo $aim_name_row['Aim_Description']; ?></option>
            <?php 
			}*/
			?>

	</select>หรือ <span id="aim"><input type="hidden" name = "row_aim" id="row_aim" value="1" />
	    <input type="button" value="เพิ่มยุุทธศาสตร์" name = "add_aim" id="add_aim" onClick="addaim()"/>
	    <input type="button" value="ลบยุทธศาสตร์" name = "del_aim" id="del_aim" onClick="deleteaim()" /> หรือ <a href="create_plan.php">สร้างเป้าประสงค์ใหม่</a></span>
  </tr>!-->
  <tr valign="top">
    <td height="45"><b>ชื่อโครงการ</b></td>
    <td colspan="4"><input type="text" name="project_name" size = "100" value="<? echo $row['Project_Name']; ?>"/></td>
  </tr>  
   <!--<tr valign="top">
    <td><b>สำนัก/กอง</b></td>
    <td colspan="2"><input type="checkbox" name="check[]" value="1" />สำนักบริหารกลาง(สบก.)</td>
	<td colspan="2"><input type="checkbox" name="check[]" value="2" />กองการประชุมคณะรัฐมนตรี(กปค.)</td>
  </tr>
  <tr valign="top">
	<td></td>
	<td colspan="2"><input type="checkbox" name="check[]" value="3" />สำนักนิติธรรม(สนธ.) </td>
	<td colspan="2"><input type="checkbox" name="check[]" value="4" />สำนักบริหารงานสารสนเทศ(สบส.)</td>
  </tr>
  <tr valign="top">
	<td></td>
	<td colspan="2"><input type="checkbox" name="check[]" value="5" />สำนักวิเคราะห์เรื่องเสนอคณะรัฐมนตรี(สวค.) </td>
	<td colspan="2"><input type="checkbox" name="check[]" value="6" />สำนักส่งเสริมและประสานงานคณะรัฐมนตรี(สปค.)</td>
  </tr>
  <tr valign="top">
	<td></td>
	<td colspan="2"><input type="checkbox" name="check[]" value="7" />สำนักอาลักษณ์และเครื่องราชอิสริยาภรณ์(สอค.) </td>
	<td colspan="2"><input type="checkbox" name="check[]" value="8" />กลุ่มพัฒนาระบบบริหาร(กพร.)</td>
  </tr>
  <tr valign="top">
    <td></td>
    <td></td>
  </tr>
  <tr valign="top">
    <td height="50"><b>ประเภทโครงการ</b></td>
    <td colspan="4"><input type="radio" name="project_type" value="ฝึกอบรม" />ฝึกอบรม  <input type="radio" name="project_type" value="สัมมนา" />สัมมนา  <input type="radio" name="project_type" value="จัดบรรยาย" />จัดบรรยาย  
    <input type="radio" name="project_type" value="จ้างบุคลากร" />จ้างบุคลากร  <input type="radio" name="project_type" value="พัฒนา IT" />พัฒนา IT  <input type="radio" name="project_type" value="วิจัย" />วิจัย  <input type="radio" name="project_type" value="ฯลฯ" />ฯลฯ  <br/>
	<input type="radio" name="project_type" value="ฝึกอบรม" />ดำเนินการจ้างเอง <input type="radio" name="project_type" value="ฝึกอบรม"/>จัดจ้าง 
	</td>
  </tr>!-->
  <tr valign="top">
    <td height="35"><b>หลักการและเหตุผล</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Project_Principles_Rationale" name="Project_Principles_Rationale" wrap="hard"><? echo $row['Project_Principles_Rationale']; ?></textarea></td>
  </tr>  
  <!--<tr valign="top">
    <td height="35"><b>วัตถุประสงค์</b></td>
    <td colspan="4"><input type="text" id="Project_Goal0" name="Project_Goal0" placeholder="โปรดใส่วัตถุประสงค์"/>
    	<br />
    	<span id="goal"></span>
     	<input type="hidden" name = "row_goal" id="row_goal" value="1" />
	    <input type="button" value="เพิ่มวัตถุประสงค์" name = "add_gl" id="add_gl" onClick="addgoal()"/>
	    <input type="button" value="ลบวัตถุประสงค์" name = "del_gl" id="del_gl" onClick="deletegoal()" />
    </td>
  </tr>!-->
  <tr valign="top">
    <td height="35"><b>สถานที่จัดทำโครงการ</b></td>
    <td colspan="4"><input type="text" name="Project_Location" size = "60" value="<? echo $row['Project_Location']; ?>"/></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>เจ้าหน้าที่<br/>ผู้รับผิดชอบโครงการ</b></td>
    <td colspan="4"><input type="text" name="Project_Manager" size = "60" value="<? echo $row['Project_Manager']; ?>"/></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ผู้ประสานงานโครงการ</b></td>
    <td colspan="4"><input type="text" name="Project_Coordinator" size = "60" value=""/></td>
  </tr>
   <tr valign="top">
    <td height="35"><b>วันเริ่มโครงการ(ตามแผน)</b></td>
    <td colspan="4"><input type="date" name="Planned_Starting_Date" size = "60" value="<? echo $row['Planned_Starting_Date']; ?>"/></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>วันสิ้นสุดโครงการ(ตามแผน)</b></td>
    <td colspan="4"><input type="date" name="Planned_Ending_Date" size = "60" value="<? echo $row['Planned_Ending_Date']; ?>"/></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ปีงบประมาณ(พศ)</b></td>
    <td colspan="4"><input type="number" name="fiscal_year" size = "60" maxlength="4"/></td>
  </tr>
  <!--<tr valign="top">
    <td height="35"><b>แหล่งงบประมาณ<br/>และจำนวณงบประมาณ</b></td>
    <td width="200"  colspan="4">
	ประเภทงบประมาณ<select name="budget_type0" id = "budget_type0">
	<option value="null">ประเภทงบประมาณ</option>
			<?php
			/*$sql_bud = "select DISTINCT  Type_Of_Budget from budget_project";
			$result_bud = mysql_query($sql_bud);
			while($bud_row = mysql_fetch_array($result_bud)){*/
			?>
		 		<option value = "<?php /*echo $bud_row['Type_Of_Budget']; ?>" ><?php echo $bud_row['Type_Of_Budget']; ?></option>
            <?php 
			} */
			?>

	</select>
    แหล่งงบประมาณ<select name="budget_name0" id="budget_name0">
    <option value="null">แหล่งงบประมาณ</option>
	<?php
		/*$sql_bud_name = "select SourceOfBudget_Name,SourceOfBudget_ID from source_of_budget";
		$result_bud_name = mysql_query($sql_bud_name);
		while($bud_name_row = mysql_fetch_array($result_bud_name)){*/
		?>
        	<option value = "<?php /*echo $bud_name_row['SourceOfBudget_ID']; ?>" ><?php echo $bud_name_row['SourceOfBudget_Name']; ?></option>
        <?php	
		}*/
	?>
	</select>
    <br/>
	งบประมาณ (ตัวเลข)<input type="number" name="budget_num0" id = "budget_num0" placeholder="งบประมาณเป็นตัวเลข"/></td>
	</tr>
	<tr>
	  <td></td>
	  <td colspan="4">
	    <span id="select"></span>
	    <input type="hidden" name = "row" id="row" value="1" />
	    <input type="button" value="add" name = "add_bg" id="add_bg" onClick="addselect()"/>
	    <input type="button" value="delete" name = "del_bg" id="del_bg" onClick="deleted()" /> หรือ <a href="create_budget.php">สร้างแหล่งงบประมาณใหม่</a>
	  </td>
  </tr>!-->
  <tr valign="top">
    <td height="35"><b>เป้าหมายของโครงการ</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Project_Target" name="Project_Target" wrap="hard"><? echo $row['Project_Target']; ?></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ความสอดคล้องกับเป้าหมายส่วนรวม</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Consistency_With_Overall_Objective" name="Consistency_With_Overall_Objective" wrap="hard"><? echo $row['Consistency_With_Overall_Objective']; ?></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>คำอธิบาย</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Notes" name="Notes" wrap="hard"></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ผลสัมฤทธิ์ของงานที่คาดหวังด้านผลลัพธ์</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Expected_Outcome_Result" name="Expected_Outcome_Result" wrap="hard"><? echo $row['Expected_Outcome_Result']; ?></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ผลสัมฤทธิ์ของงานที่คาดหวังด้าน์ผลผลิต</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Expected_Output_Result" name="Expected_Output_Result" wrap="hard"><? echo $row['Expected_Output_Result']; ?></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>เงินสำรองกันปี</b></td>
    <td colspan="4"><input type="number" id="Reserved_Fund" name="Reserved_Fund" placeholder="จำนวนเงินเป็นตัวเลข"/></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ตัวชี้วัดผลลัพธ์</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Outcome_Indicator" name="Outcome_Indicator" wrap="hard"><? echo $row['Outcome_Indicator']; ?></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ตัวชี้วัดผลผลิต</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Productive_Indicator" name="Productive_Indicator" wrap="hard"><? echo $row['Productive_Indicator']; ?></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>อัตรากำลังของโครงการ</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Task_Force" name="Task_Force" wrap="hard"><? echo $row['Task_Force']; ?></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>การติดตามและประเมินผลโครงการ</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Project_Tracking_And_Evalution" name="Project_Tracking_And_Evalution" wrap="hard"><? echo $row['Project_Tracking_And_Evalution']; ?></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ผลที่คาดว่าจะได้รับ</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Anticipated_Deliverable" name="Anticipated_Deliverable" wrap="hard"><? echo $row['Anticipated_Deliverable']; ?></textarea></td>
  </tr>  
  <tr valign="top">
    <td height="35"><b>ผลตอบแทน</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Return_On_Project" name="Return_On_Project" wrap="hard"><? echo $row['Return_On_Project']; ?></textarea></td>
  </tr>
  <!--<tr valign="top">
    <td height="35"><b>ชื่อผู้รับผิดชอบโครงการ</b></td>    
    <td colspan="4"><b>ชื่อ</b>
    <input type="text" name="contact_name" id="contact_name" placeholder="ชื่อผู้รับผิดชอบ" />
<b>เบอร์โทร</b><input type="text" name="contact_phone_number" id="contact_phone_number" placeholder="เบอร์ติดต่อ" />
<b>E-mail</b><input type="email" name="contact_email" id="contact_email" placeholder="email ผู้รับผิดชอบ" />

 </td> 
  </tr><tr><td></td><td colspan="4">
</td></tr>!-->

  <tr><td colspan="5" height="10"></td></tr> 
  <tr align="center">
    <td colspan="5">
    <input type="submit" id="submit" name="submit" value="บันทึก"/>
	&nbsp;
	<input type="reset" id="reset" name="reset" value="ล้างทั้งหมด"/>
	&nbsp;
	</td>
  </tr>
  <tr><td colspan="5" height="20"><hr/></td></tr> 
<?
}
?>
</table>
</form>
</td></tr>
</table>
</body>
</html>