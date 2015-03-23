<?php
session_start();
$_SESSION['plan'] = $_POST['data0'];
if($_POST['data0'] == "null"){
	echo "<select multiple='multiple' style='width:300px;,height:50px;' name='box'>";

}else{
	echo "<select multiple='multiple' style='width:300px;,height:50px;' name='box'>
        <option value=".$_POST['data0'].">".$_POST['data0']."</option>
        </select>";
  /*<div id="showSelected" style="border:1px solid blue;display:block;width:250px;height:30px;">
  </div>
  <script language="javascript">
  $("#multilist").change(function(){
	var str = "";
	$("#multilist option:selected").each(function(){
		str += $(this).text()+" ";
	});
	$("#showSelected").text(str);
	
  });
  </script>!-->*/

}
?>