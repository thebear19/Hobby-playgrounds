<?php
session_start();
$_SESSION['content']='';

if(isset($_GET['read'])){
	$_SESSION['content']="read.php";
}
else if(isset($_GET['insert'])){
	$_SESSION['content']="insert.php";
}
else if(isset($_GET['update'])){
	$_SESSION['content']="update.php";
}
else if(isset($_GET['delete'])){
	$_SESSION['content']="delete.php";
}
else{
	$_SESSION['content']="clear.php";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>กรมที่ดิน</title>
<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
<script type="text/javascript">
		function cmdForm(){
			var number = document.commands.selecter.selectedIndex;
			location.href = document.commands.selecter.options[number].value;
		}
</script>
</head>

<body bgcolor="99FFFF">
<p align="center"> 
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
</p>
<form id="commands" name="commands" method="post" action="">
  <label for="selecter"></label>
  <div align="center">
    <select name="selecter" id="selecter" onChange="cmdForm(this.form)">
      <option>Select Method</option>
      <option value="index.php?read">Read</option>
      <option value="index.php?insert">Insert</option>
      <option value="index.php?update">Update</option>
      <option value="index.php?delete">Delete</option>
    </select>
  </div>
</form>
<p align="center"><?php include($_SESSION['content']);?></p>
<script type="text/javascript">
swfobject.registerObject("FlashID");
</script>
</body>
</html>
