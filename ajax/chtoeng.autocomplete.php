<?php

// if the 'term' variable is not sent with the request, exit
if ( !isset($_REQUEST['term']) ) exit;

header("Content-Type: text/html; charset=utf-8");
require $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$key = mysql_escape_string($_REQUEST['term']);

$query = "SELECT * FROM ce WHERE tc LIKE '%{$key}%'";
$results = $db->ExecuteSQL($query);
 
// loop through each zipcode returned and format the response for jQuery
$data = array();

if (count($results) > 0 && is_array($results)) {
	foreach ($results as $result) {
		$data[] = array(
			'label' => $result['tc'],
			'value' => $result['tc']
		);
	}
}

// jQuery wants JSON data
echo json_encode($data);
flush();