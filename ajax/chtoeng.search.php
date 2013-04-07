<?php

if (!$_POST['chtoeng'] && $key != '') exit;

header("Content-Type: text/html; charset=utf-8");
require $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$key = mysql_escape_string($key);

$query = "SELECT id, tc, eng, 'ce' as source FROM ce WHERE tc = '{$key}'";
$results1 = $db->ExecuteSQL($query);

$query = "SELECT id, tc, eng, 'tao_ce' as source FROM tao_ce WHERE tc = '{$key}'";
$results2 = $db->ExecuteSQL($query);

if (!is_array($results1)) $results1 = array();
if (!is_array($results2)) $results2 = array();

$results = array_merge($results1, $results2);

$resultString = '<label>' . $key . '</label>';

if (count($results) > 0 && is_array($results)) {

	foreach ($results as $index => $result) {
		$resultString .= '<p>';
		$eng = json_decode(($result['eng']));

		$resultString .= @implode(', ', $eng);

		$resultString .= '</p>';

		$resultString .= '<p id="' . $result['source'] . '-' . $result['id'] .'"><a class="reportbug" rel="' . $result['source'] . '-' . $result['id'] .'" href="#">Report a bug</a></p>';
	}
} else {
	$resultString .= '<p>No result found.</p>';
}

echo $resultString;
die; 