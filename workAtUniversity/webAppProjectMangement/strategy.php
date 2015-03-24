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
	$sql_id = "select strategy_id from strategy where Strategy_Description='".$_POST['strategy']."'";
	$result_id = mysql_query($sql_id);
	$id = mysql_fetch_array($result_id);	
	$_SESSION['strategy'] = $_POST['strategy'];
	$_SESSION['strategy_id'] = $id['strategy_id'];
	header("Location:aim.php");
}
?>
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<!--<script type="text/javascript">
function addoption(element){
	var objselect = element;
	var data = new Option("","");
	objselect.options[objselect.length] = data;
	<?php
			$sql = "select Strategy_Description from strategy";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
	?>
	
				var data = new Option("<?php  echo $row['Strategy_Description']; ?>","<?php  echo $row['Strategy_Description']; ?>");
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
	create.setAttribute('name',"strategy"+row.value);
	create.setAttribute('id',"str"+row.value);
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
	if(row.value <= 0){
	alert("cannot delete more");	
	}
	else{
	
	var del = document.getElementById('str'+row.value);
	alert("test");
	show.removeChild(del);
	var delbr = document.getElementById('br'+row.value);
	show.removeChild(delbr);
	row.value--;
	}
}
</script>!-->
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
        	<li><?php echo $_SESSION['plan']; ?></li>
        </ul>
</ul>
<form name="choose" method="post">
<!--<select name="strategy0">!-->
<select name="strategy">
<option value="null">โปรดเลือก</option>
			<?php
			$sql = "select Strategy_Description from strategy where plan_id = '".$_SESSION['plan_id']."'";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
			?>
		 		<option value = "<?php echo $row['Strategy_Description']; ?>" ><?php echo $row['Strategy_Description']; ?></option>
            <?php 
			} 
			?>
</select>
<!--<br /><span id="select"></span>
<t><input type="hidden" name = "row" id="row" value="1" />
<input type="button" value="add" name = "add" id="add" onClick="addselect()"/>
<input type="button" value="delete" name = "del" id="del" onClick="deleted()" />!-->
<br />
<input type="submit" name="next" value="next" />
</form>

</body>
</html>