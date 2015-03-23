<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script language="javascript">
var objRequest = createRequestObject();
var str;

function createRequestObject(){
	var objTemp = false;
	
	if(window.XMLHttpRequest){
		objTemp = new XMLHttpRequest();
	}
	else if(window.ActiteXObject){
		objTemp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return objTemp;
}
function getData(){
	if(objRequest){
		objRequest.open("GET","sdupdate.php?APN="+str);
		objRequest.onreadystatechange=handleResponse;
		objRequest.send(null);
	}
}
function setData(){
	str = document.up.toup.value;
}

function handleResponse(){
	var objDiv = document.getElementById("targetDiv");
	
	if(objRequest.readyState==4&&objRequest.status==200){
		objDiv.innerHTML = objRequest.responseText;
	}
}
</script>
</head>

<body>

<form id="up" name="up" method="post" action="">
  <div align="center"><p><h3><font color="#009900">Update Application Permit Number</font></h3></p>
    <input type="text" name="toup" id="toup" onblur="setData()"/> 
   
  <input type="button" name="update" value="Update" onclick="getData()"/>
  </div>
</form>
<br />
<div id="targetDiv"> &nbsp; </div>
</body>
</html>