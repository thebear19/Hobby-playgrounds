<?php
// Set delay 1 second. 
sleep(1);

// Create connection connect to mysql database
$dbCon = mysql_connect('localhost', 'root', '') or die (mysql_error());

// Select database.
mysql_select_db('tutor', $dbCon) or die (mysql_error());

// Set encoding.
mysql_query('SET NAMES UTF8');

// Next dropdown list.
$nextList = isset($_GET['nextList']) ? $_GET['nextList'] : '';

switch($nextList) {
	case 'amphur':
		$provinceID = isset($_GET['provinceID']) ? $_GET['provinceID'] : '';
		$result = mysql_query("
			SELECT
				AMPHUR_ID,
				AMPHUR_NAME
			FROM
				amphur
			WHERE PROVINCE_ID = '{$provinceID}'
			ORDER BY CONVERT(AMPHUR_NAME USING TIS620) ASC;
		");
		break;
	case 'tumbon':
		$amphurID = isset($_GET['amphurID']) ? $_GET['amphurID'] : '';
		$result = mysql_query("
			SELECT
				DISTRICT_ID,
				DISTRICT_NAME
			FROM
				district
			WHERE AMPHUR_ID = '{$amphurID}'
			ORDER BY CONVERT(DISTRICT_NAME USING TIS620) ASC;
		");
		break;
}

$data = array();
while($row = mysql_fetch_assoc($result)) {
	$data[] = $row;
}

// Print the JSON representation of a value
echo json_encode($data);
?>