<?php

if (!$_POST['chtoeng'] && $key != '') exit;

require $_SERVER['DOCUMENT_ROOT'] . "/config.php";


$results = $db->select('ce', 'tc LIKE :key', array(':key' => $key));


header("Content-Type: text/html; charset=utf-8");

$resultString = '<label>' . $key . '</label>';

if (count($results)) {
	foreach ($results as $index => $result) {
		$resultString .= '<p>';
		$eng = json_decode(($results['eng']));

		$resultString .= implode(', ', $eng);

		$resultString .= '</p>';
	}
} else {
	$resultString .= '<p>No result found.</p>';
}

echo $resultString;
die; 