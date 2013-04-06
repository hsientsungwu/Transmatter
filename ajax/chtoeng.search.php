<?php

if (!$_POST['chtoeng'] && $key != '') exit;

header("Content-Type: text/html; charset=utf-8");
require $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$key = mysql_escape_string($key);

$query = "SELECT * FROM ce WHERE tc = '{$key}'";
$results = $db->ExecuteSQL($query);

$resultString = '<label>' . $key . '</label>';

if (count($results) > 0 && is_array($results)) {

	foreach ($results as $index => $result) {
		$resultString .= '<p>';
		$eng = json_decode(($result['eng']));

		$resultString .= implode(', ', $eng);

		$resultString .= '</p>';
	}
} else {
	$resultString .= '<p>No result found.</p>';
}

echo $resultString;
die; 