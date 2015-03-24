<?php
session_start();
include ("../inc_dbconnect.php");
header('Content-Type: text/html; charset=TIS-620');

echo '<select name="subTypeContent"><option value = "">Please select</option>';
$qu = mysql_db_query($dbname, "SELECT ID,Detail FROM contact_detail_item WHERE TypeID = '$_POST[typeID]' && status = '1' ORDER BY sort");
while ($row = mysql_fetch_array($qu)) {
    if ($row[ID] != 57) {
        $checked = ($row[ID] == $_POST[subID])? "selected" : "";
        echo "<option value='$row[ID]' $checked>$row[Detail]</option>";
    }
}
echo '</select>';
?>