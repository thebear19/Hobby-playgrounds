<?php
// Set delay 1 second. 
sleep(1);

// Create connection connect to mysql database
$dbCon = mysql_connect('localhost', 'root', '') or die (mysql_error());

// Select database.
mysql_select_db('gpm', $dbCon) or die (mysql_error());

// Set encoding.
mysql_query('SET NAMES UTF8');

// Next dropdown list.
$nextList = isset($_GET['nextList']) ? $_GET['nextList'] : '';

switch($nextList) {
	case 'strategy':
		$plan_id = isset($_GET['plan_id']) ? $_GET['plan_id'] : '';
		$result = mysql_query("
			SELECT
				Strategy_ID,
				Strategy_Description
			FROM
				strategy
			WHERE Plan_ID = '{$plan_id}'
			ORDER BY CONVERT(Strategy_Description USING TIS620) ASC;
		");
		break;
	case 'aim':
		$strategy_id = isset($_GET['strategy_id']) ? $_GET['strategy_id'] : '';
		$result = mysql_query("
			SELECT
				Aim_ID,
				Aim_Description
			FROM
				aim
			WHERE Strategy_ID = '{$strategy_id}'
			ORDER BY CONVERT(Aim_Description USING TIS620) ASC;
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