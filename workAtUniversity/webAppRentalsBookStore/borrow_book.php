<?
	session_start();
	include('connect.php');
	if($_POST['book'] != "" && is_numeric($_POST['book']))
	{
		$stmt = OCIParse($connection,"SELECT * FROM book where isbn = '".$_POST['book']."' and status = 'On shelf'");
		OCIExecute($stmt);
		$_SESSION['show'][$_SESSION['i']] = "";
		if(oci_fetch_all($stmt,$result)>= 1)
		{
			OCIExecute($stmt);
			$row = oci_fetch_assoc($stmt);
			$_SESSION['show'][$_SESSION['i']] = "<tr><td align='center'>".$_SESSION['i']."</td>
													<td align='center'>".$row['ISBN']."</td>
													<td align='center'>".$row['BOOK_NAME']."</td>
													<td align='center'>".$row['AUTHOR']."</td>
													<td align='center'>".$row['PUBLISHER']."</td>
													<td align='center'>".$row['FINE_RATE']."</td>
													<td align='center'>".$row['BORROW_PRICE']."</td></tr>";
			
			$_SESSION['sum'] = $_SESSION['sum'] + $row['BORROW_PRICE'];
			$_SESSION['store'][$_SESSION['i']] = $row['ISBN'];
			$_SESSION['i']++;
		}
		echo "<center><font face='BrowalliaUPC, CordiaUPC' size='4'>
                <table border='1' bordercolor='#00bfcb' bgcolor='#eafdde'>
				<tr><th width = '20' height='40' align='center' bgcolor='#23f2b5'><font size='5'><b>No</b></font></th>
				<th width = '100' height='40' align='center' bgcolor='#23f2b5'><font size='5'><b>ISBN</b></font></th>
				<th width = '200' height='40' align='center' bgcolor='#23f2b5'><font size='5'><b>Name</b></font></th>
				<th width = '150' height='40' align='center' bgcolor='#23f2b5'><font size='5'><b>Author</b></font></th>
				<th width = '150' height='40' align='center' bgcolor='#23f2b5'><font size='5'><b>Publisher</b></font></th>
				<th width = '80' height='40' align='center' bgcolor='#23f2b5'><font size='5'><b>Fine Rate</b></font></th>
				<th width = '100' height='40' align='center' bgcolor='#23f2b5'><font size='5'><b>Borrow Price</b></font></th></tr>";
		foreach ($_SESSION['show'] AS $show){echo $show;}
		echo "<tr><td colspan='6' align='center'>Total</td><td align='center'>".$_SESSION['sum']." ฿</td></tr></table><br/>
				<a href='borrow_sub.php'><img src = 'images/submit.png' /></a>
				<a href='borrow_can.php'><img src = 'images/cancel.png' /></a></font></center>";
	}
?>