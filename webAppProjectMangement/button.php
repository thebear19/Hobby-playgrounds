<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css" media="screen">
body{
	font-family:tahoma;
	font-size:12px;
	line-height:150%;
	background-color:#fcd391;
	background-image: -webkit-linear-gradient(#ff9911 30%,#fcc267 60%, #fcd391 80%);
	background-repeat:repeat-x;
	padding-top:170px;
	padding-bottom:30px;
} 
#menutop{
	background-color:transparent;
    position:absolute;
	left:0px;
	top:0px;
	width:100%;
	border:0;
}
.button{
	display:inline;
	background-image: -webkit-linear-gradient(#ffdf60 10%, #ffcc00 50%, #ffcc66 90%);	
	-webkit-box-shadow: 2px 3px 3px rgba(0,0,0,0.3);
	width:100%;
	-webkit-border-radius: 10px;
	width:120px;
	height:40px;
	border:0px;
}
.button:hover{
	background-image: -webkit-linear-gradient(#ffcc66 10%, #ffcc00 50%, #ffcc33 90%);
	-webkit-box-shadow: 1px 5px 3px rgba(0,0,0,0.3);
}
.button.gray{
	display:inline;
	background-image: -webkit-linear-gradient(#A0A0A0 10%, #888888 50%, #C8C8C8 90%);	
	-webkit-box-shadow: 2px 3px 3px rgba(0,0,0,0.3);
	width:100%;
	-webkit-border-radius: 10px;
	width:120px;
	height:25px;
	border:0px;
}
fieldset{
	border:0;
}

select{
	width:150px;	
}
</style>
<script type="text/javascript">

</script>
</head>
<?
if(isset($_GET['logout'])){
	if(($_GET['logout'])==1){
		session_destroy();
		header('location:logon.php');
	}
}
?>
<body>
<div id="menutop" align="center">
	<table width="800" align="center" cellpadding="0" cellspacing="0">
		 <tr>
			<td height="100" colspan="2" align="center"><font style="text-shadow: 2px 2px #b8b3a4;"><h1>ระบบสารสนเทศในการติดตามผลการดำเนินการตามติดคณะรัฐมนตรี</h1></font>
			</td>
		</tr> 
	<tr>
	<td>
	<?
	if(!isset($_SESSION['username'])){
	?>
	<input type="button" name="login" class="login button" id="login" value="login" onclick="window.location.replace('logon.php');">
	<input type="button" name="register" class="register button" id="register" value="register" onclick="window.location.replace('register.php');"/>
	<?
	}else if(isset($_SESSION['username'])){
	?>
	<input type="button" name="projects" class="projects button" id="projects" value="projects" onclick="window.location.replace('projects.php');"/>
	<input type="button" name="search" class="search button" id="search" value="search" onclick="window.location.replace('search.php');"/>
	<input type="button" name="report" class="report button" id="report" value="report" onclick="window.location.replace('report.php');"/>
	<? if($_SESSION['role']=='Admin'||$_SESSION['role']=='Creator'){ ?>
	<input type="button" name="insert" class="insert button" id="insert" value="insert" onclick="window.location.replace('project_insert.php');"/>
	<? }if($_SESSION['role']=='Admin'){ ?>
	<input type="button" name="manageuser" class="manageuser button" id="manageuser" value="manageuser" onclick="window.location.replace('manageuser.php');"/>
	<?
		}
	}
	?>
	</td>
	<?
	if(isset($_SESSION['username'])){
	?>
	<td align="right">ยินดีต้อนรับ คุณ <b><? echo $_SESSION['username'] ?></b><br/>สิทธิ์ของคุณคือ <b><? echo $_SESSION['role']; ?></b><br/> <a href="?logout=1">ออกจากระบบ</a></td>
	<?
	}else{
	?>	
	<td align="right">ยินดีต้อนรับ บุคคลทั่วไป กรุณาล็อคอินเพื่อเข้าใช้งานระบบ<a href="logon.php">ที่นี่</a>ค่ะ</td>
	<?
	}
	?>
	</td>
	</tr>
	</table>
</div>
</body>
</html>