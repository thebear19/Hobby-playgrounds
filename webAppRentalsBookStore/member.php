<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Member List</title>
   	<link href="style.css" rel="stylesheet" type="text/css">
	<?
        session_start();
        include('connect.php');
        $stmt = OCIParse($connection,"SELECT * FROM member ORDER BY member_id ASC");
        OCIExecute($stmt);
        if(isset($_POST['submit']))
        {
            if($_POST['name'] != "" && $_POST['surname'] != "" && $_POST['tel'] != "")
            {
                $stmt = OCIParse($connection,"UPDATE member SET firstname = '".$_POST['name']."',lastname = '".$_POST['surname']."',address = '".$_POST['address']."',email = '".$_POST['email']."',tel = '".$_POST['tel']."' WHERE member_id = '".$_GET['target']."'");
                OCIExecute($stmt);
                oci_commit($connection);
                oci_free_statement($stmt);
                ocilogoff($connection);
                header("Location: member.php");
            }
            else{$_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบ";}
        }
        elseif(isset($_GET['delete']))
        {
            $stmt = OCIParse($connection,"DELETE FROM member WHERE member_id = '".$_GET['target']."'");
            OCIExecute($stmt);
            oci_commit($connection);
            oci_free_statement($stmt);
            ocilogoff($connection);
            header("Location: member.php");
        }
    ?>
</head>

<BODY style="background-color: #ffffc1;" bgproperties="fixed" onLoad="init();">
	<center>
	<div id="container">
		<div id="header">
			<table border="0">
				<tr>
					<td width="320px"><img border="0" src = "images/LG1.png" /></td>
					<td width="800px" height="80px"><div align = "right">
					<? if($_SESSION['user'] === "000000"){
                    	echo "<img border='0' src = 'images/welcome.png' /> คุณ admin   <a href='logout.php'><img border='0' src = 'images/logout.png' /></a>";
					}?>
					</div></td>
				</tr>
			</table> 
		</div>
		<div id="horizontalnav">
        	<table border="0">
				<tr>
					<td width="10px"></td>
					<td width="1018px">
                    	<ul id="paneltwo">  
							<li class="mask"><center><img border="0" src = "images/L-menu.png" /></center></li>  
							<li class="linkOne"><a href="member.php"><center><img border="0" src = "images/L-member.png"/></center></a></li>  
							<li class="linkTwo"><a href="book.php"><center><img border="0" src = "images/L-book.png"/></center></a></li>  
							<li class="linkThree"><a href="borrow_list.php"><center><img border="0" src = "images/L-borrow.png"/></center></a></li>  
							<li class="linkFour"><a href="return.php"><center><img border="0" src = "images/L-return.png"/></center></a></li>  
						</ul>
                 	</td>
				</tr>
			</table> 
			
		</div>
		<div id="body"> 
            <form id='form' name='form' method='post' action='' >
                <center><br/><font face="BrowalliaUPC, CordiaUPC" size="4">
                <table border="0">
                    <tr><td width = "14"></td><td width = "1000"><table border="1" bordercolor="#00bfcb" bgcolor="#eafdde"><tr>
                    	
                        <th width = "25" height="40" align="center" bgcolor="#23f2b5"><font size="5"><b>ID</b></font></th>
                        <th width = "110" align="center" bgcolor="#23f2b5"><font size="5"><b>Name</b></font></th>
                        <th width = "110" align="center" bgcolor="#23f2b5"><font size="5"><b>Surname</b></font></th>
                        <th width = "230" align="center" bgcolor="#23f2b5"><font size="5"><b>Address</b></font></th>
                        <th width = "100" align="center" bgcolor="#23f2b5"><font size="5"><b>E-mail</b></font></th>
                        <th width = "80" align="center" bgcolor="#23f2b5"><font size="5"><b>Tel.</b></font></th>
                        <th width = "100" align="center" bgcolor="#23f2b5"><font size="5"><b>Register Date</b></font></th>
                        <th width = "60" align="center" bgcolor="#23f2b5"><font size="5"><b>Action</b></font></th>
                        
                        <?
                            while($row = oci_fetch_assoc($stmt))
                            {
                                echo "<tr><td align='center'>".$row['MEMBER_ID']."</td>\n";
                                
                                if(isset($_GET['edit']) && $row['MEMBER_ID'] === $_GET['target'])
                                {
                                    echo "<td><input type='text' name='name' value='".$row['FIRSTNAME']."' style='background-color:#dadada; border:0; width:110px; color:#492301; font-weight:bold; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'></td>\n";
                                }else{echo "<td>".$row['FIRSTNAME']."</td>\n";}
                                
                                if(isset($_GET['edit']) && $row['MEMBER_ID'] === $_GET['target'])
                                {
                                    echo "<td><input type='text' name='surname' value='".$row['LASTNAME']."' style='background-color:#dadada; border:0; width:110px; color:#492301; font-weight:bold; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'></td>\n";
                                }else{echo "<td>".$row['LASTNAME']."</td>\n";}
                                
                                if(isset($_GET['edit']) && $row['MEMBER_ID'] === $_GET['target'])
                                {
                                    echo "<td><input type='text' name='address' size='60' value='".$row['ADDRESS']."' style='background-color:#dadada; border:0; width:300px; color:#492301; font-weight:bold; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'></td>\n";
                                }else{echo "<td>".$row['ADDRESS']."</td>\n";}
                                
                                if(isset($_GET['edit']) && $row['MEMBER_ID'] === $_GET['target'])
                                {
                                    echo "<td><input type='text' name='email' value='".$row['EMAIL']."' style='background-color:#dadada; border:0; width:150px; color:#492301; font-weight:bold; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'></td>\n";
                                }else{echo "<td align='center'>".$row['EMAIL']."</td>\n";}
                                
                                if(isset($_GET['edit']) && $row['MEMBER_ID'] === $_GET['target'])
                                {
                                    echo "<td><input type='text' name='tel' value='".$row['TEL']."' style='background-color:#dadada; border:0; width:90px; color:#492301; font-weight:bold; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;'></td>\n";
                                }else{echo "<td align='center'>".$row['TEL']."</td>\n";}
                                
                                echo "<td align='center'>".$row['DOR']."</td>\n";
                                
                                if(isset($_GET['edit']) && $row['MEMBER_ID'] === $_GET['target'])
                                {
                                    echo "<td align='center'><input type='image' name='submit' value='Submit' src = 'images/submit.png'/></a>
                                          <a href='member.php'><img src = 'images/cancel.png' /></a></td></tr>\n";
                                }
                                else
                                {
                                    echo "<td align='center'><a href='member.php?edit=true&target=".$row['MEMBER_ID']."'><img src = 'images/edit.png' /></a>"; ?>
                                          <a href="member.php?delete=true&target=<? echo $row['MEMBER_ID']?>" name="delete" onclick="return confirm('ต้องการที่จะลบข้อมูลนี้หรือไม่?')"><img border="0" src = "images/delete.png" /></a><? echo"</td></tr>\n";
                                }
                            }
                        ?>
                    </tr></table></td><td width = "14"></td></tr>
                </table></font>
                </center>
                <br/><div align = "right"><a href="member.php"><img border="0" src = "images/up.png" /></a></div> <br/>
            </form>
			<? if(isset($_SESSION['error']))
                {
                    echo "<center><font color='#FF0000'>".$_SESSION['error']."</font></center>";
                    unset($_SESSION['error']);
                }
            ?>
		</div>
		<div id="footer">
			<font size="3" face="CordiaUPC" color="#FFFFFF">
			<h4><b>copyright &copy; 2012 by RENG-RIP Book Rental Store</b></h4>
		</div>
	</div>
	</center>
</body>
</html>