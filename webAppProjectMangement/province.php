<?php
// Load jQuery library from google.
$jqLib = 'https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js';

// Create connection connect to mysql database
$dbCon = mysql_connect('localhost', 'root', '') or die (mysql_error());

// Select database.
mysql_select_db('tutor', $dbCon) or die (mysql_error());

// Set encoding.
mysql_query('SET NAMES UTF8');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dependent dropdownlist จังหวัด อำเภอ ตำบล</title>
<script type="text/javascript" src="<?php echo $jqLib; ?>"></script>
<script type="text/javascript">
 // Specify a function to execute when the DOM is fully loaded.
function sel_district(element,element1,element2){
	var row = element.substring(8,9);
	var name = element.substring(0,8);
	var district = element1.substring(0,8);
	var sub_dis = element2.substring(0,12);
	//alert(district+row);
	//alert(sub_dis+row);
	var defaultOption = '<option value=""> ------- เลือก ------ </option>';
	// Bind an event handler to the "change" JavaScript event, or trigger that event on an element.
		$("#district"+row).html(defaultOption);
		$("#sub_district"+row).html(defaultOption);
		// Perform an asynchronous HTTP (Ajax) request.
		$.ajax({
			// A string containing the URL to which the request is sent.
			url: "provinceshow.php",
			// Data to be sent to the server.
			data: ({ nextList : 'amphur', provinceID: $('#'+name+row).val() }),
			// The type of data that you're expecting back from the server.
			dataType: "json",
			success: function(json){
				// Iterate over a jQuery object, executing a function for each matched element.
				$.each(json, function(index, value) {
					// Insert content, specified by the parameter, to the end of each element
					// in the set of matched elements.
					 $("#district"+row).append('<option value="' + value.AMPHUR_ID + 
											'">' + value.AMPHUR_NAME + '</option>');
				});
			}
		});
}
function sel_sub_district(element,element1){
	var row = element.substring(8,9);
	//alert(row);
	var name = element.substring(0,8);
	//alert(name);
	var district = element1.substring(0,8);
	var sub_dis = element1.substring(0,12);
	var defaultOption = '<option value=""> ------- เลือก ------ </option>';
		$("#sub_district"+row).html(defaultOption);
		$.ajax({
			url: "provinceshow.php",
			data: ({ nextList : 'tumbon', amphurID: $('#'+name+row).val() }),
			dataType: "json",
			success: function(json){
				$.each(json, function(index, value) {
					 $("#sub_district"+row).append('<option value="' + value.DISTRICT_ID + 
											'">' + value.DISTRICT_NAME + '</option>');
				});
			}
		});
}

function addoption_pro(element){
	var objselect = element;
	var data = new Option("จังหวัด","null");
	objselect.options[objselect.length] = data;
	<?php
		$sql = "SELECT
					PROVINCE_ID,
					PROVINCE_NAME
				FROM 
					province
				ORDER BY CONVERT(PROVINCE_NAME USING TIS620) ASC;";
		$result_demo = mysql_query($sql);
		while($demo_row = mysql_fetch_array($result_demo)){
		?>
        	var data = new Option("<?php echo $demo_row['PROVINCE_NAME']; ?>","<?php echo $demo_row['PROVINCE_ID']; ?>");
			objselect.options[objselect.length] = data;
        <?php	
		}
	?>

}

function addoption_dis(element){
	var objselect = element;
	var data = new Option("เขต","");
	objselect.options[objselect.length] = data;

}

function addoption_sub(element){
	var objselect = element;
	var data = new Option("แขวง","");
	objselect.options[objselect.length] = data;
}


function added(){
	
	var row = document.getElementById('row');

	var show = document.getElementById('demo');
	var field = document.createElement('fieldset');
	field.id = "field"+row.value;
	
	var crebutt = document.createElement('br');
	crebutt.setAttribute('name',"br"+row.value);
	crebutt.setAttribute('id',"br"+row.value);
	
	var create_pro = document.createElement('select');
	create_pro.setAttribute('name',"province"+row.value);
	create_pro.setAttribute('id',"province"+row.value);
	create_pro.setAttribute('onchange',"sel_district(this.id,district"+row.value+".id,sub_district"+row.value+".id)");
	
	var create_dis = document.createElement('select');
	create_dis.setAttribute('name',"district"+row.value);
	create_dis.setAttribute('id',"district"+row.value);
	create_dis.setAttribute('onchange',"sel_sub_district(this.id,sub_district"+row.value+".id)");
	
	var create_sub = document.createElement('select');
	create_sub.setAttribute('name',"sub_district"+row.value);
	create_sub.setAttribute('id',"sub_district"+row.value);
	

	field.appendChild(create_pro);
	addoption_pro(create_pro);
	field.appendChild(create_dis);
	addoption_dis(create_dis);
	field.appendChild(create_sub);
	addoption_sub(create_sub);
	field.appendChild(crebutt);
	//show.appendChild(crebutt);
	row.value++;
	show.appendChild(field);
}

function dele(){
	var row = document.getElementById('row');
	var show = document.getElementById('demo');

	if(row.value <= 1){
	alert("cannot delete more");	
	}
	else{
	row.value--;
	var delfieldb = document.getElementById('field'+row.value);
	show.removeChild(delfieldb);
	}
}

</script>
<style type="text/css">
	body {
		font-family: Verdana, Geneva, sans-serif;
		font-size: 13px;
	}
</style>
</head>

<body>
	<label>จังหวัด : </label>
    <select id="province0" onchange="sel_district(this.id,district0.id,sub_district0.id)">
    	<option value=""> ------- เลือก ------ </option>
        <?php
			$result = mysql_query("
				SELECT
					PROVINCE_ID,
					PROVINCE_NAME
				FROM 
					province
				ORDER BY CONVERT(PROVINCE_NAME USING TIS620) ASC;
			");
			
			while($row = mysql_fetch_assoc($result)){
				echo '<option value="', $row['PROVINCE_ID'], '">', $row['PROVINCE_NAME'],'</option>';
			}
		?>
    </select>
        
    <label>อำเภอ : </label>
    <select id="district0" onchange="sel_sub_district(this.id,sub_district0.id)">
    	<option value=""> ------- เลือก ------ </option>
    </select>
    
    <label>ตำบล : </label>
    <select id="sub_district0">
    	<option value=""> ------- เลือก ------ </option>
    </select>
    <br />
    <span id="demo"><input type="hidden" name = "row" id="row" value="1" />
	    <input type="button" value="เพิ่ม" name = "added" id="added" onClick="added()"/>
	    <input type="button" value="ลบ" name = "dele" id="dele" onClick="dele()" /> หรือ <a href="demo.php">สร้าง</a></span>
</body>
</html>