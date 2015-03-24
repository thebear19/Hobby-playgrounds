<?php
session_start();
mysql_connect("localhost","root","") or die(mysql_error());
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");
mysql_select_db("gpm");
mysql_query("SET NAMES UTF8");
echo "<meta charset='utf-8'>";
if(isset($_POST['next'])){
	$_SESSION['count'] = (int)($_POST['row']);
		for($i=0;$i<(int)($_POST['row']);$i++){
				$_SESSION["aim".$i] = $_POST["aim".$i];
				$sql_id = "select aim_id from aim where Aim_Description	='".$_POST["aim".$i]."'";
				$result_id = mysql_query($sql_id);
				$id = mysql_fetch_array($result_id);
				$_SESSION["aim_id".$i] = $id['aim_id'];
		}
		header("Location:project_insert.php");
}
?>
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script type="text/javascript">
function addoption(element){
	var objselect = element;
	var data = new Option("","");
	objselect.options[objselect.length] = data;
	<?php
			$sql = "select Aim_Description from aim where strategy_id = '".$_SESSION['strategy_id']."'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
	?>
	
				var data = new Option("<?php  echo $row['Aim_Description']; ?>","<?php  echo $row['Aim_Description']; ?>");
				objselect.options[objselect.length] = data;
	
	<?php 
			} 
	?> 	
}
function addselect(){
	var row = document.getElementById('row');
	//row.value++;
	var show = document.getElementById('select');
	var create = document.createElement('select');
	create.setAttribute('name',"aim"+row.value);
	create.setAttribute('id',"aim"+row.value);
	show.appendChild(create);
	addoption(create);
	var crebutt = document.createElement('br');
	crebutt.setAttribute('name',"br"+row.value);
	crebutt.setAttribute('id',"br"+row.value);
	show.appendChild(crebutt);
	row.value++;
	alert(create.name);
}

function deleted(){
	var row = document.getElementById('row');
	var show = document.getElementById('select');
	if(row.value <= 1){
	alert("cannot delete more");	
	}
	else{	
	row.value--;
	var del = document.getElementById('aim'+row.value);
	show.removeChild(del);
	var delbr = document.getElementById('br'+row.value);
	show.removeChild(delbr);
	}
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<ul>
	<li>แผนการดำเนินงาน</li>
    	<ul>
        	<li><?php  echo $_SESSION['plan']; ?></li>
        </ul>
    <li>ยุทธศาสตร์</li>
    	<ul>
        	<li><?php  echo $_SESSION['strategy']; ?></li>
        </ul>
</ul>
<form name="choose" method="post">
<select name="aim0">
<option value="null">โปรดเลือก</option>
			<?php
			$sql = "select Aim_Description from aim where strategy_id = '".$_SESSION['strategy_id']."'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
			?>
		 		<option value = "<?php echo $row['Aim_Description']; ?>" ><?php echo $row['Aim_Description']; ?></option>
            <?php 
			} 
			?>
</select>
<br /><span id="select"></span>
<input type="hidden" name = "row" id="row" value="1" />
<input type="button" value="add" name = "add" id="add" onClick="addselect()"/>
<input type="button" value="delete" name = "del" id="del" onClick="deleted()" />
<input type="submit" name="next" value="next" />
</form>
</body>
</html>