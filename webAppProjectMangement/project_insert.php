<?
session_start();
//include("connect.php");
mysql_connect("localhost","root","") or die(mysql_error());
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");
mysql_select_db("gpm");
mysql_query("SET NAMES UTF8");
include("button.php");
echo "<meta charset='utf-8'>";
if(isset($_POST['submit'])){
	if($_POST['project_name'] == "" or $_POST['Project_Principles_Rationale'] == "" or $_POST['Project_Location'] == "" or $_POST['project_type'] == "" or $_POST['Project_Manager'] == "" or $_POST['Project_Coordinator'] == "" or $_POST['Project_Target'] == "" or $_POST['Consistency_With_Overall_Objective'] == "" or $_POST['Notes'] == "" or $_POST['Expected_Outcome_Result'] == "" or $_POST['Expected_Output_Result'] == "" or $_POST['Reserved_Fund'] == "" or $_POST['Outcome_Indicator'] == "" or $_POST['Productive_Indicator'] == "" or $_POST['Task_Force'] == "" or $_POST['Project_Tracking_And_Evalution'] == "" or $_POST['Anticipated_Deliverable'] == "" or $_POST['Return_On_Project'] == "" or $_POST["aim_name"] == "" or $_POST["strategy_name"] == "" or $_POST["plan_name"] == "" or $_POST["Project_Goal"] == "" or $_POST['fiscal_year'] == ""){
		echo "<script type='text/javascript'> alert('คุณยังกรอกข้อมูลไม่ครบค่ะ'); </script>";	
		echo "<script type='text/javascript'> window.history.go(-1); </script>";	
	}
	else{
	//insert to table project
	$sql = "insert into project values('','".$_POST['project_name']."','".$_POST["Project_Goal"]."','".$_POST['Project_Principles_Rationale']."','".$_POST['Project_Location']."','on going','".$_POST['project_type']."','".$_POST['Project_Manager']."','".$_POST['Project_Coordinator']."','".$_POST['Project_Target']."','".$_POST['Consistency_With_Overall_Objective']."','".$_POST['Notes']."','".$_POST['Expected_Outcome_Result']."','".$_POST['Expected_Output_Result']."','".$_POST['Reserved_Fund']."','".$_POST['Outcome_Indicator']."','".$_POST['Productive_Indicator']."','".$_POST['Task_Force']."','".$_POST['Project_Tracking_And_Evalution']."','".$_POST['Anticipated_Deliverable']."','".$_POST['Return_On_Project']."','0')";
	$reinsert_pro = mysql_query($sql)or die(mysql_error());
	if($reinsert_pro){
		$rset = mysql_query("select project_id from project where project_name = '".$_POST['project_name']."'")or die(mysql_error());
		$row_id = mysql_fetch_array($rset);
		$p_id = $row_id['project_id'];
		$_SESSION['project_id'] = $p_id;
		//insert to aim_project
		//$count = $_POST['row_aim'];
		//for($i=0;$i<$count;$i++){
			$aim_id = $_POST["aim_name"];
			$sql = "insert into aim_project values('','".$aim_id."','".$p_id."','')";
			mysql_query($sql)or die(mysql_error());
		//}
		
		//insert to fiscal_year_project
		$year = $_POST['fiscal_year'];
		$year = $year-543;
		$sql = "insert into fiscal_year_project(Project_ID,fiscal_year,Planned_Starting_Date,Planned_Ending_Date) values('".$p_id."','".$year."','".$_POST['Planned_Starting_Date']."','".$_POST['Planned_Ending_Date']."')";
		mysql_query($sql)or die(mysql_error());
		
		
		//insert into project_goal
		/*$j = 1;
		for($i=0;$i<(int)($_POST['row_goal']);$i++){
			$sql = "insert into project_goal values('".$p_id."','".$j."','".$_POST["Project_Goal".$i]."')";
			mysql_query($sql)or die(mysql_error());
			$j++;
		}*/
		
		//insert into sector_project
		foreach($_POST['check'] as $govern){
			$sql = "insert into sector_project values('','".$govern."','".$p_id."','".$_POST['contact_name']."','".$_POST['contact_phone_number']."','".$_POST['contact_email']."','1')";
			mysql_query($sql)or die(mysql_error());
		}
		$rset = mysql_query("select Sector_Project_ID from sector_project where Project_ID = '".$p_id."'")or die(mysql_error());
		$row_id = mysql_fetch_array($rset);
		$sp_id = $row_id['Sector_Project_ID'];
		$_SESSION['sector_project_id'] = $sp_id;

		
		//insert into budget_project
		/*for($i=0;$i<(int)($_POST['row']);$i++){
			$sql = "insert into budget_project values('','".$_POST["budget_name".$i]."','".$p_id."','".$_POST["budget_num".$i]."','".$_POST["budget_type".$i]."')";
			mysql_query($sql)or die(mysql_error());
		}*/

		header("Location:activity_insert.php");
		}else{
			echo "sql command error";
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
<title>Untitled Document</title>
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script type="text/javascript">
function sel_strategy(){
	var defaultOption = '<option value=""> ------- เลือก ------ </option>';
	// Bind an event handler to the "change" JavaScript event, or trigger that event on an element.
		$("#strategy_name").html(defaultOption);
		$("#aim_name").html(defaultOption);
		// Perform an asynchronous HTTP (Ajax) request.
		$.ajax({
			// A string containing the URL to which the request is sent.
			url: "select_staim.php",
			// Data to be sent to the server.
			data: ({ nextList : 'strategy', plan_id: $('#plan_name').val() }),
			// The type of data that you're expecting back from the server.
			dataType: "json",
			success: function(json){
				// Iterate over a jQuery object, executing a function for each matched element.
				$.each(json, function(index, value) {
					// Insert content, specified by the parameter, to the end of each element
					// in the set of matched elements.
					 $("#strategy_name").append('<option value="' + value.Strategy_ID + 
											'">' + value.Strategy_Description + '</option>');
				});
			}
		});
}
function sel_aim(){
	var defaultOption = '<option value=""> ------- เลือก ------ </option>';
		$("#aim_name").html(defaultOption);
		$.ajax({
			url: "select_staim.php",
			data: ({ nextList : 'aim', strategy_id: $('#strategy_name').val() }),
			dataType: "json",
			success: function(json){
				$.each(json, function(index, value) {
					 $("#aim_name").append('<option value="' + value.Aim_ID + 
											'">' + value.Aim_Description + '</option>');
				});
			}
		});
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
/*function addselect(){
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

	var create = document.createElement('input');
	create.setAttribute('type',"text");
	create.setAttribute('name',"budget_type"+row.value);
	create.setAttribute('id',"budget_type"+row.value);
	create.setAttribute('placeholder',"ประเภทงบประมาณ");

	var crenum = document.createElement('input');
	crenum.setAttribute('type',"number");
	crenum.setAttribute('name',"budget_num"+row.value);
	crenum.setAttribute('id',"budget_num"+row.value);
	crenum.setAttribute('placeholder',"งบประมาณเป็นตัวเลข");



	field.appendChild(budget2);
	field.appendChild(create);
	field.appendChild(budget1);
	field.appendChild(create_name);
	addoption_name(create_name);
	field.appendChild(crebutt);
	field.appendChild(budget3);
	field.appendChild(crenum);
	//show.appendChild(crebutt);
	row.value++;
	show.appendChild(field);
}*/

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


/*function addplan(){
	var plan = document.getElementById('plan');
	var row = document.getElementById('row_plan');
	var field = document.createElement('fieldset');
	var descript = document.createTextNode("แผนการดำเนินงาน");
	field.id = "field_plan"+row.value;
	var create = document.createElement('select');
	create.setAttribute('id',"plan_name"+row.value);
	create.setAttribute('name',"plan_name"+row.value);
	field.appendChild(descript);
	field.appendChild(create);
	add_select_plan(create);
	plan.appendChild(field);
	row.value++;
}

function deleteplan(){
	var plan = document.getElementById('plan');
	var row = document.getElementById('row_plan');
	if(row.value <= 1){
		alert("ไม่สามารถลบมากไปกว่านี้ได้");	
	}
	else{
	row.value--;
	var field = document.getElementById('field_plan'+row.value);
	plan.removeChild(field);	
	}
}
function add_select_plan(element){
	var objselect = element;
	var data = new Option("แผนการดำเนินงาน","null");
	objselect.options[objselect.length] = data;
	<?php
		/*$sql_plan = "select plan_name,plan_id from annual_objective_plan";
		$result_sql_plan = mysql_query($sql_plan);
		while($plan_name_row = mysql_fetch_array($result_sql_plan)){
		?>
        	var data = new Option("<?php echo $plan_name_row['plan_name']; ?>","<?php echo $plan_name_row['plan_id']; ?>");
			objselect.options[objselect.length] = data;
        <?php	
		}*/
	?>
}

function addstrategy(){
	var strategy = document.getElementById('strategy');
	var row = document.getElementById('row_strategy');
	var field = document.createElement('fieldset');
	var descript = document.createTextNode("ยุทธศาสตร์");
	field.id = "field_strategy"+row.value;
	var create = document.createElement('select');
	create.setAttribute('id',"strategy_name"+row.value);
	create.setAttribute('name',"strategy_name"+row.value);
	field.appendChild(descript);
	field.appendChild(create);
	add_select_strategy(create);
	strategy.appendChild(field);
	row.value++;
}

function deletestrategy(){
	var strategy = document.getElementById('strategy');
	var row = document.getElementById('row_strategy');
	if(row.value <= 1){
		alert("ไม่สามารถลบมากไปกว่านี้ได้");	
	}
	else{
	row.value--;
	var field = document.getElementById('field_strategy'+row.value);
	strategy.removeChild(field);	
	}
}
function add_select_strategy(element){
	var objselect = element;
	var data = new Option("ยุทธศาสตร์","null");
	objselect.options[objselect.length] = data;

	<?php
		/*$sql_strategy = "select Strategy_Description,Strategy_ID from strategy";
			$result_sql_strategy = mysql_query($sql_strategy);
			while($strategy_name_row = mysql_fetch_array($result_sql_strategy)){
		?>
        	var data = new Option("<?php echo $strategy_name_row['Strategy_Description']; ?>","<?php echo $strategy_name_row['Strategy_ID']; ?>");
			objselect.options[objselect.length] = data;
        <?php	
		}*/
	?>
}

function addaim(){
	var aim = document.getElementById('aim');
	var row = document.getElementById('row_aim');
	var field = document.createElement('fieldset');
	var descript = document.createTextNode("เป้าประสงค์");
	field.id = "field_aim"+row.value;
	var create = document.createElement('select');
	create.setAttribute('id',"aim_name"+row.value);
	create.setAttribute('name',"aim_name"+row.value);
	field.appendChild(descript);
	field.appendChild(create);
	add_select_aim(create);
	aim.appendChild(field);
	row.value++;
}

function deleteaim(){
	var aim = document.getElementById('aim');
	var row = document.getElementById('row_aim');
	if(row.value <= 1){
		alert("ไม่สามารถลบมากไปกว่านี้ได้");	
	}
	else{
	row.value--;
	var field = document.getElementById('field_aim'+row.value);
	aim.removeChild(field);
	}
}
function add_select_aim(element){
	var objselect = element;
	var data = new Option("เป้าประสงค์","null");
	objselect.options[objselect.length] = data;
	<?php
		/*$sql_aim = "select aim_id,Aim_Description from aim";
			$result_sql_aim = mysql_query($sql_aim);
			while($aim_name_row = mysql_fetch_array($result_sql_aim)){
		?>
        	var data = new Option("<?php echo $aim_name_row['Aim_Description']; ?>","<?php echo $aim_name_row['aim_id']; ?>");
			objselect.options[objselect.length] = data;
        <?php	
		}*/
	?>
}*/

/*function addgoal(){
	var row = document.getElementById('row_goal');
	var span = document.getElementById('goal');
	var create = document.createElement('input');
	create.setAttribute('type',"text");
	create.setAttribute('id',"Project_Goal"+row.value);
	create.setAttribute('name',"Project_Goal"+row.value);
	create.setAttribute('placeholder',"โปรดใส่วัตถุประสงค์");
	var crebutt = document.createElement('br');
	crebutt.setAttribute('name',"br_goal"+row.value);
	crebutt.setAttribute('id',"br_goal"+row.value);
	span.appendChild(create);
	span.appendChild(crebutt);
	row.value++;
}

function deletegoal(){
	var row = document.getElementById('row_goal');
	var span = document.getElementById('goal');	
	if(row.value <= 1){
		alert("ไม่สามารถลบมากไปกว่านี้ได้");	
	}
	else{
		row.value--;
		var goal = document.getElementById('Project_Goal'+row.value);
		var br = document.getElementById('br_goal'+row.value);
		span.removeChild(goal);
		span.removeChild(br);
	}
}*/
</script>
</head>
<body>
<form name="insertform" method="post">
<table width="800" border="0" cellspacing="3" cellpadding="2" align="center">
<tr><td>
<table width="800" border="0" cellspacing="3" cellpadding="2" align="center" bgcolor="#e8e8e8">
<tr valign="top"><td height="10"></td></tr>

  <tr valign="top">
    <td width="240" height="45"><b>แผนงาน</b></td>
    <td colspan="4">
    แผนการดำเนินงาน<select name="plan_name" id = "plan_name" onchange="sel_strategy()">
	<option value="">แผนการดำเนินงาน</option>
			<?php
			$sql_plan = "select plan_name,plan_id from annual_objective_plan";
			$result_sql_plan = mysql_query($sql_plan);
			while($plan_name_row = mysql_fetch_array($result_sql_plan)){
			?>
		 		<option value = "<?php echo $plan_name_row['plan_id']; ?>" ><?php echo $plan_name_row['plan_name']; ?></option>
            <?php 
			} 
			?>

	</select>หรือ <span id="plan"><!--<input type="hidden" name = "row_plan" id="row_plan" value="1" />
	    <input type="button" value="เพิ่มแผนงาน" name = "add_pl" id="add_pl" onClick="addplan()"/>
	    <input type="button" value="ลบแผนงาน" name = "del_pl" id="del_pl" onClick="deleteplan()" />!--> หรือ <a href="create_plan.php">สร้างแผนใหม่</a></span>
       
    </td>
  </tr>
  <tr valign="top">
    <td height="45"><b>ยุทธศาสตร์</b></td>
    <td colspan="4">
    ยุทธศาสตร์<select name="strategy_name" id = "strategy_name" onchange="sel_aim()">
	<option value="">ยุทธศาสตร์</option>
			<?php
			/*$sql_strategy = "select Strategy_Description,Strategy_ID from strategy";
			$result_sql_strategy = mysql_query($sql_strategy);
			while($strategy_name_row = mysql_fetch_array($result_sql_strategy)){
			?>
		 		<option value = "<?php echo $strategy_name_row['Strategy_ID']; ?>" ><?php echo $strategy_name_row['Strategy_Description']; ?></option>
            <?php 
			} */
			?>

	</select><span id="strategy"><!--<input type="hidden" name = "row_strategy" id="row_strategy" value="1" />
	    <input type="button" value="เพิ่มยุุทธศาสตร์" name = "add_st" id="add_st" onClick="addstrategy()"/>
	    <input type="button" value="ลบยุทธศาสตร์" name = "del_st" id="del_st" onClick="deletestrategy()" /> หรือ <a href="create_plan.php">สร้างยุทธศาสตร์ใหม่</a>!--></span>
    </td>
  </tr>
  <tr valign="top">
    <td height="45"><b>เป้าประสงค์</b></td><td colspan="4">
    เป้าประสงค์<select name="aim_name" id = "aim_name">
	<option value="">เป้าประสงค์</option>
			<?php
			/*$sql_aim = "select aim_id,Aim_Description from aim";
			$result_sql_aim = mysql_query($sql_aim);
			while($aim_name_row = mysql_fetch_array($result_sql_aim)){
			?>
		 		<option value = "<?php echo $aim_name_row['aim_id']; ?>" ><?php echo $aim_name_row['Aim_Description']; ?></option>
            <?php 
			} */
			?>

	</select><span id="aim"><!--<input type="hidden" name = "row_aim" id="row_aim" value="1" />
	    <input type="button" value="เพิ่มยุุทธศาสตร์" name = "add_aim" id="add_aim" onClick="addaim()"/>
	    <input type="button" value="ลบยุทธศาสตร์" name = "del_aim" id="del_aim" onClick="deleteaim()" /> หรือ <a href="create_plan.php">สร้างเป้าประสงค์ใหม่</a>!--></span>
  </tr>
  <tr valign="top">
    <td height="45"><b>ชื่อโครงการ</b></td>
    <td colspan="4"><input type="text" name="project_name" size = "100"/></td>
  </tr>  
   <tr valign="top">
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
  </tr>
  <tr valign="top">
    <td height="35"><b>หลักการและเหตุผล</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Project_Principles_Rationale" name="Project_Principles_Rationale" wrap="hard"></textarea></td>
  </tr>  
  <tr valign="top">
    <td height="35"><b>วัตถุประสงค์</b></td>
    <td colspan="4"><input type="text" id="Project_Goal" name="Project_Goal" placeholder="โปรดใส่วัตถุประสงค์"/>
    	<!--<br />
    	<span id="goal"></span>
     	<input type="hidden" name = "row_goal" id="row_goal" value="1" />
	    <input type="button" value="เพิ่มวัตถุประสงค์" name = "add_gl" id="add_gl" onClick="addgoal()"/>
	    <input type="button" value="ลบวัตถุประสงค์" name = "del_gl" id="del_gl" onClick="deletegoal()" />!-->
    </td>
  </tr>
  <tr valign="top">
    <td height="35"><b>สถานที่จัดทำโครงการ</b></td>
    <td colspan="4"><input type="text" name="Project_Location" size = "60"/></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>เจ้าหน้าที่<br/>ผู้รับผิดชอบโครงการ</b></td>
    <td colspan="4"><input type="text" name="Project_Manager" size = "60"/></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ผู้ประสานงานโครงการ</b></td>
    <td colspan="4"><input type="text" name="Project_Coordinator" size = "60"/></td>
  </tr>
   <tr valign="top">
    <td height="35"><b>วันเริ่มโครงการ(ตามแผน)</b></td>
    <td colspan="4"><input type="date" name="Planned_Starting_Date" size = "60"/></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>วันสิ้นสุดโครงการ(ตามแผน)</b></td>
    <td colspan="4"><input type="date" name="Planned_Ending_Date" size = "60"/></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ปีงบประมาณ(พศ)</b></td>
    <td colspan="4"><input type="number" name="fiscal_year" size = "60" maxlength="4"/></td>
  </tr>
  <!--<tr valign="top">
    <td height="35"><b>แหล่งงบประมาณ<br/>และจำนวณงบประมาณ</b></td>
    <td width="200"  colspan="4">
	ประเภทงบประมาณ<input type="text" name="budget_type0" id="budget_type0" placeholder="ประเภทงบประมาณ"/>
    แหล่งงบประมาณ<select name="budget_name0" id="budget_name0">
    <option value="null">แหล่งงบประมาณ</option>
	<?php
		/*$sql_bud_name = "select SourceOfBudget_Name,SourceOfBudget_ID from source_of_budget";
		$result_bud_name = mysql_query($sql_bud_name);
		while($bud_name_row = mysql_fetch_array($result_bud_name)){
		?>
        	<option value = "<?php echo $bud_name_row['SourceOfBudget_ID']; ?>" ><?php echo $bud_name_row['SourceOfBudget_Name']; ?></option>
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
  </tr>-->
  <tr valign="top">
    <td height="35"><b>เป้าหมายของโครงการ</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Project_Target" name="Project_Target" wrap="hard"></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ความสอดคล้องกับเป้าหมายส่วนรวม</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Consistency_With_Overall_Objective" name="Consistency_With_Overall_Objective" wrap="hard"></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>คำอธิบาย</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Notes" name="Notes" wrap="hard"></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ผลสัมฤทธิ์ของงานที่คาดหวังด้านผลลัพธ์</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Expected_Outcome_Result" name="Expected_Outcome_Result" wrap="hard"></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ผลสัมฤทธิ์ของงานที่คาดหวังด้าน์ผลผลิต</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Expected_Output_Result" name="Expected_Output_Result" wrap="hard"></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>เงินสำรองกันปี</b></td>
    <td colspan="4"><input type="number" id="Reserved_Fund" name="Reserved_Fund" placeholder="จำนวนเงินเป็นตัวเลข"/></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ตัวชี้วัดผลลัพธ์</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Outcome_Indicator" name="Outcome_Indicator" wrap="hard"></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ตัวชี้วัดผลผลิต</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Productive_Indicator" name="Productive_Indicator" wrap="hard"></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>อัตรากำลังของโครงการ</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Task_Force" name="Task_Force" wrap="hard"></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>การติดตามและประเมินผลโครงการ</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Project_Tracking_And_Evalution" name="Project_Tracking_And_Evalution" wrap="hard"></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ผลที่คาดว่าจะได้รับ</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Anticipated_Deliverable" name="Anticipated_Deliverable" wrap="hard"></textarea></td>
  </tr>  
  <tr valign="top">
    <td height="35"><b>ผลตอบแทน</b></td>
    <td colspan="4"><textarea cols="90" rows="7" id="Return_On_Project" name="Return_On_Project" wrap="hard"></textarea></td>
  </tr>
  <tr valign="top">
    <td height="35"><b>ชื่อผู้รับผิดชอบโครงการ</b></td>    
    <td colspan="4"><b>ชื่อ</b>
    <input type="text" name="contact_name" id="contact_name" placeholder="ชื่อผู้รับผิดชอบ" />
<b>เบอร์โทร</b><input type="text" name="contact_phone_number" id="contact_phone_number" placeholder="เบอร์ติดต่อ" />
<b>E-mail</b><input type="email" name="contact_email" id="contact_email" placeholder="email ผู้รับผิดชอบ" />

 </td> 
  </tr><tr><td></td><td colspan="4">
</td></tr>

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

</table>
</form>
</td></tr>
</table>
</body>
</html>