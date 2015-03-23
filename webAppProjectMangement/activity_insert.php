<?php
include("connect.php");
include("button.php");
echo "<meta charset='utf-8'>";
$pass = "yes";
if(isset($_POST['submit'])){
	for($i=0;$i<(int)($_POST['row']);$i++){
		if($_POST['activity_name'.$i] == "" or $_POST["planned_starting_date".$i] == "" or $_POST["planned_ending_date".$i] == "" or $_POST["activity_location".$i] == "" or $_POST["notes".$i] == ""){
			echo "<script type='text/javascript'> alert('คุณยังกรอกข้อมูลไม่ครบค่ะ'); </script>";	
			echo "<script type='text/javascript'> window.history.go(-1); </script>";
			$pass = "no";
			break;
		}		
	}
if($pass == "yes"){
	$rset = mysql_query("select sector_project_id from sector_project where project_id = '".$_SESSION['project_id']."'")or die(mysql_error());
	$row = mysql_fetch_array($rset);
	$sector_project_id = $row['sector_project_id'];
		for($i=0;$i<(int)($_POST['row']);$i++){
	$sql = "insert into activity(Activity_ID,activity_name,planned_starting_date,planned_ending_date,activity_location,notes,section_project_id) values('','".$_POST["activity_name".$i]."','".$_POST["planned_starting_date".$i]."','".$_POST["planned_ending_date".$i]."','".$_POST["activity_location".$i]."','".$_POST["notes".$i]."','".$sector_project_id."','".$_POST["budget_name".$i]."')";
		mysql_query($sql)or die(mysql_error());
		echo $sql;
		}
		/*for($i=0;$i<(int)($_POST['row']);$i++){
			$sql = "insert into budget_project values('','".$_POST["budget_name".$i]."','".$p_id."','".$_POST["budget_num".$i]."','".$_POST["budget_type".$i]."')";
			mysql_query($sql)or die(mysql_error());
		}*/
		
		header("Location:afterstory.php");
	}
}
?>
<script type="text/javascript">
function add_activity(){
		
		var span = document.getElementById('activity');
		var row = document.getElementById('row');
		var field = document.createElement('fieldset');
		field.id = "field"+row.value;
		var activity_name = document.createElement('input');
		activity_name.setAttribute('type',"text");
		activity_name.setAttribute('id',"activity_name"+row.value);
		activity_name.setAttribute('name',"activity_name"+row.value);
		activity_name.setAttribute('placeholder',"ชื่อกิจกรรม");
		
		var plan_sd = document.createElement('input');
		plan_sd.setAttribute('type',"date");
		plan_sd.setAttribute('id',"planned_starting_date"+row.value);
		plan_sd.setAttribute('name',"planned_starting_date"+row.value);
		plan_sd.setAttribute('placeholder',"วันที่เริ่มต้น(ตามแผน)");
		
		var plan_ed = document.createElement('input');
		plan_ed.setAttribute('type',"date");
		plan_ed.setAttribute('id',"planned_ending_date"+row.value);
		plan_ed.setAttribute('name',"planned_ending_date"+row.value);
		plan_ed.setAttribute('placeholder',"วันที่สิ้นสุด(ตามแผน)");
		
		var activity_location = document.createElement('input');
		activity_location.setAttribute('type',"text");
		activity_location.setAttribute('id',"activity_location"+row.value);
		activity_location.setAttribute('name',"activity_location"+row.value);
		activity_location.setAttribute('placeholder',"สถานที่จัดกิจกรรม");
		
		var budget3  = document.createTextNode("งบประมาณ (ตัวเลข)");
		var crenum = document.createElement('input');
		crenum.setAttribute('type',"number");
		crenum.setAttribute('name',"source_of_budge"+row.value);
		crenum.setAttribute('id',"source_of_budge"+row.value);
		crenum.setAttribute('placeholder',"งบประมาณเป็นตัวเลข");
		
		var budget1 = document.createTextNode("แหล่งงบประมาณ");
		var create_name = document.createElement('select');
		create_name.setAttribute('name',"budget_name"+row.value);
		create_name.setAttribute('id',"budget_name"+row.value);
		
		var notes = document.createElement('textarea');
		notes.setAttribute('id',"notes"+row.value);
		notes.setAttribute('name',"notes"+row.value);
		notes.setAttribute('cols',"70");
		notes.setAttribute('rows',"7");
		
		var crebutt = document.createElement('br');
		crebutt.setAttribute('name',"br"+row.value);
		crebutt.setAttribute('id',"br"+row.value);
		
		
		span.appendChild(activity_name);
		span.appendChild(plan_sd);
		span.appendChild(plan_ed);
		span.appendChild(activity_location);
		field.appendChild(budget3);
		field.appendChild(crenum);
		field.appendChild(budget1);
		field.appendChild(create_name);
		addoption_name(create_name);
		span.appendChild(notes);
		span.appendChild(crebutt);
		span.appendChild(field);
		row.value++;
}

function del_activity(){
	var span = document.getElementById('activity');
	var row = document.getElementById('row');	
	if(row.value <= 1){
		alert("ไม่สามารถลบมากไปกว่านี้ได้");	
	}
	else{
	row.value--;
	var activity_name = document.getElementById('activity_name'+row.value);
	span.removeChild(activity_name);
	var plan_sd = document.getElementById('planned_starting_date'+row.value);
	span.removeChild(plan_sd);
	var plan_ed = document.getElementById('planned_ending_date'+row.value);
	span.removeChild(plan_ed);
	var activity_location = document.getElementById('activity_location'+row.value);
	span.removeChild(activity_location);
	var notes = document.getElementById('notes'+row.value);
	span.removeChild(notes);
	/*var budget3 = document.getElementById('budget3'+row.value);
	span.removeChild(budget3);
	var crenum = document.getElementById('source_of_budge'+row.value);
	span.removeChild(crenum);
	var budget1 = document.getElementById('budget1'+row.value);
	span.removeChild(budget1);
	var budget_name = document.getElementById('budget_name'+row.value);
	span.removeChild(budget_name);*/
	var delfieldb = document.getElementById('field'+row.value);
	span.removeChild(delfieldb);
	
	var br = document.getElementById('br'+row.value);
	span.removeChild(br);
	}
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


</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form name="atv" method="post">
<table width="800" align="center" bgcolor="#e8e8e8">
<tr><td height="50"><b>เพิ่มกิจกรรม</b></td></tr>
<tr><td width="120">
ชื่อกิจกรรม : 
</td>
<td><input type="text" name="activity_name0" id="activity_name0" placeholder="ชื่อกิจกรรม"  /></td>
</tr>
<tr><td>
เริ่มต้น : 
</td>
<td><input type="date" name="planned_starting_date0" id="planned_starting_date0" placeholder="วันที่เริ่มต้น(ตามแผน)"/></td>
</tr>
<tr><td>
สิ้นสุด : 
</td>
<td><input type="date" name="planned_ending_date0" id="planned_ending_date0" placeholder="วันที่สิ้นสุด(ตามแผน)"/></td>
</tr>
<tr><td>
สถานที่จัดกิจกรรม : 
</td>
<td><input type="text" name="activity_location0" id="activity_location0" placeholder="สถานที่จัดกิจกรรม" /></td>
</tr>
<tr><td>
งบประมาณ : 
</td>
<td><input type="text" name="source_of_budget0" id="source_of_budget0" placeholder="งบประมาณของแต่ละกิจกรรม" /></td>
<td>
<select name="budget_name0" id="budget_name0">
    <option value="null">แหล่งงบประมาณ</option>
	<?php
		$sql_bud_name = "select SourceOfBudget_Name,SourceOfBudget_ID from source_of_budget";
		$result_bud_name = mysql_query($sql_bud_name);
		while($bud_name_row = mysql_fetch_array($result_bud_name)){
		?>
        	<option value = "<?php echo $bud_name_row['SourceOfBudget_ID']; ?>" ><?php echo $bud_name_row['SourceOfBudget_Name']; ?></option>
        <?php	
		}
	?>
</select>
</td>
</tr>
<tr><td valign="top">
ข้อมูลกิจกรรม : 
</td>
<td><textarea name="notes0" cols="70" rows="7" id="notes0"></textarea></td>
</tr>
<tr>
<td colspan="2"><hr/></td>
</tr>
<tr><td colspan="2" height="50">
<span id="activity"></span>
<input type="hidden" name="row" id="row" value="1" />
<input type="button" name="add_atv" value="เพิ่มกิจกรรม" onClick="add_activity()" />
<input type="button" name="del_atv" value="ลบกิจกรรม" onClick="del_activity()" />
<input type="submit" name="submit" value="submit" />
</td></tr>
</table>
</form>
</body>
</html>