<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Return Book</title>
	<link href="style.css" rel="stylesheet" type="text/css">
    <?
        session_start();
        include('connect.php');
        
        if(isset($_POST['return']))
        {
            for($i=0,$sum=0;$i<count($_POST['return']);$i++)
            {
                $stmt = OCIParse($connection,"UPDATE book SET status = 'On shelf' WHERE book_id = '".$_POST['return'][$i]."'");
                OCIExecute($stmt);
                oci_commit($connection);
                $stmt = OCIParse($connection,"UPDATE borrow_line SET return_date = CURRENT_TIMESTAMP WHERE book_id = ".$_POST['return'][$i]);
                OCIExecute($stmt);
                oci_commit($connection);
                $stmt = OCIParse($connection,"select BORROW_END,RETURN_DATE,FINE_RATE from borrow b, borrow_line bl, book bk where b.borrow_id(+) = bl.borrow_id and bl.book_id(+) = bk.book_id and bl.book_id =".$_POST['return'][$i]);
                OCIExecute($stmt);
                $row = oci_fetch_assoc($stmt);
                $end = new DateTime($row['BORROW_END']);
                $re = new DateTime($row['RETURN_DATE']);
                $compare = $end->diff($re);
                if($compare->invert){$sum = $sum + 0;}
                else{$sum = $sum + $row['FINE_RATE'];}
            }
            $fine = "ยอดค้างชำระค่าปรับ : ".$sum." ฿";
            $succ = "<font color='#fe0000'>ทำรายการเรียบร้อย</font>";
        }
        
        if(isset($_POST['mid']) && $_POST['mid'] != "" && is_numeric($_POST['mid']))
        {
            $stmt = OCIParse($connection,"select * from borrow b, borrow_line bl, book bk where member_id = ".$_POST['mid']."and return_date is null and b.borrow_id(+) = bl.borrow_id and bl.book_id(+) = bk.book_id");
            OCIExecute($stmt);
            $true = true;
        }elseif(isset($_POST['mid']) && !isset($_POST['return'])){$error = "<font color='#FF0000'>เกิดข้อผิดพลาดกรุณาแก้ไข</font>";}
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
                <center><font face="BrowalliaUPC, CordiaUPC" size="4">
                	<br/><img border="0" src = "images/H-return.png" /><br/><br/>
                    <table>
                        <tr>
                            <td><img border='0' src = 'images/T-memberid.png' /></td>
                            <td><input name="mid" type="text" size="3" maxlength="3" 
                            style="background-color:#eafbff; border:0; width:80px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;"/></td>
                            <td><input name="submit" type="submit" value="Submit" 
                            style="background-color:#0d00b2; border:0; color:#ffffff; font-weight:bold; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;"/></td>
                        </tr>
                        
                        <tr>
                            <td></td>
                            <td></td>
                            <td><input name="cancel" type="button" value="Cancel" onclick="javascript:location.href='return.php'" 
                            style="background-color:#0d00b2; border:0; color:#ffffff; font-weight:bold; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;"/></td>
                        </tr>
                    </table><br/>
                    <? if(isset($succ)){echo "<br/>".$succ;}
                       if(isset($fine)){echo "<script>alert('".$fine."')</script>";}
                       if(isset($error)){echo "<br/>".$error;}
                       if(isset($true)){echo "<table border='1' bordercolor='#00bfcb' bgcolor='#eafdde'>
                            <tr>
                                <th width = '80' height='40' align='center' bgcolor='#23f2b5'><font size='5'><b>Borrow ID</b></font></th>
                                <th width = '80' height='40' align='center' bgcolor='#23f2b5'><font size='5'><b>Member ID</b></font></th>
                                <th width = '150' height='40' align='center' bgcolor='#23f2b5'><font size='5'><b>Book Name</b></font></th>
                                <th width = '100' height='40' align='center' bgcolor='#23f2b5'><font size='5'><b>Borrow End</b></font></th>
                                <th width = '80' height='40' align='center' bgcolor='#23f2b5'><font size='5'><b>Fine Rate</b></font></th>
                                <th width = '80' height='40' align='center' bgcolor='#23f2b5'><font size='5'><b>Action</b></font></th>
                            </tr>";
                    while($row = oci_fetch_assoc($stmt))
                    {
                        echo "<tr>
                                <td align='center'>".$row['BORROW_ID']."</td>\n
                                <td align='center'>".$row['MEMBER_ID']."</td>\n
                                <td align='center'>".$row['BOOK_NAME']."</td>\n
                                <td align='center'>".$row['BORROW_END']."</td>\n
                                <td align='center'>".$row['FINE_RATE']."</td>\n
                                <td align='center'>"?><center><input name="return[]" type="checkbox" value="<? echo $row['BOOK_ID']?>"/></center><? echo "</td>\n
                              </tr>";
                    }
                    echo "</table>";?>
                    <br/><input name="submit_re" type="submit" value="Return" style="background-color:#0d00b2; border:0; color:#ffffff; font-weight:bold; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;"/><? }?>
                <br/><br/><br/></font></center>
            </form>
		</div>
		<div id="footer">
			<font size="3" face="CordiaUPC" color="#FFFFFF">
			<h4><b>copyright &copy; 2012 by RENG-RIP Book Rental Store</b></h4>
		</div>
	</div>
	</center>
</body>
</html>