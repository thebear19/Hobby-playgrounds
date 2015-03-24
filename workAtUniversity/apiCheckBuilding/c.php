<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>กรมที่ดิน</title>
<?php
session_start();
if($_SESSION['content']=="read.php"){
$_SESSION['content']='Read';
$_SESSION['ddsh']=$_POST['ddsh'];
$_SESSION['mmsh']=$_POST['mmsh'];
$_SESSION['yysh']=$_POST['yysh'];
}
else if($_SESSION['content']=="delete.php"){
$_SESSION['content']='Delete';
$_SESSION['APN']=$_POST['tode'];
}
else if($_SESSION['content']=="update.php"){
$_SESSION['content']='Update';
$_SESSION['APN']=$_POST['APN'];
$_SESSION['permit']=$_POST['permit'];
$_SESSION['address']=$_POST['address'];
$_SESSION['desc']=$_POST['desc'];
$_SESSION['cat']=$_POST['cat'];
$_SESSION['act']=$_POST['act'];
$_SESSION['work']=$_POST['work'];
$_SESSION['val']=$_POST['val'];
$_SESSION['appNm']=$_POST['appNm'];
$_SESSION['ddad']=$_POST['ddad'];
$_SESSION['mmad']=$_POST['mmad'];
$_SESSION['yyad']=$_POST['yyad'];
$_SESSION['ddid']=$_POST['ddid'];
$_SESSION['mmid']=$_POST['mmid'];
$_SESSION['yyid']=$_POST['yyid'];
$_SESSION['ddfd']=$_POST['ddfd'];
$_SESSION['mmfd']=$_POST['mmfd'];
$_SESSION['yyfd']=$_POST['yyfd'];
$_SESSION['dded']=$_POST['dded'];
$_SESSION['mmed']=$_POST['mmed'];
$_SESSION['yyed']=$_POST['yyed'];
$_SESSION['status']=$_POST['status'];
$_SESSION['URL']='localhost';
$_SESSION['lati']=$_POST['lati'];
$_SESSION['loti']=$_POST['loti'];
$_SESSION['loga']='('.$_POST['lati'].','.$_POST['loti'].')';
}
else if($_SESSION['content']=="insert.php"){
$_SESSION['content']='Create';
$_SESSION['APN']=$_POST['APN'];
$_SESSION['permit']=$_POST['permit'];
$_SESSION['address']=$_POST['address'];
$_SESSION['desc']=$_POST['desc'];
$_SESSION['cat']=$_POST['cat'];
$_SESSION['act']=$_POST['act'];
$_SESSION['work']=$_POST['work'];
$_SESSION['val']=$_POST['val'];
$_SESSION['appNm']=$_POST['appNm'];
$_SESSION['ddad']=$_POST['ddad'];
$_SESSION['mmad']=$_POST['mmad'];
$_SESSION['yyad']=$_POST['yyad'];
$_SESSION['ddid']=$_POST['ddid'];
$_SESSION['mmid']=$_POST['mmid'];
$_SESSION['yyid']=$_POST['yyid'];
$_SESSION['ddfd']=$_POST['ddfd'];
$_SESSION['mmfd']=$_POST['mmfd'];
$_SESSION['yyfd']=$_POST['yyfd'];
$_SESSION['dded']=$_POST['dded'];
$_SESSION['mmed']=$_POST['mmed'];
$_SESSION['yyed']=$_POST['yyed'];
$_SESSION['status']=$_POST['status'];
$_SESSION['URL']='localhost';
$_SESSION['lati']=$_POST['lati'];
$_SESSION['loti']=$_POST['loti'];
$_SESSION['loga']='('.$_POST['lati'].','.$_POST['loti'].')';
}

	$test = $_SESSION['content'];//ReadDeleteCreateUpdate
	$client = new SoapClient("t.wsdl");
	class getBuildingData
	{
		public $DD;
		public $MM;
		public $YYYY;
	}
	class CreateBuildingData
	{
		public $BuildingDetail;
		public $Checker;
	}
	class UpdateBuildingData
	{
		public $BuildingDetail;
		public $Checker;
	}
	class DeleteBuildingData
	{
		public $BuildingDataID;
	}
?>
<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
</head>

<body>
<div align="center">
  <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="800" height="200">
    <param name="movie" value="sample4.swf" />
    <param name="quality" value="high" />
    <param name="wmode" value="opaque" />
    <param name="swfversion" value="6.0.65.0" />
    <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
    <param name="expressinstall" value="Scripts/expressInstall.swf" />
    <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
    <!--[if !IE]>-->
    <object type="application/x-shockwave-flash" data="sample4.swf" width="800" height="200">
      <!--<![endif]-->
      <param name="quality" value="high" />
      <param name="wmode" value="opaque" />
      <param name="swfversion" value="6.0.65.0" />
      <param name="expressinstall" value="Scripts/expressInstall.swf" />
      <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
      <div>
        <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
        <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
      </div>
      <!--[if !IE]>-->
    </object>
    <!--<![endif]-->
  </object>
</div>
<form id="bk" name="bk" method="post" action="index.php">
  <div align="center">
    <input type="submit" name="back" value="Back"/>
  </div>
</form>
&nbsp;<br />
&nbsp;<br />

<?
	if($test == "Read")
	{
?>
	<table border="1" bordercolorlight="#3366CC">
		<tr>
			<td><b>Application Permit Number</b></td>
			<td><b>Permit Type</b></td>
			<td><b>Address</b></td>
			<td><b>Description</b></td>
			<td><b>Category</b></td>
			<td><b>Action Type</b></td>
			<td><b>Work Type</b></td>
			<td><b>Value</b></td>
			<td><b>Applicant Name</b></td>
			<td><b>Application Date</b></td>
			<td><b>Issue Date</b></td>
			<td><b>Final Date</b></td>
			<td><b>Expiration Date</b></td>
			<td><b>Status</b></td>
			<td><b>Permit and Complaint Status URL</b></td>
			<td><b>Latitude</b></td>
			<td><b>Longitude</b></td>
			<td><b>Location</b></td>
		</tr>
<?
	$param = new getBuildingData();
	$param->DD = $_SESSION['ddsh'];
	$param->MM = $_SESSION['mmsh'];
	$param->YYYY = $_SESSION['yysh'];
	$return = $client->getBuildingData($param);
	foreach ($return AS $type){echo $type->BuildingData;}
?>
</table>
<? 
	}
	else if($test == "Create")
	{
		$t = "NULL";
		$param = new CreateBuildingData();
		$param->Checker = $_SESSION['APN'];
		$param->BuildingDetail = "'".$_SESSION['APN']."','".$_SESSION['permit']."','".$_SESSION['address']."','".$_SESSION['desc']."','".$_SESSION['cat']."','".$_SESSION['act']."','".$_SESSION['work']."','".$_SESSION['val']."','".$_SESSION['appNm']."','".$_SESSION['yyad']."-".$_SESSION['mmad']."-".$_SESSION['ddad']."','".$_SESSION['yyid']."-".$_SESSION['mmid']."-".$_SESSION['ddid']."','".$_SESSION['yyfd']."-".$_SESSION['mmfd']."-".$_SESSION['ddfd']."','".$_SESSION['yyed']."-".$_SESSION['mmed']."-".$_SESSION['dded']."','".$_SESSION['status']."','".$_SESSION['URL']."','".$_SESSION['lati']."','".$_SESSION['loti']."','".$_SESSION['loga']."'";
		$return = $client->CreateBuildingData($param);
		echo $return->Result;
	}
	else if($test == "Update")
	{
		$t = "NULL";
		$param = new UpdateBuildingData();
		$param->Checker = $_SESSION['APN'];
		$param->BuildingDetail = "Permit_Type='".$_SESSION['permit']."',Address='".$_SESSION['address']."',Description='".$_SESSION['desc']."',Category='".$_SESSION['cat']."',Action_Type='".$_SESSION['act']."',Work_Type='".$_SESSION['work']."',Value='".$_SESSION['val']."',Applicant_Name='".$_SESSION['appNm']."',Application_Date='".$_SESSION['yyad']."-".$_SESSION['mmad']."-".$_SESSION['ddad']."',Issue_Date='".$_SESSION['yyid']."-".$_SESSION['mmid']."-".$_SESSION['ddid']."',Final_Date='".$_SESSION['yyfd']."-".$_SESSION['mmfd']."-".$_SESSION['ddfd']."',Expiration_Date='".$_SESSION['yyed']."-".$_SESSION['mmed']."-".$_SESSION['dded']."',Status='".$_SESSION['status']."',Permit_and_Complaint_Status_URL='".$_SESSION['URL']."'".",Latitude='".$_SESSION['lati']."',Longitude='".$_SESSION['loti']."',Location='".$_SESSION['loga']."'";
		$return = $client->UpdateBuildingData($param);
		echo $return->Result;
	}
	else if($test == "Delete")
	{
		$param = new DeleteBuildingData();
		$param->BuildingDataID = $_SESSION['APN'];
		$return = $client->DeleteBuildingData($param);
		echo $return->Result;
	}
?>
<p>&nbsp; </p>
<form id="bktb" name="bktb" method="post" action="index.php">
  <div align="center">
    <input type="submit" name="back" value="Back"/>
  </div>
</form>
<script type="text/javascript">
swfobject.registerObject("FlashID");
</script>
</body>
</html>