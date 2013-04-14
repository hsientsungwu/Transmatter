<?php

if (!$_POST['chtoeng'] && $key != '') exit;

require $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$key = mysql_escape_string($key);

$resultString = '<label>' . $key . '</label>';

$results = searchForEnglish($key);

if (count($results) > 0) {
	foreach ($results as $index => $result) {
		if (empty($result)) continue;

		$eng = $result['english'];

		if ($result['format'] == DictionaryFormat::JSON) {
			$eng = json_decode($eng);
		}

		$resultString .= '<div class="dictionaryList">Source: ' . $index. '<ul>';

		foreach ($eng as $meaning) {
			$resultString .= '<li>' . $meaning . '</li>';
		}

		$resultString .= '</ul>';
		$resultString .= '<p id="ce_' . $index . '-' . $result['id'] .'"><a class="reportbug" rel="ce_' . $index . '-' . $result['id'] .'" href="#">Report a bug</a></p>';
		$resultString .= '</div>';
	}
} else {
	$resultString .= '<label>No result found.</label>';
}

echo $resultString;
die; 