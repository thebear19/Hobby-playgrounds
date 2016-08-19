<?php
include("connect.php");
include("button.php");
echo "<meta charset='utf-8'>";
if(isset($_POST['submit'])){
	if($_POST['plan'] == "" or $_POST['strategy'] == "" or $_POST['aim'] == "" or $_POST['fiscal_year'] == "" or $_POST['plan_type'] == "" or $_POST['strategy_number'] == "" or $_POST['strategy_type'] == "" or $_POST['strategy_status'] == "" or $_POST['aim_number'] == ""){
		echo "<script type='text/javascript'> alert('คุณยังกรอกข้อมูลไม่ครบค่ะ'); </script>";	
		echo "<script type='text/javascript'> window.history.go(-1); </script>";
	}
	else{
		if($_POST['trig'] == 1){
				$sql = "insert into annual_objective_plan values('','".$_POST['plan']."','".$_POST['fiscal_year']."','".$_POST['plan_type']."')";
				mysql_query($sql) or die(mysql_error());
				
				$rset = mysql_query("select Plan_ID from annual_objective_plan where Plan_Name = '".$_POST['plan']."'")or die(mysql_error());
				$row_id = mysql_fetch_array($rset);
				$plan_id = $row_id['Plan_ID'];
		
				$sql = "insert into strategy values('','".$_POST['strategy_number']."','".$_POST['strategy']."','".$_POST['strategy_type']."','".$_POST['strategy_status']."','".$plan_id."')";
				mysql_query($sql) or die(mysql_error());
		
				$rset = mysql_query("select Strategy_ID from strategy where Strategy_Description = '".$_POST['strategy']."'")or die(mysql_error());
				$row_id = mysql_fetch_array($rset);
				$strategy_id = $row_id['Strategy_ID'];
		
				$sql = "insert into aim values('','".$_POST['aim_number']."','".$_POST['aim']."','".$strategy_id."')";
				mysql_query($sql) or die(mysql_error());
				

				header("Location:project_insert.php");
		}else{			
			if($_POST['trig_st'] == 1){
				$rset = mysql_query("select Plan_ID from annual_objective_plan where Plan_Name = '".$_POST['plan']."'")or die(mysql_error());
				$row_id = mysql_fetch_array($rset);
				$plan_id = $row_id['Plan_ID'];
		
				$sql = "insert into strategy values('','".$_POST['strategy_number']."','".$_POST['strategy']."','".$_POST['strategy_type']."','".$_POST['strategy_status']."','".$plan_id."')";
				mysql_query($sql) or die(mysql_error());
		
				$rset = mysql_query("select Strategy_ID from strategy where Strategy_Description = '".$_POST['strategy']."'")or die(mysql_error());
				$row_id = mysql_fetch_array($rset);
				$strategy_id = $row_id['Strategy_ID'];
		
				$sql = "insert into aim values('','".$_POST['aim_number']."','".$_POST['aim']."','".$strategy_id."')";
				mysql_query($sql) or die(mysql_error());
				

				header("Location:project_insert.php");
			}
			else{
				$rset = mysql_query("select Plan_ID from annual_objective_plan where Plan_Name = '".$_POST['plan']."'")or die(mysql_error());
				$row_id = mysql_fetch_array($rset);
				$plan_id = $row_id['Plan_ID'];
		
				//$sql = "insert into strategy values('','','".$_POST['strategy']."','type','status','".$plan_id."')";
				//mysql_query($sql) or die(mysql_error());
		
				$rset = mysql_query("select Strategy_ID from strategy where Strategy_Description = '".$_POST['strategy']."'")or die(mysql_error());
				$row_id = mysql_fetch_array($rset);
				$strategy_id = $row_id['Strategy_ID'];
		
				$sql = "insert into aim values('','".$_POST['aim_number']."','".$_POST['aim']."','".$strategy_id."')";
				mysql_query($sql) or die(mysql_error());
				

				header("Location:project_insert.php");
			}
		}
		
	}
}
?>
<script type="text/javascript">
function re_plan(element)
	{
		switch(element)
		{
			<?
			$sql_plan = "select plan_id,plan_name,fiscal_year,plan_type from annual_objective_plan";
			$result_sql_plan = mysql_query($sql_plan);
			while($plan_name_row = mysql_fetch_array($result_sql_plan))
			/*echo $plan_name_row['fiscal_year'];
			echo $plan_name_row['plan_type'];*/
			{
			?>
				case "<?=$plan_name_row["plan_id"];?>":
				create.plan.value = "<?=$plan_name_row["plan_name"];?>";
				create.plan_type.value = "<?=$plan_name_row["plan_type"];?>";
				create.fiscal_year.value =  "<?=$plan_name_row["fiscal_year"];?>";
				create.trig.value = 0; 
				break;
			<?
			}
			?>
			default:
			 create.trig.value = 1;
			 create.plan.value = "";
			 create.plan_type.value = "";
			 create.fiscal_year.value =  "";
		}
	}

function re_strategy(element)
	{
		switch(element)
		{
			<?
			$sql_strategy = "select strategy_id,strategy_description,strategy_number,strategy_type,strategy_status from strategy";
			$result_sql_strategy = mysql_query($sql_strategy);
			while($strategy_name_row = mysql_fetch_array($result_sql_strategy))
			{
			?>
				case "<?=$strategy_name_row["strategy_id"];?>":
				create.strategy.value = "<?=$strategy_name_row["strategy_description"];?>";
				create.strategy_number.value = "<?=$strategy_name_row["strategy_number"];?>";
				create.strategy_type.value = "<?=$strategy_name_row["strategy_type"];?>";
				create.strategy_status.value = "<?=$strategy_name_row["strategy_status"];?>";
				create.trig_st.value = 0;
				break;
			<?
			}
			?>
			default:
			 create.strategy.value = "";
			 create.trig_st.value = 1;
			 create.strategy_number.value = "";
			 create.strategy_type.value = "";
			 create.strategy_status.value = "";
		}
	}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body<center>
<form name="create" method="post">
<table width="800" align="center" bgcolor="#e8e8e8">
<tr>
<td colspan="4" height="35">เพิ่มแผนงานใหม่ </td>
</tr>
<tr>
<td width="30"></td>
<td colspan="3"><input type="text" name="plan" id = "plan" value = "" placeholder="ชื่อแผนการดำเนินงาน"/>
<input type="text" name="fiscal_year" id = "fiscal_year" value = "" placeholder="ปีงบประมาณ (ค.ศ.)"/>
<input type="text" name="plan_type" id = "plan_type" value = "" placeholder="ประเภทของแผนดำเนินงาน"/></td>
</tr>
<tr>
<td width="30"></td>
<td colspan="3">หรือ เลือก<br/>
    <select name="plan_name" id = "plan_name" onChange="re_plan(this.value);">
	<option value="null">แผนการดำเนินงาน</option>
			<?php
			$sql_plan = "select plan_name,plan_id from annual_objective_plan";
			$result_sql_plan = mysql_query($sql_plan);
			while($plan_name_row = mysql_fetch_array($result_sql_plan)){
			?>
		 		<option value = "<?php echo $plan_name_row['plan_id']; ?>" ><?php echo $plan_name_row['plan_name']; ?></option>
            <?php 
			} 
			?>

	</select>
</td>
</tr>
<tr>
<td colspan="4" height="35">เพิ่มยุทธศาสตร์ </td>
</tr>
<tr>
<td></td>
<td colspan="3"><input type="text" name="strategy" id = "strategy" value = "" placeholder="ชื่อยุทธศาสตร์"/>
<input type="number" name="strategy_number" id = "strategy_number" value = "" placeholder="เลขยุทธศาสตร์"/>
<input type="text" name="strategy_type" id = "strategy_type" value = "" placeholder="ประเภทยุทธศาสตร์"/>
<input type="text" name="strategy_status" id = "strategy_status" value = "" placeholder="สถานะยุทธศาสตร์"/>
</tr>
<tr>
<td width="30"></td>
<td colspan="3">หรือ เลือก<br/>
    <select name="strategy_name" id = "strategy_name"  onchange="re_strategy(this.value);">
	<option value="null">ยุทธศาสตร์</option>
			<?php
			$sql_strategy = "select Strategy_Description,Strategy_ID from strategy";
			$result_sql_strategy = mysql_query($sql_strategy);
			while($strategy_name_row = mysql_fetch_array($result_sql_strategy)){
			?>
		 		<option value = "<?php echo $strategy_name_row['Strategy_ID']; ?>" ><?php echo $strategy_name_row['Strategy_Description']; ?></option>
            <?php 
			} 
			?>

	</select>
    <input type="hidden" name="trig_st" id = "trig_st" value="1" />
</td>
</tr>
<tr>
<td colspan="4" height="35">เพิ่มเป้าประสงค์ </td>
</tr>
<tr>
<td></td>
<td><input type="text" name="aim" id = "aim" placeholder="ชื่อเป้าประสงค์"/>
<input type="number" name="aim_number" id="aim_number" placeholder="เลขเป้าประสงค์" /><input type="hidden" name="trig" id="trig" value="1" /> 
</td>
</tr>
<tr>
<td height="50" colspan="4" align="center"><input type="submit" value="submit" name = "submit" />
<input type="button" id="back" name="back" value="ย้อนกลับ" onClick="javascript:window.history.go(-1);"/></td>
</tr>
</table>
</form>
</center>
</body>
</html>