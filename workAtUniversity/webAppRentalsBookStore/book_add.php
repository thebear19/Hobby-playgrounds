<form id='addB' name='addB' method='post' action='' >
	<center>
        <br/><img border="0" src = "images/H-addnew.png" /><br/><br/>
        <table>
            <tr>
        		<td><img border='0' src = 'images/T-isbn.png' /></td>
            	<td><input name="isbn" type="text" size="13" maxlength="13" 
                style="background-color:#eafbff; border:0; width:150px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;"/></td>
            </tr>
                
            <tr>
            	<td><img border='0' src = 'images/T-name.png' /></td>
                <td><input name="book_name" type="text" size="32" maxlength="150" 
                style="background-color:#eafbff; border:0; width:200px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;"/></td>
            </tr>
            	
            <tr>
                <td><img border='0' src = 'images/T-author.png' /></td>
                <td><input name="author" type="text" size="32" maxlength="100" 
                style="background-color:#eafbff; border:0; width:200px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;"/></td>
            </tr>
                
            <tr>
                <td><img border='0' src = 'images/T-publisher.png' /></td>
                <td><input name="publisher" type="text" size="32" maxlength="100" 
                style="background-color:#eafbff; border:0; width:200px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;"/></td>
            </tr>
                
            <tr>
               	<td><img border='0' src = 'images/T-bookprice.png' /></td>
                <td><input name="book_price" type="text" size="4" maxlength="4" 
                style="background-color:#eafbff; border:0; width:50px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;"/></td>
            </tr>
            
            <tr>
               	<td><img border='0' src = 'images/T-status.png' /></td>
                <td><select name="status" size="1"
                style="background-color:#eafbff; border:0; width:100px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;">
                <option>On shelf</option><option>Checked out</option></select></td>
            </tr>
            
            <tr>
               	<td><img border='0' src = 'images/T-borrowprice.png' /></td>
                <td><input name="borrow_price" type="text" size="2" maxlength="2" 
                style="background-color:#eafbff; border:0; width:50px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;"/></td>
            </tr>
            
            <tr>
               	<td><img border='0' src = 'images/T-purchasedprice.png' /></td>
                <td><input name="purchased_price" type="text" size="4" maxlength="4" 
                style="background-color:#eafbff; border:0; width:50px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;"/></td>
            </tr>
            
            <tr>
               	<td><img border='0' src = 'images/T-soureofbook.png' /></td>
                <td><input name="soure" type="text" size="32" maxlength="100" 
                style="background-color:#eafbff; border:0; width:200px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;"/></td>
            </tr>
             
            <tr>
               	<td><img border='0' src = 'images/T-finerate.png' /></td>
                <td><input name="fine_rate" type="text" size="3" maxlength="3" 
                style="background-color:#eafbff; border:0; width:50px; color:#5b2b00; font-weight:bold; text-align: center; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;"/></td>
            </tr>
                
            <tr>
                <td></td>
    			<td><input type="button" name="cancel" value="Cancel" onclick="javascript:location.href='book.php'" 
                	style="background-color:#0d00b2; border:0; color:#ffffff; font-weight:bold; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;"/>
        			<input type="submit" name="submit_add" value="Submit" 
                    style="background-color:#0d00b2; border:0; color:#ffffff; font-weight:bold; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px;"/></td>
            </tr>
       </table>
    </center>
</form>