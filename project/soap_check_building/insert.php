<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="inserts" name="inserts" method="post" action="c.php">
    <div align="center">
    <table cellpadding="3" cellspacing="3"><tr>
    <td><div align="center">Application Permit Number</div></td>
    <td><input type="text" name="APN" id="APN" /></td>
	</tr><tr>
    <td><div align="right">Permit Type</div></td>
    <td><label>
	    <input type="radio" name="permit" value="Construction" id="permit_0" />
	    Construction</label>
	  <br />
	  <label>
	    <input type="radio" name="permit" value="Demolition" id="permit_1" />
	    Demolition</label>
	  <br />
	  <label>
	    <input type="radio" name="permit" value="Site Development" id="permit_2" />
	    Site Development</label>
	  <br /></td>
      </tr><tr>
  <td><div align="right">Address</div></td>
  <td><textarea name="address" rows="3" id="address"></textarea></td>
  </tr><tr>
	<td><div align="right">Description</div></td>
	<td><textarea name="desc" rows="5" id="desc"></textarea></td>
    </tr><tr>
	<td><div align="right">Category</div></td>
	<td><select name="cat" size="1" id="cat">
<option value="Single Family/Duplex">Single Family/Duplex</option>
<option value="Commercial">Commercial</option>
<option value="Industrial">Industrial</option>
<option value="Institutional">Institutional</option>
<option value="Mutifamily">Mutifamily</option>
	  </select></td>
      </tr><tr>
	<td><div align="right">Action Type</div></td>
    <td><select name="act" size="1" id="act">
	  <option value="Add/Alt">Add/Alt</option>
	  <option value="Alter">Alter</option>
	  <option value="Curb Cut">Curb Cut</option>
	  <option value="Deconstruction">Deconstruction</option>
	  <option value="Demolition">Demolition</option>
      <option value="Drainage Approval">Drainage Approval</option>
      <option value="Floodplain License Only">Floodplain License Only</option>
      <option value="Grading">Grading</option>
      <option value="New">New</option>
      <option value="No Construction">No Construction</option>
      <option value="Site Mornitoring Only">Site Mornitoring Only</option>
      <option value="Temp">Temp</option>
      <option value="Tree/Vegetetion Maint/Restore">Tree/Vegetetion Maint/Restore</option>
      <option value="Wetland Restoreation">Wetland Restoreation</option>
	  </select></td>
	</tr><tr>
	<td><div align="right">Work Type</div></td>
    <td><label>
	    <input type="radio" name="work" value="No Plan Review" id="work_0" />
	    No Plan Review</label>
	  <br />
	  <label>
	    <input type="radio" name="work" value="Plan Review" id="work_1" />
	    Plan Review</label>
	  </td></tr><tr>
	<td><div align="right">Value</div></td><td><input name="val" type="text" id="val" value="$" /><br /></td>
    </tr><tr>
	<td><div align="right">Applicant Name</div></td><td><input type="text" name="appNm" id="appNm" /><br /></td>
    </tr><tr>
	<td><div align="right">Application Date</div></td>
	<td><select name="ddad" size="1" id="ddad">
	  <option>DD</option>
	  <option value="01">01</option>
	  <option value="02">02</option>
	  <option value="03">03</option>
	  <option value="04">04</option>
	  <option value="05">05</option>
	  <option value="06">06</option>
	  <option value="07">07</option>
	  <option value="08">08</option>
	  <option value="09">09</option>
	  <option value="10">10</option>
	  <option value="11">11</option>
	  <option value="12">12</option>
	  <option value="13">13</option>
	  <option value="14">14</option>
	  <option value="15">15</option>
	  <option value="16">16</option>
	  <option value="17">17</option>
	  <option value="18">18</option>
	  <option value="19">19</option>
	  <option value="20">20</option>
	  <option value="21">21</option>
	  <option value="22">22</option>
	  <option value="23">23</option>
	  <option value="24">24</option>
	  <option value="25">25</option>
	  <option value="26">26</option>
	  <option value="27">27</option>
	  <option value="28">28</option>
	  <option value="29">29</option>
	  <option value="30">30</option>
	  <option value="31">31</option>
    </select>
    <select name="mmad" size="1" id="mmad">
	  <option>MM</option>
	  <option value="01">01</option>
	  <option value="02">02</option>
	  <option value="03">03</option>
	  <option value="04">04</option>
	  <option value="05">05</option>
	  <option value="06">06</option>
	  <option value="07">07</option>
	  <option value="08">08</option>
	  <option value="09">09</option>
	  <option value="10">10</option>
	  <option value="11">11</option>
	  <option value="12">12</option>
    </select>
    <select name="yyad" size="1" id="yyad">
	  <option>YYYY</option>
	  <option value="2000">2000</option>
	  <option value="2001">2001</option>
	  <option value="2002">2002</option>
	  <option value="2003">2003</option>
	  <option value="2004">2004</option>
	  <option value="2005">2005</option>
	  <option value="2006">2006</option>
	  <option value="2007">2007</option>
	  <option value="2008">2008</option>
	  <option value="2009">2009</option>
	  <option value="2010">2010</option>
	  <option value="2011">2011</option>
	  <option value="2012">2012</option>
    </select></td>
	</tr><tr>
	<td><div align="right">Issue Date</div></td>
    	<td><select name="ddid" size="1" id="ddid">
	  <option>DD</option>
	  <option value="01">01</option>
	  <option value="02">02</option>
	  <option value="03">03</option>
	  <option value="04">04</option>
	  <option value="05">05</option>
	  <option value="06">06</option>
	  <option value="07">07</option>
	  <option value="08">08</option>
	  <option value="09">09</option>
	  <option value="10">10</option>
	  <option value="11">11</option>
	  <option value="12">12</option>
	  <option value="13">13</option>
	  <option value="14">14</option>
	  <option value="15">15</option>
	  <option value="16">16</option>
	  <option value="17">17</option>
	  <option value="18">18</option>
	  <option value="19">19</option>
	  <option value="20">20</option>
	  <option value="21">21</option>
	  <option value="22">22</option>
	  <option value="23">23</option>
	  <option value="24">24</option>
	  <option value="25">25</option>
	  <option value="26">26</option>
	  <option value="27">27</option>
	  <option value="28">28</option>
	  <option value="29">29</option>
	  <option value="30">30</option>
	  <option value="31">31</option>
    </select>
    <select name="mmid" size="1" id="mmid">
	  <option>MM</option>
	  <option value="01">01</option>
	  <option value="02">02</option>
	  <option value="03">03</option>
	  <option value="04">04</option>
	  <option value="05">05</option>
	  <option value="06">06</option>
	  <option value="07">07</option>
	  <option value="08">08</option>
	  <option value="09">09</option>
	  <option value="10">10</option>
	  <option value="11">11</option>
	  <option value="12">12</option>
    </select>
    <select name="yyid" size="1" id="yyid">
	  <option>YYYY</option>
	  <option value="2000">2000</option>
	  <option value="2001">2001</option>
	  <option value="2002">2002</option>
	  <option value="2003">2003</option>
	  <option value="2004">2004</option>
	  <option value="2005">2005</option>
	  <option value="2006">2006</option>
	  <option value="2007">2007</option>
	  <option value="2008">2008</option>
	  <option value="2009">2009</option>
	  <option value="2010">2010</option>
	  <option value="2011">2011</option>
	  <option value="2012">2012</option>
    </select></td>
    </tr><tr>
	<td><div align="right">Final Date</div></td>
    	<td><select name="ddfd" size="1" id="ddfd">
	  <option>DD</option>
	  <option value="01">01</option>
	  <option value="02">02</option>
	  <option value="03">03</option>
	  <option value="04">04</option>
	  <option value="05">05</option>
	  <option value="06">06</option>
	  <option value="07">07</option>
	  <option value="08">08</option>
	  <option value="09">09</option>
	  <option value="10">10</option>
	  <option value="11">11</option>
	  <option value="12">12</option>
	  <option value="13">13</option>
	  <option value="14">14</option>
	  <option value="15">15</option>
	  <option value="16">16</option>
	  <option value="17">17</option>
	  <option value="18">18</option>
	  <option value="19">19</option>
	  <option value="20">20</option>
	  <option value="21">21</option>
	  <option value="22">22</option>
	  <option value="23">23</option>
	  <option value="24">24</option>
	  <option value="25">25</option>
	  <option value="26">26</option>
	  <option value="27">27</option>
	  <option value="28">28</option>
	  <option value="29">29</option>
	  <option value="30">30</option>
	  <option value="31">31</option>
    </select>
    <select name="mmfd" size="1" id="mmfd">
	  <option>MM</option>
	  <option value="01">01</option>
	  <option value="02">02</option>
	  <option value="03">03</option>
	  <option value="04">04</option>
	  <option value="05">05</option>
	  <option value="06">06</option>
	  <option value="07">07</option>
	  <option value="08">08</option>
	  <option value="09">09</option>
	  <option value="10">10</option>
	  <option value="11">11</option>
	  <option value="12">12</option>
    </select>
    <select name="yyfd" size="1" id="yyfd">
	  <option>YYYY</option>
	  <option value="2000">2000</option>
	  <option value="2001">2001</option>
	  <option value="2002">2002</option>
	  <option value="2003">2003</option>
	  <option value="2004">2004</option>
	  <option value="2005">2005</option>
	  <option value="2006">2006</option>
	  <option value="2007">2007</option>
	  <option value="2008">2008</option>
	  <option value="2009">2009</option>
	  <option value="2010">2010</option>
	  <option value="2011">2011</option>
	  <option value="2012">2012</option>
    </select></td>
    </tr><tr>
	<td><div align="right">Expiration Date</div></td>
    	<td><select name="dded" size="1" id="dded">
	  <option>DD</option>
	  <option value="01">01</option>
	  <option value="02">02</option>
	  <option value="03">03</option>
	  <option value="04">04</option>
	  <option value="05">05</option>
	  <option value="06">06</option>
	  <option value="07">07</option>
	  <option value="08">08</option>
	  <option value="09">09</option>
	  <option value="10">10</option>
	  <option value="11">11</option>
	  <option value="12">12</option>
	  <option value="13">13</option>
	  <option value="14">14</option>
	  <option value="15">15</option>
	  <option value="16">16</option>
	  <option value="17">17</option>
	  <option value="18">18</option>
	  <option value="19">19</option>
	  <option value="20">20</option>
	  <option value="21">21</option>
	  <option value="22">22</option>
	  <option value="23">23</option>
	  <option value="24">24</option>
	  <option value="25">25</option>
	  <option value="26">26</option>
	  <option value="27">27</option>
	  <option value="28">28</option>
	  <option value="29">29</option>
	  <option value="30">30</option>
	  <option value="31">31</option>
    </select>
    <select name="mmed" size="1" id="mmed">
	  <option>MM</option>
	  <option value="01">01</option>
	  <option value="02">02</option>
	  <option value="03">03</option>
	  <option value="04">04</option>
	  <option value="05">05</option>
	  <option value="06">06</option>
	  <option value="07">07</option>
	  <option value="08">08</option>
	  <option value="09">09</option>
	  <option value="10">10</option>
	  <option value="11">11</option>
	  <option value="12">12</option>
    </select>
    <select name="yyed" size="1" id="yyed">
	  <option>YYYY</option>
	  <option value="2000">2000</option>
	  <option value="2001">2001</option>
	  <option value="2002">2002</option>
	  <option value="2003">2003</option>
	  <option value="2004">2004</option>
	  <option value="2005">2005</option>
	  <option value="2006">2006</option>
	  <option value="2007">2007</option>
	  <option value="2008">2008</option>
	  <option value="2009">2009</option>
	  <option value="2010">2010</option>
	  <option value="2011">2011</option>
	  <option value="2012">2012</option>
    </select></td>
    </tr><tr>
	<td><div align="right">Status</div></td>
    <td><select name="status" size="1" id="status">
	  <option value="AP Closed">AP Closed</option>
	  <option value="AP Finaled">AP Finaled</option>
	  <option value="Application Accepted">Application Accepted</option>
	  <option value="Cancelled">Cancelled</option>
	  <option value="Cert of Occupancy Authorized">Cert of Occupancy Authorized</option>
      <option value="Information Collected">Information Collected</option>
      <option value="Information Converted">Information Converted</option>
      <option value="Initial Information Collected">Initial Information Collected</option>
      <option value="Inspections Added">Inspections Added</option>
      <option value="Permit Closed">Permit Closed</option>
      <option value="Permit Finaled">Permit Finaled</option>
      <option value="Permit Issued">Permit Issued</option>
      <option value="Reviews Completed">Reviews Completed</option>
	  </select></td>
	</tr><tr>
	<td><div align="right">Latitude</div></td><td><input type="text" name="lati" id="lati" /><br /></td>
    </tr><tr>
	<td><div align="right">Longitude</div></td><td><input type="text" name="loti" id="loti" /></td>
    </tr><tr>
    <td colspan="2">
      <div align="center">
        <input type="submit" name="summit" id="summit" value="Submit" />
        &nbsp;&nbsp;&nbsp;
        <input type="reset" name="reset" id="reset" value="Reset" />
      </div></td></tr>
	</table>
    </div>
</form>

</body>
</html>